<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietistEntry extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'product_name',
        'grams',
        'is_red_meat',
        'datum',
    ];

    protected $casts = [
        'grams' => 'decimal:2',
        'is_red_meat' => 'boolean',
        'datum' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
