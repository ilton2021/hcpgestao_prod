<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlterarSenha extends Model
{
    protected $table = 'alterar_senha';

    protected $fillable = [
        'token',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
