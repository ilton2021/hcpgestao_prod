<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatuto extends Model
{
    protected $table = 'estatutos';

	protected $fillable = [
		'name',
		'year',
		'kind',
		'path_file',
		'unidade_id',
		'status_estatuto',
		'created_at',
		'updated_at'
	];

	public $rules = [
		'name' => 'required',
		'kind' => 'required'
	];
}
