<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PontosController;
use App\Http\Controllers\TurnosController;
use App\Http\Controllers\TurnosUsuariosController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::prefix('/users')->group(function () {
            Route::put('/{user}', [UserController::class, 'update']);
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::delete('/{user}', [UserController::class, 'destroy']);
        });

        Route::prefix('pontos')->group(function () {
            Route::delete('/', [PontosController::class, 'store']);
            Route::patch('/', [PontosController::class, 'update']);
            Route::get('/', [PontosController::class, 'index']);
        });

        Route::prefix('turnos')->group(function () {
            Route::get('/', [TurnosController::class, 'index']);
            Route::get('/{turno}', [TurnosController::class, 'show']);
            Route::post('/', [TurnosController::class, 'store']);
            Route::post("/atribuir-usuario", [TurnosUsuariosController::class, 'store']);
            Route::delete('/', [TurnosController::class, 'destroy']);
            Route::patch('/', [TurnosController::class, 'update']);
        });
    });

    Route::middleware(UserMiddleware::class)->group(function () {
        Route::prefix('/users')->group(function () {
            Route::put('/{user}', [UserController::class, 'update']);
        });
        Route::prefix('/pontos')->group(function () {
            Route::post('/bater-ponto', [PontosController::class, 'store']);
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
