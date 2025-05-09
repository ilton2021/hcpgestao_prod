<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $table = 'manuals';
	
	protected $fillable = [
		'title',
		'path_file',
		'path_img',
		'unidade_id',
		'status_manuais',
		'created_at',
		'updated_at'
	];
}
