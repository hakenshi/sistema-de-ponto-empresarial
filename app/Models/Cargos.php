<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cargos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nome'
    ];

    public function usuarios(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
