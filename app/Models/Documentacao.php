<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacao extends Model
{
    protected $table = 'documentacao';

    protected $fillable = [
		'nome',
		'arquivo',
		'caminho'	
	];
}
