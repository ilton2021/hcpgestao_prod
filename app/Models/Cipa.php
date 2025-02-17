<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cipa extends Model
{
    protected $table = 'cipa';

    protected $fillable = [
        'condicoes_inseguras',
        'local_condicoes',
        'observacao',
        'created_at',
        'updated_at'
    ];
}
