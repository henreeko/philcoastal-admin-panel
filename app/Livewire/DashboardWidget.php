<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DashboardWidget extends Component
{
    public $userCount;

    public function mount()
    {
        $this->userCount = User::count();
    }

    public function render()
    {
        return view('livewire.dashboard-widget');
    }
}
