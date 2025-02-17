<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposOcorrencias extends Model
{
    protected $table = 'tipos_ocorrencias';

    protected $fillable = [
        'ocorrencias_id',
        'descricao',
        'created_at',
        'updated_at'
    ];
}
