<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $admin = User::factory()->create([
            'name' => 'LearnFlow Administrator',
            'email' => 'admin@learnflow.test',
            'password' => 'password',
        ]);

        $adminRole = Role::query()->where('name', RoleName::Administrator->value)->firstOrFail();

        $admin->roles()->syncWithPivotValues(
            [$adminRole->id],
            ['assigned_by' => $admin->id],
        );
    }
}
