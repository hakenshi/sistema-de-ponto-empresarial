<?php

namespace App\Livewire;

use App\Http\Resources\PontoResource;
use App\Models\Pontos;
use App\Models\Turnos;
use App\Models\User;
use App\Utils;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PontosTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $turnos;
    public $user;
    public $users;
    public $id_turno;
    public $periodo;
    public $editPonto;
    protected $listeners = ['filterPontos'];


    public function mount()
    {
        $this->user = auth()->user();
        if ($this->user->id_cargo == 2) {
            $this->turnos = $this->user->turnos;
        }
        $this->turnos = Turnos::all();
        $this->id_turno = null;
        $this->periodo = null;
    }

    public function render()
    {

        if ($this->user->id_cargo === 2) {
            $query = $this->user->pontos();
        } else {
            $query = Pontos::query()->with('usuario');
        }
        if ($this->id_turno) {
            $query->where('id_turno', $this->id_turno);
        }

        if ($this->periodo) {
            Utils::dateFilter($query, $this->periodo);
        }

        $pontos = PontoResource::collection($query->paginate());

        return view('livewire.pontos-table', [
            'pontos' => $pontos,
            'turnos' => $this->turnos
        ]);
    }



    public function filterPontos($id_turno, $periodo)
    {
        if ($id_turno) {
            $this->id_turno = $id_turno;
        } else {
            $this->id_turno = null;
        }

        if ($periodo) {
            $this->periodo = $periodo;
        } else {
            $this->periodo = null;
        }
    }

    public function loadPonto($id)
    {
        if ($id) {
            $this->editPonto = Pontos::findOrFail($id);
            $this->users = User::all();
        } else {
            $this->editPonto = null;
            $this->users = null;
        }
    }

    public function deletePonto($id)
    {
        Pontos::findOrFail($id)->delete();
        $this->resetPage();
        $this->render();
        $this->dispatch('$refresh');
    }

}
