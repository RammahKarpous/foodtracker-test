<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'naam',
        'kcal',
        'vet',
        'verzadigd',
        'koolhydraten',
        'suiker',
        'eiwit',
    ];

    protected $casts = [
        'kcal' => 'decimal:2',
        'vet' => 'decimal:2',
        'verzadigd' => 'decimal:2',
        'koolhydraten' => 'decimal:2',
        'suiker' => 'decimal:2',
        'eiwit' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
