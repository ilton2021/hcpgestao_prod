<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemaTipoIncidente extends Model
{
    protected $table = 'problema_tipo_incidente';

    protected $fillable = [
        'nome',
        'id_ti',
        'created_at',
        'updated_at'
    ];
}
