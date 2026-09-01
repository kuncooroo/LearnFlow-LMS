<?php

namespace Tests\Feature\Admin\Users;

use App\Enums\UserStatus;
use App\Livewire\Admin\Users\ShowUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\RequiresDatabase;
use Tests\Concerns\SeedsRolesAndPermissions;
use Tests\TestCase;

class UserStatusTest extends TestCase
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

    public function test_admin_can_deactivate_user_without_deleting_record(): void
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->student()->create(['email' => 'deactivate@example.com']);

        Livewire::actingAs($admin)
            ->test(ShowUser::class, ['user' => $user])
            ->call('confirmStatusChange')
            ->call('toggleStatus')
            ->assertSet('user.status', UserStatus::Inactive);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'deactivate@example.com',
            'status' => UserStatus::Inactive->value,
        ]);
    }

    public function test_admin_cannot_deactivate_self(): void
    {
        $admin = User::factory()->administrator()->create();

        Livewire::actingAs($admin)
            ->test(ShowUser::class, ['user' => $admin])
            ->call('confirmStatusChange')
            ->call('toggleStatus')
            ->assertHasErrors(['status']);
    }

    public function test_admin_cannot_deactivate_last_active_administrator(): void
    {
        $admin = User::factory()->administrator()->create();

        Livewire::actingAs($admin)
            ->test(ShowUser::class, ['user' => $admin])
            ->call('confirmStatusChange')
            ->call('toggleStatus')
            ->assertHasErrors(['status']);

        $this->assertTrue($admin->fresh()->isActive());
    }
}
