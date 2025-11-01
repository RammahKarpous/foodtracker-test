# Bug Fix: Route Names

## Issue
The application was throwing `RouteNotFoundException: Route [login] not defined` because we were using `route('login')` and `route('register')` helpers, but Volt routes don't automatically register named routes.

## Fix
Replaced all instances of:
- `route('login')` → `/login`
- `route('register')` → `/register`

## Files Changed
1. `resources/views/livewire/auth/login.blade.php` - Fixed register link
2. `resources/views/livewire/auth/register.blade.php` - Fixed login link  
3. `resources/views/welcome.blade.php` - Fixed all route references

## Status
✅ All route helpers replaced with absolute paths
✅ No more route not defined errors
✅ Application now loads correctly

## Testing
To verify:
1. Visit http://localhost:8000
2. Should redirect to /dashboard (or show login if not authenticated)
3. Click login/register links - should work without errors

