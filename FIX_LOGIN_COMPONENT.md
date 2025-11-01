# Fix Required: Login Volt Component

## Issue
The login Volt component is missing the layout annotation which causes "Unable to find component: [auth.login]" error.

## Manual Fix Required

**File:** `resources/views/livewire/auth/login.blade.php`

**Change 1:** Line 3
```php
// FROM:
use function Livewire\Volt\{state, rules};

// TO:
use function Livewire\Volt\{layout, state, rules};
```

**Change 2:** After line 4 (after `use Illuminate\Support\Facades\Auth;`), add:
```php
layout('layouts.guest');
```

**Also fix:** Line 78
```php
// FROM:
href="{{ route('register') }}"

// TO:
href="/register"
```

## Complete Fixed File

The file should start like this:
```php
<?php

use function Livewire\Volt\{layout, state, rules};
use Illuminate\Support\Facades\Auth;

layout('layouts.guest');

state(['email' => '', 'password' => '', 'remember' => false]);
```

And the link at line 78 should be:
```php
<a href="/register" class="text-blue-400 hover:text-blue-300">
```

## Status After Fix
✅ Login component will work correctly
✅ Register component already has layout
✅ Dashboard components work (included in dashboard layout)
✅ All route helpers fixed

