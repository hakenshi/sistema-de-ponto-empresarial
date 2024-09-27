<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Resources\PontoResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login.page');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    Route::get('/home', function () {
        $user = auth()->user();
        $ponto = $user->pontos->first();
        $ultimoPonto = $ponto ? ($ponto->data_hora_saida ?: $ponto->data_hora_entrada) : null;
        $agora = Carbon::now();
        $proximoTurno = $user
            ->turnos()
            ->where('hora_entrada', '<=', $agora->format('H:i:s'))
            ->where('hora_saida', '>=', $agora->format('H:i:s'))
            ->first();
        if (!$proximoTurno) {
            $proximoTurno = $user
                ->turnos()
                ->where('hora_entrada', '>=', $agora->format('H:i:s'))
                ->orderBy('hora_entrada', 'asc')
                ->first();
        }
        return view('user.home')->with([
            'ultimoPonto' => $ultimoPonto ? Carbon::parse($ultimoPonto)->format('d/m/Y, H:i') : "Sem Pontos",
            'proximoTurno' => [
                'hora_entrada' => Carbon::parse($proximoTurno->hora_entrada)->format('H:i'),
                'hora_saida' => Carbon::parse($proximoTurno->hora_saida)->format('H:i'),
            ]
        ]);
    })->name('home');

    Route::get('/meus-pontos', function () {
        $user = auth()->user();
        $pontos = PontoResource::collection($user->pontos()->paginate());
        return view('user.meus-pontos')->with(['pontos' => $pontos, 'turnos' => $user->turnos]);
    })->name('meus-pontos');

    //
//    Route::middleware(UserMiddleware::class)->group(function () {
//
//
//    });
});

Route::get('/', function () {
    return redirect()->route('login');
});
