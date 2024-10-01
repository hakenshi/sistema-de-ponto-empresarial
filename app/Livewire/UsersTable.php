<?php

namespace App\Livewire;

use App\Models\Cursos;
use App\Models\User;
use Livewire\Component;

class UsersTable extends Component
{
    public $user;
    public $turnos;

    public function render()
    {
        $users = User::paginate();
        $cursos = Cursos::all();
        return view('livewire.users-table', compact('users', 'cursos'));
    }

    public function loadUser($id)
    {
        if (!$id) {
            $this->user = null;
        } else {
            $this->user = User::findOrFail($id);
        }
    }

    public function setTurnos($id)
    {
        $this->turnos = User::findOrFail($id)->turnos;
    }

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return back();
    }

}
