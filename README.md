# Quick Receipt — Laravel

A subscription-based web application for generating withdrawal billing screenshots. Built with **Laravel 10**, **Tailwind CSS**, and modern glassmorphism UI.

## Features

- **User Authentication** — Register, Login, Logout with bcrypt-hashed passwords
- **Subscription System** — Flexible day-based subscription activation with auto-expiry
- **50+ Receipt Templates** — Mobile screenshot templates stored in database, loaded dynamically
- **Screenshot Capture** — One-click SVG/HTML capture using html2canvas with adjustable sizing
- **Live Preview** — Real-time template preview with slider control for dimensions
- **Admin Users Panel** — Paginated user list with subscription status indicators
- **Modern UI** — Glassmorphism design, gradient accents, responsive layout
- **Landing Page** — Professional landing page with features showcase

## Tech Stack

- **Backend:** Laravel 10 (PHP 8.1+)
- **Frontend:** Blade Templates, Tailwind CSS (CDN), Font Awesome 6
- **Database:** SQLite (default) / MySQL
- **Screenshot:** html2canvas

## Quick Start

```bash
# Clone & install
git clone https://github.com/mrshahbazdev/fake-screenshot.git
cd fake-screenshot
composer install

# Environment
cp .env.example .env
php artisan key:generate
touch database/database.sqlite

# Database
php artisan migrate
php artisan db:seed

# Start
php artisan serve
```

Visit `http://localhost:8000`

### Default Admin Login
- **Username:** admin
- **Password:** password

## Database Structure

| Table | Description |
|-------|-------------|
| `users` | User accounts with subscription status and role |
| `subscriptions` | Subscription history records |
| `pages` | Receipt templates (name, HTML data, script, sidebar, thumbnail) |

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/          # Login, Register
│   │   ├── HomeController       # Template viewer
│   │   ├── SubscriptionController
│   │   ├── UserController       # Admin users list
│   │   └── LandingController
│   └── Middleware/
│       └── CheckSubscription    # Subscription guard
├── Models/
│   ├── User, Subscription, Page
resources/views/
├── layouts/         # Base layouts (app, auth)
├── auth/            # Login, Register
├── subscription/    # Subscribe page
├── users/           # Admin users list
├── home.blade.php   # Main template viewer
└── landing.blade.php
```

## Switching to MySQL

Update `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quick_receipt
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run `php artisan migrate --seed`.
