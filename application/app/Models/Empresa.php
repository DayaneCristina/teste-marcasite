<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj'
    ];

    public function endereco()
    {
        return $this->hasMany(Endereco::class);
    }

    public function responsaveis()
    {
        return $this->belongsToMany(Responsavel::class,'empresas_tem_responsaveis');
    }

    public function proposta()
    {
        return $this->hasMany(Proposta::class);
    }
}
