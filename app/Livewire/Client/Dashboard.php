<?php

namespace App\Livewire\Client;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {
        Auth::logout();
    }

    public function render()
    {
        return view('livewire.client.dashboard');
    }
}
