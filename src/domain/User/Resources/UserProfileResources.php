<?php

namespace Domain\User\Resources;

use Domain\Address\Resources\AddressResources;
use Illuminate\Http\Request;
use Domain\User\Actions\ListUsersAction;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role' => $this->roles[0]->name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'referenceName' => $this->reference_name,
            'alternativeNumber' => $this->alternative_number,
            'parent' => $this->parent ? [
                'id' => $this->parent->parent_id,
                'name' => findUserById($this->parent->parent_id)->name,
            ] : null,
            'addresses' => $this->addresses ? collect($this->addresses)->map(function ($address) {
                return AddressResources::make($address);
            }) : [],
            'children' => (new ListUsersAction())->children($this),
            'region' => $this->region ? [
                'id' => $this->region->id,
                'title' => $this->region->title,
                'slug' => $this->region->slug,
            ] : null,
            'area' => $this->area ? [
                'id' => $this->area->id,
                'title' => $this->area->title,
                'slug' => $this->area->slug,
                'region' => $this->area->region ? [
                    'id' => $this->area->region->id,
                    'title' => $this->area->region->title,
                    'slug' => $this->area->region->slug,
                ] : null,
            ] : null,
            'city' => $this->city ? [
                'id' => $this->city->id,
                'title' => $this->city->title,
                'slug' => $this->city->slug,
                'area' => $this->city->area ? [
                    'id' => $this->city->area->id,
                    'title' => $this->city->area->title,
                    'slug' => $this->city->area->slug,
                    'region' => $this->city->area->region ? [
                        'id' => $this->city->area->region->id,
                        'title' => $this->city->area->region->title,
                        'slug' => $this->city->area->region->slug,
                    ] : null,
                ] : null,
            ] : null,
//            'attendance' => $attendance ? [
//                'isClockIn' => $attendance['clockInAt'] !== null,
//                'isClockOut' => $attendance['clockInAt'] === null,
//                'clockInAt' => $attendance['clockInAt'],
//                'clockOutAt' => $attendance['clockOutAt'],
//                'latitude' => $attendance['latitude'],
//                'longitude' => $attendance['longitude'],
//            ] : 'No data found',
//            'todayEarning' => [
//                'transportAllowances' => (float) ($totalDistance * $setting->transport_allowances),
//                'dailyAllowances' => (float) $setting->daily_allowances,
//            ],
//            'totalDistance' => [
//                'value' => $totalDistance,
//                'unit' => 'KM',
//            ],
            'avatar' => $this->avatar ? imageCheck('user-details/'.$this->avatar) : asset('images/not_found.png'),
            'panCard' => imageCheck('user-details/'.$this->pan_card),
            'isActive' => $this->is_active,
            'isAssigned' => $this->is_assigned,
        ];
    }
}
