<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pontos extends Model
{
    use HasFactory;

    protected $perPage = 8;
    protected $fillable = [
        'id_usuario',
        'id_turno',
        'data_hora_entrada',
        'data_hora_saida',
    ];

    public $timestamps = false;

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function turnos(): BelongsTo
    {
        return $this->belongsTo(Turnos::class, 'id_turno');
    }

    public static function getFilterOptions()
    {
        $now = Carbon::now();
        $years = Pontos::where('data_hora_entrada', '<=', $now->startOfYear())
            ->get(['data_hora_entrada'])
            ->map(fn($ponto) => Carbon::parse($ponto['data_hora_entrada'])->year)
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        return['hoje','semana','mes','semestre','ano'];

//        return [
//            'hoje' => Carbon::today(),
//            'semana' => $now->subDays(7),
//            'mes' => $now->subMonth(),
//            'semestre' => $now->subMonths(6),
//            'ano' => $now->subYear()
//        ];
    }

}
