<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    use HasFactory;

    protected $table = 'propostas';
    protected $fillable = [
        'endereco',
        'valor_total',
        'sinal',
        'quantidade_parcelas',
        'status',
        'empresa_id',
        'servico_id',
        'data_inicio_pagamento',
        'dia_vencimento'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

    public function anexo()
    {
        return $this->hasMany(Anexo::class);
    }

    public function parcela()
    {
        return $this->hasMany(Parcela::class);
    }
}
