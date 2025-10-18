<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade',
        'imagem',
        'categoria_id',
    ];

    public function categorias() : BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
        
    }
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->imagem 
                ? asset('storage/' . $this->imagem)
                : asset('images/produto.png'),
        );
    }
}
