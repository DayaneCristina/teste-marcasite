<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function proposta()
    {
        return $this->hasMany(Proposta::class);
    }
}
