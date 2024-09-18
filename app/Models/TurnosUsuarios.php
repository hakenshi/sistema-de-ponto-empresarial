<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TurnosUsuarios extends Pivot
{
    protected $table = 'turno_usuario';

    public $timestamps = false;
    protected $fillable = [
        'id_turno',
        'id_usuario',
    ];

    public function turno(): BelongsTo{
        return $this->belongsTo(Turnos::class, 'id_turno');
    }
    public function usuario(): BelongsTo{
        return $this->belongsTo(User::class, 'id_usuario');
    }

}
