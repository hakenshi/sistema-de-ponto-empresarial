<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
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
            Route::patch('/{user}', [UserController::class, 'update']);
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::delete('/{user}', [UserController::class, 'destroy']);
        });

        Route::prefix('pontos')->group(function () {
            Route::post('/', [PontosController::class, 'storeAdmin'])->name('api.pontos.store');
            Route::post('/export-excel', [ExportController::class, 'exportPontos'])->name('api.pontos.export.excel');
            Route::patch('/{pontos}', [PontosController::class, 'update'])->name('api.pontos.update');
            Route::delete('/{pontos}', [PontosController::class, 'destroy'])->name('api.pontos.destroy');
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
    Route::prefix('/users')->group(function () {
        Route::put('/{user}', [UserController::class, 'update']);
    });
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::prefix('/pontos')->group(function () {
            Route::post('/bater-ponto', [PontosController::class, 'store']);
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
