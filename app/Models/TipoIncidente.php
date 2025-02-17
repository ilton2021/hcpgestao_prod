<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIncidente extends Model
{
    protected $table = 'tipo_incidente';

    protected $fillable = [
        'nome',
        'created_at',
        'updated_at'
    ];
}
