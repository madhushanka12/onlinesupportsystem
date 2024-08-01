<?php

namespace Domain\User\ViewModels;

use App\Models\User;
use Spatie\ViewModels\ViewModel;

class UserCreateEditViewModel extends ViewModel
{
    public function __construct(
        public ?User $oldUser = null
    ) {
    }

    public function user(): array
    {
        return [
            'id' => $this->oldUser?->id,
            'name' => $this->oldUser->name ?? '',
            'displayName' => $this->oldUser->display_name ?? '',
        ];
    }
}
