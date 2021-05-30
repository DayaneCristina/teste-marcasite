<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $table = 'anexos';
    protected $fillable = [
        'nome',
        'arquivo',
        'proposta_id'
    ];
    
    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }
}
