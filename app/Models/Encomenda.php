<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encomenda extends Model
{
    /** @use HasFactory<\Database\Factories\EncomendaFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'estado',
        'total_preco',
        'endereco_entrega',
        'metodo_pagamento',
        'observacoes',
        'data_encomenda',
        'created_by',
        

    ];
    public function itens():HasMany
    {
        return $this->hasMany(ItemEncomenda::class);
    }
    public function criador():BelongsTo{
        return $this->belongsTo(User::class,'created_by');
    }
}
