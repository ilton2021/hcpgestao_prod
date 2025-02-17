<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestor';
	
	protected $fillable = [
		'nome',
		'email',
		'setor',
		'status_gestores',
		'created_at',
		'updated_at'
	];
}
