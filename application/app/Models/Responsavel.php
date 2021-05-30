<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';
    protected $fillable = [
        'nome',
        'cpf'
    ];

    public function empresas()
    {
        return $this->belongsTo(Empresa::class,'empresas_tem_responsaveis');
    }

    public function telefone()
    {
        return $this->hasMany(Telefone::class);
    }

    public function email()
    {
        return $this->hasMany(Email::class);
    }
}
