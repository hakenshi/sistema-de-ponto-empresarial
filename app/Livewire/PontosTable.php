<?php

namespace App\Livewire;

use App\Http\Resources\PontoResource;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PontosTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
    public $turnos;
    public $user;
    public $id_turno;
    public $periodo;
    protected $listeners = ['filterPontos'];


    public function mount()
    {
        $this->user = auth()->user();
        $this->turnos = $this->user->turnos;
        $this->id_turno = null;
        $this->periodo = null;
    }

    public function render()
    {
        $query = $this->user->pontos();

        if ($this->id_turno) {
            $query->where('id_turno', $this->id_turno);
        }

        if ($this->periodo) {
            $this->dateFilter($query);
        }

//        if ($this->periodo && $this->id_turno) {
//            dd($query->toSql());
//        }

        $pontos = PontoResource::collection($query->paginate());

        return view('livewire.pontos-table', [
            'pontos' => $pontos,
            'turnos' => $this->turnos
        ]);
    }
    private function dateFilter($query)
    {
        $now = Carbon::now();

        switch ($this->periodo) {
            case "hoje":
                $query->where(function ($q) use ($now) {
                    $q->whereDate('data_hora_entrada', $now)
                        ->orWhereDate('data_hora_saida', $now);
                });
                break;

            case "semana":
                $query->where(function ($q) use ($now) {
                    $q->whereBetween('data_hora_entrada', [$now->startOfWeek(), $now->endOfWeek()])
                        ->orWhereBetween('data_hora_saida', [$now->startOfWeek(), $now->endOfWeek()]);
                });
                break;

            case "mes":
                $query->where(function ($q) use ($now) {
                    $q->whereMonth('data_hora_entrada', $now->month)
                        ->whereYear('data_hora_entrada', $now->year)
                        ->orWhere(function ($q) use ($now) {
                            $q->whereMonth('data_hora_saida', $now->month)
                                ->whereYear('data_hora_saida', $now->year);
                        });
                });
                break;

            case "semestre":
                $query->where(function ($q) use ($now) {
                    $q->where('data_hora_entrada', '>=', $now->subMonths(6))
                        ->orWhere('data_hora_saida', '>=', $now->subMonths(6));
                });
                break;
        }
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

}
