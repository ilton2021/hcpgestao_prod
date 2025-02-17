<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadesSpecialty extends Model
{
    protected $table = 'unidades_specialty';

    protected $fillable = [
        'description',
        'specialty',
        'unidade_id',
        'status_specialty',
        'created_at',
        'updated_at',
    ];
}
