<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgaos extends Model
{
    protected $table = 'orgaos';

    protected $fillable = [
        'nome',
        'status',
        'created_at',
        'updated_at'
    ];
}
