# KMD's Food Tracker - Laravel 12

A modern, multi-user food tracking application built with Laravel 12, Livewire Volt, Alpine.js, and TailwindCSS.

## Features

### 🍎 Product Management
- Add and manage food products with nutritional information
- Real-time search and filtering
- Edit and delete products
- Per-100g nutritional values

### 📝 Daily Diary
- Track meals across 6 meal moments (Ontbijt, Lunch, Tussendoor, Diner, Voor training, Na training)
- Date navigation (today, previous, next)
- Automatic nutritional calculations based on grams
- Per-moment and total summaries
- Red highlighting when daily limits exceeded

### 📊 Overview & Analytics
- 6 interactive pie charts for nutritional tracking
- Visual limit indicators
- Color-coded charts (green/gradient for normal, red for exceeded)
- Historical data navigation

### ⚙️ Settings
- Customizable daily nutritional limits
- Real-time updates across all tabs
- User-specific preferences

### 👤 Multi-User Support
- Secure registration and login
- Complete data isolation between users
- Session-based authentication

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Livewire Volt + Alpine.js
- **Database**: MySQL
- **Styling**: TailwindCSS v3
- **Charts**: Chart.js
- **Authentication**: Laravel Fortify
- **Build**: Vite

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL
- Node.js 18+ and npm

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd foodtracker
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   
   Edit `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=foodtracker
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

   Create database:
   ```bash
   mysql -u root -e "CREATE DATABASE foodtracker;"
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   npm run dev  # Development
   # or
   npm run build  # Production
   ```

7. **Start server**
   ```bash
   php artisan serve
   ```

8. **Open browser**
   ```
   http://localhost:8000
   ```

## Usage

1. **Register** a new account at `/register`
2. **Login** at `/login`
3. Start **adding products** with nutritional information
4. **Track your meals** throughout the day
5. **View charts** to monitor your progress
6. **Adjust limits** to match your goals

## Project Structure

```
app/
├── Models/              # Eloquent models
├── Observers/          # UserObserver for auto-creating limits
├── Providers/          # Service providers
└── Actions/Fortify/    # Authentication actions

resources/
├── views/
│   ├── layouts/        # App and guest layouts
│   └── livewire/       # Volt components
│       ├── auth/       # Login/register
│       ├── products/   # Product management
│       ├── diary/      # Meal tracking
│       ├── overview/   # Charts
│       └── settings/   # Preferences
├── css/                # TailwindCSS
└── js/                 # Alpine.js + Chart.js

routes/
└── web.php            # Application routes

database/migrations/   # Database schema
```

## Documentation

- **[SETUP_GUIDE.md](SETUP_GUIDE.md)** - Detailed setup instructions
- **[MIGRATION.md](MIGRATION.md)** - Migration overview and production deployment
- **[LARAVEL_CONVERSION_SUMMARY.md](LARAVEL_CONVERSION_SUMMARY.md)** - Project conversion summary
- **[IMPLEMENTATION_STATUS.md](IMPLEMENTATION_STATUS.md)** - Current status and testing checklist

## Development

### Running in Development
```bash
npm run dev  # Watch for changes
php artisan serve  # Start Laravel server
```

### Running Tests
```bash
php artisan test
```

### Database Reset
```bash
php artisan migrate:fresh
```

### Cache Clear
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Production Deployment

See [MIGRATION.md](MIGRATION.md) for production deployment instructions.

### Key Production Steps
1. Set `APP_ENV=production` in `.env`
2. Run `composer install --no-dev --optimize-autoloader`
3. Run `npm run build`
4. Run `php artisan config:cache` and `php artisan route:cache`
5. Set proper file permissions
6. Deploy with your preferred method

## Features Comparison

| Feature | Original | Laravel Version |
|---------|----------|-----------------|
| Storage | localStorage | MySQL Database |
| Users | Single | Multi-user with auth |
| Language | Vanilla JS | PHP + Livewire |
| Styling | Custom CSS | TailwindCSS |
| Real-time | Manual refresh | Livewire reactivity |
| Deployment | Static | Full Laravel app |

## Contributing

This is a production application. For issues or enhancements, please follow standard Laravel development practices.

## License

All rights reserved.

## Support

For detailed information, see the documentation files listed above.
