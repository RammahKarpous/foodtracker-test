# Food Tracker Laravel Setup Guide

## Prerequisites

- PHP 8.2+
- Composer
- MySQL
- Node.js 18+ and npm

## Installation Steps

### 1. Clone or Navigate to Project
```bash
cd /path/to/foodtracker
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install NPM Dependencies
```bash
npm install
```

### 4. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodtracker
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Create Database
```bash
# Option 1: Using MySQL CLI
mysql -u root -e "CREATE DATABASE foodtracker;"

# Option 2: Using MySQL Workbench or phpMyAdmin
# Create database named 'foodtracker'
```

### 7. Run Migrations
```bash
php artisan migrate
```

This will create all necessary tables:
- users
- products
- diary_entries
- nutritional_limits
- sessions (for authentication)

### 8. Build Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 9. Start Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## First Steps

1. **Register** a new account at `/register`
2. **Login** at `/login`
3. **Access Dashboard** at `/dashboard`
4. Start adding products and tracking meals!

## Usage

### Products Tab
- Add products with nutritional information per 100g
- Search and filter products
- Edit or delete products

### Diary Tab
- Navigate between dates
- Add meals by selecting moment, product, and grams
- View summary by meal moment
- Red highlighting when limits exceeded

### Overview Tab
- View pie charts for each nutrient
- Red charts when limits exceeded
- Navigate between dates to see historical data

### Settings Tab
- Adjust your daily nutritional limits
- Changes apply immediately to diary and overview

## Troubleshooting

### MySQL Connection Error
Ensure MySQL is running and credentials are correct.

### Assets Not Loading
Run `npm run dev` or `npm run build` to compile assets.

### Permission Errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## Production Deployment

See MIGRATION.md for production deployment instructions.

