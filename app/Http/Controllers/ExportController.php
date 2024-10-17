<?php

namespace App\Http\Controllers;

use App\Exports\PontosExport;
use App\Models\Pontos;
use App\Utils;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as MaatExcel;

class ExportController extends Controller
{
    public function exportPontos(Request $request)
    {
        $data = $request->validate([
            'user' => 'nullable|exists:users,id',
            'periodo' => 'nullable',
            'turno' => 'nullable|exists:turnos,id',
        ]);

        $query = Pontos::query();

        if ($data['user']) {
            $query->where('id_usuario', $data['user']);
        }
        if ($data['turno']) {
            $query->where('id_turno', $data['turno']);
        }
        if ($data['periodo']) {
            Utils::dateFilter($query, $data['periodo']);
        }

        return MaatExcel::download(new PontosExport($query->get()), 'pontos.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
