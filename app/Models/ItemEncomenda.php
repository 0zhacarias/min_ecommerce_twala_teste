<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemEncomenda extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'encomenda_id',
        'nome',
        'produto_id',
        'quantidade',
        'preco',
        'subtotal',
    ];

    public function encomenda():BelongsTo
    {
        return $this->belongsTo(Encomenda::class);
    }
    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantidade * $this->preco
        );
    }
}
