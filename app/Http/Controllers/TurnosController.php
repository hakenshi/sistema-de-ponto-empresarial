<?php

namespace App\Http\Controllers;

use App\Http\Resources\TurnosResource;
use App\Models\Turnos;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return TurnosResource::collection(Turnos::all());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_saida' => 'required|date_format:H:i:s',
        ]);

        $exists = Turnos::where("hora_entrada", $data['hora_entrada'])->where("hora_saida", $data['hora_saida'])->exists();

        if ($exists) {
            return response()->json(["message" => "Esse turno já existe"], 400);
        }

        $turno = Turnos::create($data);

        return new TurnosResource($turno);
    }

    /**
     * Display the specified resource.
     */

    public function show(Turnos $turno)
    {
        return new TurnosResource($turno);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Turnos $turno)
    {
        $data = $request->validate([
            'hora_entrada' => 'nullable',
            'hora_saida' => 'nullable',
        ]);
        $turno->update($data);

        return new TurnosResource($turno);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Turnos $turnos)
    {
        $turnos->delete();
        return new TurnosResource($turnos);
    }
}
