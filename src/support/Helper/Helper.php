<?php

namespace Support\Helper;

use Exception;
use Intervention\Image\ImageManager;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\isEmpty;

trait Helper
{
    public function imageCheck(
        string $path,
        ?string $default = 'assets/template/images/not-found.png'
    ): string {
        return Storage::disk('public')->exists($path) ? asset('storage/'.$path) : asset($default);
    }

    public function displayPrice(float|int $price): string
    {
        return displayPrice($price);
    }

    public function getCurrentRoute(): object|string|null
    {
        return Request::route();
    }

    public function roles(?string $role = 'admin'): bool|int|string
    {
        $roles = [
            slugGenerator('Master') => slugGenerator('Master'),
            slugGenerator('Super Admin') => slugGenerator('Super Admin'),
            slugGenerator('Admin') => slugGenerator('Admin'),
        ];

        return array_search($role, $roles, true);
    }

    public function throwable(Exception|Throwable $exception): JsonResponse|RedirectResponse
    {
        if ($this->requestTypeCheck()) {
            return response()->json([
                'status' => false,
                'message' => [
                    'title' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'previous' => $exception->getPrevious(),
                ],
            ], 500);
        }

        return redirect()->back()->withFlash([
            'type' => 'error',
            'title' => 'Exception Occur',
            'message' => [
                'title' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'previous' => $exception->getPrevious(),
            ],
        ]);
    }

    public function requestTypeCheck(
        string $type = 'api'
    ): bool {
        return in_array($type, request()->route()->getAction('middleware'), true);
    }

    public function months(): array
    {
        $month = [];

        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }

        return $month;
    }protected function saveFile(
    mixed $model,
    ?UploadedFile $uploadedLogo = null,
    ?string $columnName = 'image',
    ?string $destination = null,
    ?string $customFileName = null,
    ?array $sizes = [],
): ?string {
    if (! $uploadedLogo) {
        return $model[$columnName];
    }

    folderTypes()->each(function ($folder) use ($columnName, $model, $destination) {
        $this->deleteFileIfExists($destination . $folder . '/' . $model[$columnName]);
    });

    $fileName = $this->generateSlug($columnName).'-'.($customFileName !== null ? $this->generateSlug($customFileName).'-' : '').uniqid('', true).'.'.$uploadedLogo->extension();

    if(!isEmpty($sizes)) {
        foreach ($sizes as $size => $dims) {
            $image = ImageManager::gd()->read($uploadedLogo->getRealPath());

            $image->scaleDown($dims['width'], $dims['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save(storage_path('app/public/' . $destination . $size . '/' . $fileName), 60);
        }
    } else {
        folderTypes()->each(function ($folder) use ($fileName, $uploadedLogo, $destination) {
            $uploadedLogo->storeAs(
                'public/' . $destination . $folder . '/' ,
                $fileName
            );
        });
    }


    return $fileName;
}

    public function deleteFileIfExists(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function generateSlug(string $string): string
    {
        return Str::slug($string);
    }

    protected function getIp(): ?string
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function shiftTime(): array
    {
        $startAt = Carbon::createFromFormat('Y-m-d H:i:s', today()->format('Y-m-d').' '.env('SHIFT_START_AT'));
        $endAt = Carbon::createFromFormat('Y-m-d H:i:s', today()->format('Y-m-d').' '.env('SHIFT_START_AT'))->addHours(9);

        return [
            'startAt' => $startAt,
            'endAt' => $endAt,
        ];
    }

    public function convertToCarbonFormat($timestamp): Carbon
    {
        return Carbon::parse($timestamp);
    }

    public function dateFilter(
        Builder $builder,
        string $type,
        array $date,
        string $column = 'date'
    ): Builder {
        $from = Carbon::parse($date['from'])->format('Y-m-d');
        $fromCarbonFormat = Carbon::parse($from);

        return $builder->when($type === 'single', function (Builder $builder) use ($column, $from) {
                return $builder->whereDate($column, $from);
            })
            ->when($type === 'range', function (Builder $builder) use ($column, $date, $from) {
                $to = Carbon::parse($date['to'])->format('Y-m-d');

                return $builder->whereBetween($column, [$from, $to]);
            })
            ->when($type === 'thisWeek', function (Builder $builder) use ($column, $fromCarbonFormat) {
                return $builder->whereBetween($column, [$fromCarbonFormat->startOfWeek(), $fromCarbonFormat->endOfWeek()]);
            })
            ->when($type === 'thisMonth', function (Builder $builder) use ($column, $fromCarbonFormat) {
                return $builder->whereBetween($column, [$fromCarbonFormat->startOfMonth(), $fromCarbonFormat->endOfMonth()]);
            })
            ->when($type === 'thisYear', function (Builder $builder) use ($column, $fromCarbonFormat) {
                return $builder->whereBetween($column, [$fromCarbonFormat->startOfYear(), $fromCarbonFormat->endOfYear()]);
            });
    }

    public function validateDateParam($params, $dateType): ?JsonResponse
    {
        if (! in_array($dateType, ['single', 'thisWeek', 'thisMonth', 'thisYear'])) {
            if (! array_key_exists('to', $params['date'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please provide the [to] key in date parameter',
                ]);
            }
        } elseif (! array_key_exists('from', $params['date'])) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide the [from] key in date parameter',
            ]);
        }

        return null;
    }

    public function getAgeFromDOB(string $dob): int
    {
        return now()->diffInYears($dob);
    }
}
