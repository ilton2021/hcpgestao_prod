<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Hierarquia extends Model
{
    protected $connection='oracle';
    protected $table='hierarquias';
}
