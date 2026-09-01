<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            RoleName::Administrator->value => [
                'display_name' => 'Administrator',
                'description' => 'Full platform administration access.',
                'permissions' => [
                    PermissionName::UsersManage,
                    PermissionName::RolesManage,
                    PermissionName::SettingsManage,
                    PermissionName::CoursesManage,
                    PermissionName::EnrollmentsManage,
                    PermissionName::ReportsView,
                    PermissionName::AuditView,
                ],
            ],
            RoleName::Instructor->value => [
                'display_name' => 'Instructor',
                'description' => 'Teaches assigned courses.',
                'permissions' => [
                    PermissionName::CoursesTeach,
                    PermissionName::ReportsView,
                ],
            ],
            RoleName::Student->value => [
                'display_name' => 'Student',
                'description' => 'Participates in enrolled courses.',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $name => $config) {
            $role = Role::query()->updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $config['display_name'],
                    'description' => $config['description'],
                ],
            );

            $permissionIds = Permission::query()
                ->whereIn('name', array_map(
                    fn (PermissionName $permission) => $permission->value,
                    $config['permissions'],
                ))
                ->pluck('id');

            $role->permissions()->sync($permissionIds);
        }
    }
}
