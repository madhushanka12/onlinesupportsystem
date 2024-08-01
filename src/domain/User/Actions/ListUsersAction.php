<?php

namespace Domain\User\Actions;

use App\Models\User;
use Support\Helper\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\Attendance\Actions\ListAttendancesAction;
use Domain\DailyRoute\Actions\CalculateTotalDistance;

class ListUsersAction
{
    use Helper;

    public function execute(
        ?array $params = [],
    ): LengthAwarePaginator {
        $search = $params['search'] ?? null;
        $role = $params['role'] ?? null;
        $level = $params['level'] ?? null;
        $type = $params['type'] ?? null;
        $user = $params['user'] ?? null;
        $date = $params['date'] ?? null;
        $userRole = null;

        $attendanceParams = [
            'user' => $user,
            'date' => $date,
        ];

        $attendance = (new ListAttendancesAction())->execute($attendanceParams)->first();

        $totalDistance = (new CalculateTotalDistance())->execute((int) $params['user'], $date);
        if ($user) {
            $userRole = User::query()->where('id', $user)->first()->roles[0]->id;
        }

        $setting = settings('ta-da', $userRole)->first();

        return User::query()
            ->with(['roles', 'modifiedBy', 'addedBy', 'region', 'area', 'city', 'children', 'parent'])
            ->whereHas('roles', function (Builder $builder) {
                return $builder->whereNotIn('name', ['master', 'super-admin', 'admin']);
            })
            ->when(auth()->user()->type === 'erp', function (Builder $builder) {
                return $builder->whereHas('roles', function (Builder $builder) {
                    return $builder->whereNotIn('name', ['driver', 'dealer', 'customer']);
                });
            })
            ->when(auth()->user()->type === 'sfa', function (Builder $builder) {
                return $builder->whereHas('roles', function (Builder $builder) {
                    return $builder->whereNotIn('name', [
                        'call-center',
                        'regional-sales-manager',
                        'area-sales-manager',
                        'sales-officer',
                        'sales-representative',
                    ]);
                });
            })
            ->when($user, function (Builder $builder) use ($user) {
                return $builder->where('id', $user);
            })
            ->when($role, function (Builder $builder) use ($role) {
                return $builder->whereHas('roles', function (Builder $builder) use ($role) {
                    $builder->where('name', $role);
                });
            })
            ->when($level, function (Builder $builder) use ($level) {
                return $builder->whereHas('roles', function (Builder $builder) use ($level) {
                    $builder->where('name', $this->getTopLevelRole($level));
                });
            })
            ->when($search, function (Builder $builder) use ($search) {
                return $builder
                    ->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })
            ->when($type, function (Builder $builder) use ($type) {
                return $builder->when($type === 'pending', function (Builder $builder) {
                    return $builder->where('is_assigned', false);
                })->when($type === 'assigned', function (Builder $builder) {
                    return $builder->where('is_assigned', true);
                });
            })
            ->latest('created_at')
            ->paginate($params['limit'] ?? 20)
            ->withQueryString()
            ->through(function ($user) use ($date, $attendance, $totalDistance, $setting) {
                return $this->userData($user, $date, $attendance, $totalDistance, $setting);
            });
    }

    public function children($user, ?array $date = null): array
    {
        return $user->children ? collect($user->children)->map(function ($child) use ($date) {
            $params = [
                'user' => $child->id,
                'date' => $date,
            ];

            $setting = settings('ta-da', $child->roles[0]->id)->first();

            $attendance = (new ListAttendancesAction())->execute($params)->first();

            $totalDistance = (new CalculateTotalDistance())->execute((int) $params['user'], $params['date']);

            return [
                'id' => $child->id,
                'name' => $child->name,
                'role' => $child->roles[0]->display_name,
                'roleSlug' => $child->roles[0]->name,
                'avatar' => $child->avatar ? imageCheck('user-details/'.$child->avatar) : asset('images/not_found.png'),
                'children' => $this->children($child),
                'todayEarning' => [
                    'transportAllowances' => (float) ($totalDistance * $setting->transport_allowances),
                    'dailyAllowances' => (float) $setting->daily_allowances,
                ],
                'totalDistance' => [
                    'value' => $totalDistance,
                    'unit' => 'KM',
                ],
                'attendance' => $attendance ? [
                    'isClockIn' => $attendance['clockInAt'] !== null,
                    'isClockOut' => $attendance['clockInAt'] === null,
                    'clockInAt' => $attendance['clockInAt'],
                    'clockOutAt' => $attendance['clockOutAt'],
                    'latitude' => $attendance['latitude'],
                    'longitude' => $attendance['longitude'],
                ] : 'No data found',
            ];
        })->toArray() : [];
    }

    public function userData($user, mixed $date, $attendance, float $totalDistance, $setting): array
    {
        return [
            'value' => $user->id,
            'label' => $user->name,
            'id' => $user->id,
            'role' => $user->roles[0]->display_name,
            'roleSlug' => $user->roles[0]->name,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'referenceName' => $user->reference_name,
            'alternativeNumber' => $user->alternative_number,
            'parent' => $user->parent ? [
                'id' => $user->parent->parent_id,
                'name' => findUserById($user->parent->parent_id)->name,
            ] : null,
            'children' => $this->children($user, $date),
            'region' => $user->region ? [
                'id' => $user->region->id,
                'title' => $user->region->title,
                'slug' => $user->region->slug,
            ] : null,
            'area' => $user->area ? [
                'id' => $user->area->id,
                'title' => $user->area->title,
                'slug' => $user->area->slug,
                'region' => $user->area->region ? [
                    'id' => $user->area->region->id,
                    'title' => $user->area->region->title,
                    'slug' => $user->area->region->slug,
                ] : null,
            ] : null,
            'city' => $user->city ? [
                'id' => $user->city->id,
                'title' => $user->city->title,
                'slug' => $user->city->slug,
                'area' => $user->city->area ? [
                    'id' => $user->city->area->id,
                    'title' => $user->city->area->title,
                    'slug' => $user->city->area->slug,
                    'region' => $user->city->area->region ? [
                        'id' => $user->city->area->region->id,
                        'title' => $user->city->area->region->title,
                        'slug' => $user->city->area->region->slug,
                    ] : null,
                ] : null,
            ] : null,
            'attendance' => $attendance ? [
                'isClockIn' => $attendance['clockInAt'] !== null,
                'isClockOut' => $attendance['clockInAt'] === null,
                'clockInAt' => $attendance['clockInAt'],
                'clockOutAt' => $attendance['clockOutAt'],
                'latitude' => $attendance['latitude'],
                'longitude' => $attendance['longitude'],
            ] : 'No data found',
            'todayEarning' => [
                'transportAllowances' => (float) ($totalDistance * $setting->transport_allowances),
                'dailyAllowances' => (float) $setting->daily_allowances,
            ],
            'totalDistance' => [
                'value' => $totalDistance,
                'unit' => 'KM',
            ],
            'avatar' => $user->avatar ? imageCheck('user-details/'.$user->avatar) : asset('images/not_found.png'),
            'panCard' => imageCheck('user-details/'.$user->pan_card),
            'isActive' => $user->is_active,
            'isAssigned' => $user->is_assigned,
        ];
    }
}
