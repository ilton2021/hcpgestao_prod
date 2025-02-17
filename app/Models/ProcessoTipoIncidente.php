<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoTipoIncidente extends Model
{
    protected $table = 'processo_tipo_incidente';

    protected $fillable = [
        'id_ti',
        'nome',
        'created_at',
        'updated_at'
    ];
}
