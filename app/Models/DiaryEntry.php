<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaryEntry extends Model
{
    protected $fillable = [
        'user_id',
        'product_naam',
        'category',
        'is_red_meat',
        'moment',
        'gram',
        'kcal',
        'vet',
        'verzadigd',
        'koolhydraten',
        'suiker',
        'eiwit',
        'datum',
    ];

    protected $casts = [
        'gram' => 'decimal:2',
        'kcal' => 'decimal:2',
        'vet' => 'decimal:2',
        'verzadigd' => 'decimal:2',
        'koolhydraten' => 'decimal:2',
        'suiker' => 'decimal:2',
        'eiwit' => 'decimal:2',
        'datum' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
