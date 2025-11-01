<?php

namespace App\Observers;

use App\Models\User;
use App\Models\NutritionalLimit;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        NutritionalLimit::create([
            'user_id' => $user->id,
        ]);
    }
}

