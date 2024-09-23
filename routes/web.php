<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
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
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::get('/home', function () {
            $user = auth()->user();
            $ponto = $user->pontos->first();
            $ultimoPonto = $ponto ? ($ponto->data_hora_saida ?: $ponto->data_hora_entrada) : null;

            return view('user.home')->with(['ultimoPonto' => $ultimoPonto ? Carbon::parse($ultimoPonto)->format('d/m/Y, H:i') : "Sem Pontos"]);
        })->name('home');

        Route::get('/meus-pontos', function () {
            return view('user.meus-pontos');
        })->name('meus-pontos');

    });
});

Route::get('/', function () {
    return redirect()->route('login');
});
