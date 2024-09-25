<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turnos extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'turnos';

    protected $fillable = [
      'hora_entrada',
      'hora_saida',
    ];


    public function usuarios():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'turno_usuario', 'id_turno', 'id_usuario');
    }

    public function pontos(): HasMany
    {
        return $this->hasMany(Pontos::class, 'id_turno');
    }

}
