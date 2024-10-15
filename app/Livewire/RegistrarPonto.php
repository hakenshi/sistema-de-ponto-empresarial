<?php

namespace App\Livewire;

use App\Models\Turnos;
use App\Models\User;
use Livewire\Component;

class RegistrarPonto extends Component
{

    public $users;
    public $turnos;
    public function mount()
    {
        $this->users = User::all();
        $this->turnos = Turnos::all();
    }

    public function render()
    {
        return view('livewire.registrar-ponto');
    }
}
