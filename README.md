# Health Care System Dashboard

<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" height="80">
  <h1 align="center">Healthcare System Dashboard</h1>
  <p align="center">
    A comprehensive healthcare management system built with Laravel
  </p>
  
  <p align="center">
    <a href="#prerequisites">Prerequisites</a> •
    <a href="#installation">Installation</a> •
    <a href="#running-the-application">Running</a> •
    <a href="#features">Features</a> •
    <a href="#testing">Testing</a>
  </p>
</p>

## 🚀 Quick Start

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL 8.0+
- Web server (Apache/Nginx) or PHP's built-in development server

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/vivek10688/healthcare-dashboard.git
   cd healthcare-dashboard
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure environment variables**

   Update your `.env` file with your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hsl_dashboard
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password
   ```

   ⚠️ **Important:** Add your mail credentials in `.env`:

   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mail_username
   MAIL_PASSWORD=your_mail_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=example@example.com
   MAIL_FROM_NAME="Healthcare System"
   ```

   Without valid mail credentials, notifications and order-related emails may fail.

7. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
   This will:
   - Create all necessary tables
   - Seed initial data (admin user, sample products, etc.)

8. **Compile assets**
   ```bash
   npm run build
   ```

## 🖥️ Running the Application

### Development Server

Start the Laravel development server:
```bash
php artisan serve
```

In a new terminal, start the Vite development server:
```bash
npm run dev
```

Access the application at: http://localhost:8000 or http://127.0.0.1:8000

### Default Login Credentials

- **Admin User:**
  - Email: admin@example.com
  - Password: password

- **Provider User:**
  - Email: provider@example.com
  - Password: password

## ✨ Features

- Role-based authentication (Admin / Provider)
- Product catalog & inventory management
- Low stock alerts
- Order management (create, track, update)
- Subscription management
- Dashboard with charts and stats
- Email notifications for order updates

## 🧪 Testing

Run the test suite using PHPUnit:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/OrderTest.php

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage-html=coverage
```

---

*Last Updated: November 7, 2025*