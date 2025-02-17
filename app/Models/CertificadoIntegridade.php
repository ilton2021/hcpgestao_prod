<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificadoIntegridade extends Model
{
    protected $table = 'integridade';

    protected $fillable = [
        'name',
        'path_file',
        'status_integridade',
        'created_at',
        'updated_at'
    ];
}
