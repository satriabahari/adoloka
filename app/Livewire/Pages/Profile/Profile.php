<?php

namespace App\Livewire\Pages\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;
use function Livewire\Volt\layout;

class Profile extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.profile.profile');
    }
}
