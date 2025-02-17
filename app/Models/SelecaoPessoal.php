<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelecaoPessoal extends Model
{
	protected $table = 'selecao_pessoals';
	
	protected $fillable = [
		'cargo_name_id',
		'ano',
		'quantidade',
		'unidade_id',
		'status_selecao_pessoals',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'ano' 			=> 'required|digits:4|integer',
		'quantidade' 	=> 'required|integer'
	];
	
    public function cargos()
    {
        return $this->belongsTo('App\Models\Cargo', 'cargo_name_id', 'id');
    }
}
