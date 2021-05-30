<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    protected $table = 'telefones';
    protected $fillable = [
        'ddi',
        'ddd',
        'numero',
        'responsavel_id'
    ];

    public function responsavel()
    {
        return $this->belongsTo(Responsavel::class);
    } 
}
