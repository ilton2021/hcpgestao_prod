<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadesCapacity extends Model
{
    protected $table = 'unidades_capacity';

    protected $fillable = [
        'id',
        'descricao',
        'quantidades',
        'desc_quantidades',
        'status_capacity',
        'unidade_id',
        'created_at',
        'updated_at',
    ];
}
