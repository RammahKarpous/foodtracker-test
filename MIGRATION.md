# Laravel 12 Food Tracker Migration Guide

## Overview

This document outlines the migration of the vanilla JavaScript food tracker to Laravel 12 with Livewire Volt, Alpine.js, and TailwindCSS.

## Completed Implementation

### Core Setup
- ✅ Laravel 12 fresh installation
- ✅ MySQL database configuration
- ✅ Laravel Fortify for authentication (without starter kit)
- ✅ Livewire Volt for reactive components
- ✅ Alpine.js and Chart.js integration via Vite
- ✅ TailwindCSS v3 (downgraded from v4 for compatibility)

### Database Structure
- ✅ Users table (Laravel default)
- ✅ Products table with nutritional data
- ✅ Diary entries table with meal tracking
- ✅ Nutritional limits table with user preferences

### Models & Relationships
- ✅ Product, DiaryEntry, NutritionalLimit models
- ✅ User relationships (hasMany, hasOne)
- ✅ UserObserver for auto-creating nutritional limits on registration
- ✅ Proper casting and fillable attributes

### Authentication
- ✅ Custom Livewire Volt login component
- ✅ Custom Livewire Volt register component
- ✅ Fortify configuration (registration + reset passwords only)
- ✅ Guest and authenticated layouts
- ✅ Logout functionality

### Main Application Features
- ✅ Products tab: CRUD operations, search/filter, edit/delete
- ✅ Diary tab: Date navigation, meal tracking, per-moment summaries, limit warnings
- ✅ Overview tab: 6 pie charts (kcal, vet, verzadigd, koolhydraten, suiker, eiwit) with limit checking
- ✅ Settings tab: Edit nutritional limits

### Styling
- ✅ Dark theme with gradients
- ✅ Glass morphism effects
- ✅ Responsive design (mobile-first)
- ✅ Tab navigation system
- ✅ Dutch language throughout

## Next Steps

### 1. Database Setup
```bash
# Create MySQL database
mysql -u root -e "CREATE DATABASE foodtracker;"

# Configure .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodtracker
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate
```

### 2. Build Assets
```bash
npm run dev  # For development
npm run build  # For production
```

### 3. Start Development Server
```bash
php artisan serve
```

### 4. Test the Application
1. Register a new user at `/register`
2. Login at `/login`
3. Access dashboard at `/dashboard`
4. Create products, track meals, view charts, adjust limits

## Key Differences from Original

### Architecture
- **Original**: Vanilla JS with localStorage
- **New**: Laravel 12 backend with Livewire Volt components
- **Database**: MySQL instead of localStorage
- **Multi-user**: Full authentication and user isolation

### Tech Stack
- **Original**: Pure HTML/CSS/JS
- **New**: Laravel, Livewire Volt, Alpine.js, TailwindCSS, Chart.js

### Features Enhanced
- ✅ Multi-user support with authentication
- ✅ Data persistence in MySQL database
- ✅ Real-time reactivity with Livewire
- ✅ Server-side validation
- ✅ CSRF protection
- ✅ Production-ready deployment

## Production Deployment

### Environment Configuration
Ensure these are set in production `.env`:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-production-host
DB_DATABASE=foodtracker
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
```

### Build for Production
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## File Structure

```
app/
├── Models/
│   ├── Product.php
│   ├── DiaryEntry.php
│   └── NutritionalLimit.php
├── Observers/
│   └── UserObserver.php
├── Providers/
│   └── AppServiceProvider.php
└── Actions/Fortify/
    └── CreateNewUser.php

resources/views/
├── layouts/
│   ├── app.blade.php (authenticated)
│   └── guest.blade.php (auth pages)
├── livewire/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── products/
│   │   └── index.blade.php
│   ├── diary/
│   │   └── index.blade.php
│   ├── overview/
│   │   └── index.blade.php
│   └── settings/
│       └── nutritional-limits.blade.php
├── dashboard.blade.php
├── login.blade.php
└── register.blade.php

routes/
└── web.php

config/
└── fortify.php
```

## Testing Checklist

- [ ] User registration works
- [ ] User login works
- [ ] User logout works
- [ ] Products CRUD operations
- [ ] Diary entry creation/editing/deletion
- [ ] Date navigation in diary and overview
- [ ] Charts render correctly with data
- [ ] Nutritional limits save and apply correctly
- [ ] Data isolation between users
- [ ] Mobile responsive design
- [ ] Search functionality in products
- [ ] Limit warnings in diary summaries

## Known Issues / Improvements

1. **TailwindCSS v4**: Downgraded to v3 for Vite 7 compatibility
2. **Local MySQL**: Database needs to be set up locally
3. **Chart.js**: Needs optimization for production builds
4. **Migration**: No tool to migrate localStorage data to database

## Support

For issues or questions, please refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)

