<?php

namespace App\Http\Controllers;

use App\Http\Resources\PontoResource;
use App\Models\Pontos;
use App\Models\Turnos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PontosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PontoResource(Pontos::with('usuario')->get());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storeAdmin(Request $request)
    {
        $data = $request->validate([
            'usuario' => 'required|exists:users,id',
            'turno' => 'required|exists:turnos,id',
            'data' => 'required',
        ]);
        $turno = Turnos::findOrFail($data['turno']);

        $dataHoraEntrada = Carbon::createFromFormat('d/m/Y H:i:s', "{$data['data']} $turno->hora_entrada")->format('Y-m-d H:i:s');
        $dataHoraSaida = Carbon::createFromFormat('d/m/Y H:i:s', "{$data['data']} $turno->hora_saida")->format('Y-m-d H:i:s');


        $pontoExistente = Pontos::where('id_usuario', $data['usuario'])
            ->where('id_turno', $data['turno'])
            ->whereDate('data_hora_entrada', Carbon::createFromFormat('d/m/Y', $data['data'])->format('Y-m-d'))
            ->exists();

        if ($pontoExistente) {
            throw ValidationException::withMessages([
                'usuario' => 'Esse usuário já tem um ponto registrado para esta data.'
            ]);
        }

        Pontos::create([
            'id_usuario' => $data['usuario'],
            'id_turno' => $data['turno'],
            'data_hora_entrada' => $dataHoraEntrada,
            'data_hora_saida' => $dataHoraSaida,
        ]);
        return back();
    }

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
                ->whereNull('data_hora_saida')
                ->first();

            $pontoExistente = Pontos::where('id_usuario', $user->id)
                ->where('id_turno', $turnoAtual->id)
                ->where('data_hora_entrada', "<=", now())
                ->where('data_hora_saida', "<=", now())
                ->first();

            if ($pontoExistente) {
                return response()->json([
                    'message' => 'Turno completado, até o próximo turno!'
                ]);
            }

            if (!$pontoEntrada && Carbon::now()->greaterThan(Carbon::parse($turnoAtual->hora_entrada))) {
                $ponto = Pontos::create([
                    'id_usuario' => $user->id,
                    'id_turno' => $turnoAtual->id,
                    'data_hora_entrada' => now(),
                ]);
                return new PontoResource($ponto);
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
        return new PontoResource($pontos->with('usuario')->get());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pontos $pontos)
    {
        $data = $request->validate([
            'usuario' => 'required|exists:users,id',
            'turno' => 'required|exists:turnos,id',
            'data' => 'required',
            "hora-entrada" => "required",
            "hora-saida" => "required",
        ]);
        $data['data_hora_entrada'] = Carbon::createFromFormat('d/m/Y H:i:s', "{$data['data']} {$data['hora-entrada']}")->format('Y-m-d H:i:s');
        $data['data_hora_saida'] = Carbon::createFromFormat('d/m/Y H:i:s', "{$data['data']} {$data['hora-saida']}")->format('Y-m-d H:i:s');
        $data['id_usuario'] = $data['usuario'];
        $data['id_turno'] = $data['turno'];
        unset($data['usuario'], $data['turno'], $data['data'], $data['hora-entrada'], $data['hora-saida']);
        $pontos->update($data);
        return new PontoResource($pontos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pontos $pontos)
    {
        $pontos->delete();
        return new PontoResource($pontos->with('usuario')->get());
    }
}
