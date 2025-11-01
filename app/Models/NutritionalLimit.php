<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionalLimit extends Model
{
    protected $fillable = [
        'user_id',
        'kcal_limiet',
        'vet_limiet',
        'verzadigd_limiet',
        'koolhydraten_limiet',
        'suiker_limiet',
        'eiwit_limiet',
    ];

    protected $casts = [
        'kcal_limiet' => 'decimal:2',
        'vet_limiet' => 'decimal:2',
        'verzadigd_limiet' => 'decimal:2',
        'koolhydraten_limiet' => 'decimal:2',
        'suiker_limiet' => 'decimal:2',
        'eiwit_limiet' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
