<?php

namespace App\Livewire;

use App\Exports\PontosExport;
use App\Models\Pontos;
use App\Utils;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel as MaatExcel;
class Excel extends Component
{

    public $user = '';
    public $turno = '';
    public $periodo = '';

    public function render()
    {
        return view('livewire.excel');
    }
}