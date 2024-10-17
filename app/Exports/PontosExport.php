<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PontosSheet implements FromArray
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $data = [];
        $data[] = ['Nome do Usuário', 'Turno', 'Data', 'Hora de Entrada', 'Hora de Saída'];

        foreach ($this->data as $ponto) {
            $data[] = [
                $ponto->usuario->nome,
                "{$ponto->turnos->hora_entrada} - {$ponto->turnos->hora_saida}",
                Carbon::createFromFormat('Y-m-d H:i:s', $ponto->data_hora_entrada)->format('d/m/Y'),
                Carbon::createFromFormat('Y-m-d H:i:s', $ponto->data_hora_entrada)->format('H:i:s'),
                Carbon::createFromFormat('Y-m-d H:i:s', $ponto->data_hora_entrada)->format('H:i:s'),
                $ponto->data_hora_saida ? Carbon::createFromFormat('Y-m-d H:i:s', $ponto->data_hora_saida)->format('H:i:s') : "Sem Registro",
            ];
        }

        return $data;
    }
}

class PontosExport implements WithMultipleSheets
{
    protected $pontos;

    public function __construct($pontos)
    {
        $this->pontos = $pontos;
    }

    public function sheets(): array
    {
        $sheets[] = new PontosSheet($this->pontos);
        return $sheets;
    }
}


