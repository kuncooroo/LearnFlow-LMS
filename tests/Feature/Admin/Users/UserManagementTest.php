<?php

namespace Tests\Feature\Admin\Users;

use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\RequiresDatabase;
use Tests\Concerns\SeedsRolesAndPermissions;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;
    use RequiresDatabase;
    use SeedsRolesAndPermissions;

    protected function setUp(): void
    {
        $this->skipIfDatabaseUnavailable();

        parent::setUp();

        $this->seedRolesAndPermissions();
    }

    public function test_admin_can_view_user_index(): void
    {
        $admin = User::factory()->administrator()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Users');
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->administrator()->create();
        $studentRole = Role::query()->where('name', RoleName::Student->value)->firstOrFail();

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users\UserForm::class)
            ->set('name', 'New Student')
            ->set('email', 'student@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('status', UserStatus::Active->value)
            ->set('role_id', $studentRole->id)
            ->call('save')
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'student@example.com',
            'status' => UserStatus::Active->value,
        ]);
    }

    public function test_duplicate_email_is_rejected_on_create(): void
    {
        $admin = User::factory()->administrator()->create();
        $existing = User::factory()->student()->create(['email' => 'taken@example.com']);
        $studentRole = Role::query()->where('name', RoleName::Student->value)->firstOrFail();

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users\UserForm::class)
            ->set('name', 'Duplicate User')
            ->set('email', 'taken@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('status', UserStatus::Active->value)
            ->set('role_id', $studentRole->id)
            ->call('save')
            ->assertHasErrors(['email']);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->student()->create([
            'name' => 'Old Name',
            'email' => 'update@example.com',
        ]);
        $instructorRole = Role::query()->where('name', RoleName::Instructor->value)->firstOrFail();

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users\UserForm::class, ['user' => $user])
            ->set('name', 'Updated Name')
            ->set('email', 'update@example.com')
            ->set('role_id', $instructorRole->id)
            ->call('save')
            ->assertRedirect(route('admin.users.show', $user));

        $user->refresh();
        $this->assertSame('Updated Name', $user->name);
        $this->assertTrue($user->hasRole(RoleName::Instructor));
    }

    public function test_user_search_and_pagination_work(): void
    {
        $admin = User::factory()->administrator()->create();
        User::factory()->student()->create(['name' => 'Alpha Student', 'email' => 'alpha@example.com']);
        User::factory()->student()->create(['name' => 'Beta Student', 'email' => 'beta@example.com']);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Users\UserIndex::class)
            ->set('search', 'Alpha')
            ->assertSee('Alpha Student')
            ->assertDontSee('Beta Student');
    }
}
