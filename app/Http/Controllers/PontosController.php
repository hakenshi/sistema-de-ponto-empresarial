<?php

namespace App\Http\Controllers;

use App\Http\Requests\PontoRequest;
use App\Http\Resources\PontoResource;
use App\Models\Pontos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PontosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pontos::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = $request->user();
            $turnos = $user->turnos;
            $turnoAtual = null;

            foreach ($turnos as $turno) {
                $inicioTurno = Carbon::parse($turno->hora_entrada);
                $fimTurno = Carbon::parse($turno->hora_saida);

                if (Carbon::now()->between($inicioTurno, $fimTurno)) {
                    $turnoAtual = $turno;
                    break;
                }
            }

            if (!$turnoAtual) return response()->json([
                'message' => "Nenhum turno encontrado para o horário atual."
            ], 404);

            $pontoEntrada = Pontos::where('id_usuario', $user->id)
                ->where('id_turno', $turnoAtual->id)
                ->whereNotNull('data_hora_entrada')
                ->whereNull('data_hora_saida')
                ->first();

            $pontoExistente = Pontos::where('id_usuario', $user->id)
                ->where('id_turno', $turnoAtual->id)
                ->whereNotNull('data_hora_entrada')
                ->whereNotNull('data_hora_saida')
                ->exists();

            if ($pontoExistente) {
                return response()->json([
                    'message' => 'Turno completado, até o próximo turno!'
                ]);
            }

            if ($pontoEntrada) {
                $pontoEntrada->update(['data_hora_saida' => now()]);
                return new PontoResource($pontoEntrada);
            } else {
                $ponto = Pontos::create([
                    'id_usuario' => $user->id,
                    'id_turno' => $turnoAtual->id,
                    'data_hora_entrada' => now(),
                ]);
                return new PontoResource($ponto);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pontos $pontos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pontos $pontos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pontos $pontos)
    {
        //
    }
}
