<?php

namespace Tests\Livewire\Shared;

use App\Livewire\Shared\FoundationStatus;
use Livewire\Livewire;
use Tests\TestCase;

class FoundationStatusTest extends TestCase
{
    public function test_component_renders(): void
    {
        Livewire::test(FoundationStatus::class)
            ->assertSee('Laravel modular monolith is online.')
            ->assertSee('Livewire click test');
    }

    public function test_component_increments_server_side_counter(): void
    {
        Livewire::test(FoundationStatus::class)
            ->assertSet('clicks', 0)
            ->call('increment')
            ->assertSet('clicks', 1);
    }
}
