<?php

namespace App;

use Carbon\Carbon;

class Utils
{
    public static function dateFilter($query, $periodo)
    {
        $now = Carbon::now();
        switch ($periodo) {
            case "hoje":
                $query->where(function ($q) use ($now) {
                    $q->whereDate('data_hora_entrada', $now)
                        ->orWhereDate('data_hora_saida', $now);
                });
                break;

            case "semana":
                $query->where(function ($q) use ($now) {
                    $q->whereBetween('data_hora_entrada', [$now->startOfWeek(), $now->endOfWeek()])
                        ->orWhereBetween('data_hora_saida', [$now->startOfWeek(), $now->endOfWeek()]);
                });
                break;

            case "mes":
                $query->where(function ($q) use ($now) {
                    $q->whereMonth('data_hora_entrada', $now->month)
                        ->whereYear('data_hora_entrada', $now->year)
                        ->orWhere(function ($q) use ($now) {
                            $q->whereMonth('data_hora_saida', $now->month)
                                ->whereYear('data_hora_saida', $now->year);
                        });
                });
                break;

            case "semestre":
                $query->where(function ($q) use ($now) {
                    $q->where('data_hora_entrada', '>=', $now->subMonths(6))
                        ->orWhere('data_hora_saida', '>=', $now->subMonths(6));
                });
                break;
            case "ano":
                $query->where(function ($q) use ($now) {
                    $q->whereYear('data_hora_entrada', $now->year)
                    ->orWhereYear('data_hora_saida', $now->year);
                    ;
                });
        }
    }
}
