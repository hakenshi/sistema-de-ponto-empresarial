<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pontos extends Model
{
    use HasFactory;

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

}
