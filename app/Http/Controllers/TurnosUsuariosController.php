<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Turnos;
use App\Models\TurnosUsuarios;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TurnosUsuariosController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_turno' => 'required|exists:turnos,id',
        ]);

        $user = User::findOrFail($data['id_usuario']);
        $turnoExistente = $user->turnos->where('id', $data['id_turno'])->first();
        $turnoNovo = Turnos::findOrFail($data['id_turno']);
        if ($turnoExistente) {
            return response()->json(['message' => "O funcionario, $user->nome, já tem este turno cadastrado."], 422);
        }

        foreach ($user->turnos as $turno) {
            $inicioTurnoExistente = Carbon::parse($turno->hora_entrada);
            $fimTurnoExistente = Carbon::parse($turno->hora_saida);

            $inicioNovoTurno = Carbon::parse($turnoNovo->hora_entrada);
            $fimNovoTurno = Carbon::parse($turnoNovo->hora_saida);

            if ($inicioNovoTurno < $fimTurnoExistente && $fimNovoTurno > $inicioTurnoExistente) {
                return response()->json([
                   'message' => 'Não foi possível atribuir este turno a este funcionário, pois, este turno sobrepõe um turno do funcionário',
                    'turno_existente' =>[
                        'id' => $turno->id,
                        'hora_entrada' => $turno->hora_entrada,
                        'hora_saida' => $turno->hora_saida,
                    ]
                ]);
            }
        }


        $user->turnos()->attach($data['id_turno']);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $turnosUsuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TurnosUsuarios $turnosUsuarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TurnosUsuarios $turnosUsuarios)
    {
        //
    }
}
