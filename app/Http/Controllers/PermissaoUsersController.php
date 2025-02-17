<?php

namespace App\Http\Controllers;

use App\Models\PermissaoUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PermissaoUsersController extends Controller
{
	public static function Permissao($id)
	{
	    $user_atual = Auth::user()->id;
	    $user = User::where('id', $user_atual)->where('status_users', 1)->get();
	    if(sizeof($user) == 0){
	        $validacao = 'erro';
	    }else{
            $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
    		$qtd = sizeof($permissao_users);
    		$validacao = '';
    		for($i = 0; $i < $qtd; $i++) {
    			if($permissao_users[$i]->user_id == Auth::user()->id) {
    				$validacao = 'ok';
    				break;
    			} else {
    				$validacao = 'erro';
    			}
		    }
	    }
        return $validacao;
    }
}
