<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemEncomenda extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'encomenda_id',
        'produto_id',
        'quantidade',
        'preco',
        'subtotal',
    ];

    public function encomenda():BelongsTo
    {
        return $this->belongsTo(Encomenda::class);
    }

}
