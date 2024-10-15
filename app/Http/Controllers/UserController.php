<?php

namespace App\Http\Controllers;

//use App\Http\Requests\StoreUsersRequest;
//use App\Http\Requests\UpdateUsuariosRequest;
use App\Http\Requests\UsuariosRequest;
use App\Http\Resources\UserResource;
use App\Models\Turnos;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('turnos')->get();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsuariosRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['id_curso'] = intval($data['curso']);
        $data['id_turno'] = intval($data['turno']);

        $data['id_cargo'] = 2;

        $user = User::create($data);

        $user->turnos()->attach($data['id_turno']);

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsuariosRequest $request, User $user)
    {
        $data = $request->validated();
        $data['id_turno'] = $data['turno'] ? intval($data['turno']) : null;

        $data['id_curso'] = intval($data['curso']);

        unset($data['curso'], $data['turno']);

        $user->turnos()->detach();
        $user->turnos()->attach($data['id_turno']);

        $data['password'] = isset($data['password']) ? Hash::make($request->password) : $user->password;

        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
            if (!(is_null($user->foto_perfil))) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('images', 'public');
        } else {
            $data['foto_perfil'] = $user->foto_perfil;
        }
        $user->update($data);
        return new UserResource($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource($user);
    }
}
