<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetorRegulamentos extends Model
{
    protected $table = 'setor_regulamento';

    protected $fillable = [
        'descricao',
        'created_at',
        'updated_at'
    ];
}
