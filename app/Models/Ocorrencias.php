<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocorrencias extends Model
{
    protected $table = 'ocorrencias';

    protected $fillable = [
        'descricao',
        'created_at',
        'updated_at'
    ];
}
