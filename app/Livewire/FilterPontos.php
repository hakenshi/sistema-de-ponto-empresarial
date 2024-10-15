<?php

namespace App\Livewire;

use App\Models\Turnos;
use Livewire\Component;

class FilterPontos extends Component
{
    public $turnos;
    public $id_turno;
    public $periodo;

    public function mount(){
        $this->turnos = auth()->user()->id_cargo === 1 ? Turnos::all() : auth()->user()->turnos;
    }

    public function render()
    {
        return view('livewire.filter-turnos');
    }

    public function filter()
    {
        $this->dispatch('filterPontos', id_turno: $this->id_turno, periodo: $this->periodo);
    }

}
