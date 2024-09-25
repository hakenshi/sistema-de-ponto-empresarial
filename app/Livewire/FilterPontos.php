<?php

namespace App\Livewire;

use Livewire\Component;

class FilterPontos extends Component
{
    public $turnos;
    public $id_turno;
    public $periodo;

    public function mount(){
        $this->turnos = auth()->user()->turnos;
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
