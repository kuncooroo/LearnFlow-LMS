<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class FoundationStatus extends Component
{
    public int $clicks = 0;

    public function increment(): void
    {
        $this->clicks++;
    }

    public function render()
    {
        return view('livewire.shared.foundation-status')
            ->layout('layouts.guest', [
                'title' => 'LearnFlow LMS',
            ]);
    }
}
