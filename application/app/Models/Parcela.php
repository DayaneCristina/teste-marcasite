<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    use HasFactory;

    protected $table = 'parcela';
    protected $fillable = [
        'numero',
        'valor',
        'taxa',
        'data_vencimento',
        'observacao',
        'proposta_id'
    ];

    public function proposta()
    {
        return $this->belongsTo(Parcela::class); 
    }
}
