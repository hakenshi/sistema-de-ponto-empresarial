<?php

namespace App\Livewire;

use App\Models\Cursos;
use App\Models\Turnos;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;
    public $user;
    public function render()
    {
        $users = User::paginate(9);
        $cursos = Cursos::all();
        $turnos = Turnos::all();
        return view('livewire.users-table', compact('users', 'cursos', 'turnos'));
    }

    public function loadUser($id)
    {
        if (!$id) {
            $this->user = null;
        } else {
            $this->user = User::findOrFail($id);
        }
    }

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();
        return back();
    }

    public function destroy(User $id)
    {
        $id->delete();
        return back();
    }

}
