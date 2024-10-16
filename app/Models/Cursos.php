<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cursos extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function usuarios(): hasMany
    {
        return $this->hasMany(User::class, 'id_curso');
    }

}
