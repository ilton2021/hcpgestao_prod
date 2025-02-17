<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulamentosContratos extends Model
{
    protected $table = 'regulamentos_contratos';

    protected $fillable = [
        'title',
        'tipo',
        'caminho',
        'name_arq',
        'status',
        'created_at',
        'updated_at'
    ];
}
