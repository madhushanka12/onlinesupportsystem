<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => $this->faker->phoneNumber(),
            'password' => Hash::make('12'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'is_active' => true,
            'modified_by' => 1,
            'added_by' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
//    public function withPersonalTeam($teamName = null, callable $callback = null): static
//    {
//        if (! Features::hasTeamFeatures()) {
//            return $this->state([]);
//        }
//
//        return $this->has(
//            Team::factory()
//                ->state(function (array $attributes, User $user) use ($teamName) {
//                    return [
//                        'user_id' => $user->id,
//                        'name' => $teamName ?? $user->name.'\'s Team',
//                        'personal_team' => true,
//                    ];
//                })
//                ->when(is_callable($callback), $callback),
//            'ownedTeams'
//        );
//    }
}
