# 🏥 Healthcare System Dashboard

<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" height="80">
</p>

<h2 align="center">Comprehensive Healthcare Management System built with Laravel</h2>

<p align="center">
  <a href="#prerequisites">Prerequisites</a> •
  <a href="#installation">Installation</a> •
  <a href="#running-the-application">Running</a> •
  <a href="#features">Features</a> •
  <a href="#api-endpoints">API Endpoints</a> •
  <a href="#testing">Testing</a>
</p>

---

## 🚀 Quick Start

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL 8.0+
- Web server (Apache/Nginx) or PHP’s built-in server

---

## ⚙️ Installation

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

   Update `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hsl_dashboard
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password
   ```

   ⚠️ **Mail configuration (required for order notifications):**
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

7. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

   This will create all tables and insert:
   - Admin user
   - Provider user
   - Sample products

8. **Compile frontend assets**
   ```bash
   npm run build
   ```

---

## 🖥️ Running the Application

### Development Mode
```bash
php artisan serve
```
and in another terminal:
```bash
npm run dev
```

Visit: **http://localhost:8000**

---

## 🔐 Default Login Credentials

| Role | Email | Password |
|------|--------|-----------|
| Admin | admin@example.com | password |
| Provider | provider@example.com | password |

---

## ✨ Features

- Role-based authentication (Admin / Provider)
- Product catalog & stock management
- Safe order placement using **database transactions**
- **Concurrency protection** with `lockForUpdate()`
- Authorization handled by **OrderPolicy**
- Email notifications for new orders
- Low stock alerts
- Dashboard with analytics
- Fully tested with PHPUnit & GitHub Actions CI

---

## 📡 API Endpoints

### 🧾 Orders

| Method | Endpoint | Description | Auth | Role |
|--------|-----------|--------------|-------|------|
| GET | `/orders` | Fetch all or own orders | ✅ | Admin / Provider |
| GET | `/orders/create` | Show order form | ✅ | Admin / Provider |
| POST | `/orders` | Create new order | ✅ | Admin / Provider |
| POST | `/orders/{order}/dispatch` | Dispatch an order | ✅ | Admin |
| POST | `/orders/{order}/deliver` | Mark as delivered | ✅ | Provider (own) |

**Example: Create Order**
```json
POST /orders
{
  "product_id": 3,
  "quantity": 2
}
```
**Response (201 Created)**
```json
{
  "message": "Order placed successfully.",
  "order": {
    "id": 45,
    "user_id": 5,
    "product_id": 3,
    "quantity": 2,
    "total_price": 100.00,
    "status": "pending"
  }
}
```
**Error (422)**
```json
{
  "error": "Insufficient stock available for this product."
}
```

---

### 🏷️ Products

| Method | Endpoint | Description | Auth | Role |
|--------|-----------|-------------|-------|------|
| GET | `/products` | List all products | ✅ | Admin |
| GET | `/products/create` | Show add product form | ✅ | Admin |
| POST | `/products` | Add new product | ✅ | Admin |
| GET | `/products/{id}/edit` | Edit product | ✅ | Admin |
| PUT | `/products/{id}` | Update product | ✅ | Admin |
| DELETE | `/products/{id}` | Delete product | ✅ | Admin |

**Example:**
```json
POST /products
{
  "name": "HSL Vitamin Pack",
  "stock": 100,
  "price": 50.00
}
```

**Response**
```json
{
  "message": "Product created successfully.",
  "product": {
    "id": 21,
    "name": "HSL Vitamin Pack",
    "stock": 100,
    "price": 50.00
  }
}
```

---

### 👤 Profile

| Method | Endpoint | Description | Auth |
|--------|-----------|-------------|------|
| GET | `/profile` | View profile | ✅ |
| PATCH | `/profile` | Update profile | ✅ |
| DELETE | `/profile` | Delete account | ✅ |

---

## 🧪 Testing

### Run the test suite
```bash
php artisan test
```

### Run specific test
```bash
php artisan test tests/Feature/OrderTest.php
```

### With coverage (optional)
```bash
php artisan test --coverage-html=coverage
```

---

## ⚙️ Continuous Integration

GitHub Actions automatically:
- Installs dependencies
- Sets up a test database (SQLite in-memory)
- Runs all PHPUnit test cases on push or PR

Workflow file: `.github/workflows/laravel-tests.yml`

---

## 📋 Summary of Recent Changes

- Added **OrderPolicy** for authorization (`create`, `dispatch`, etc.)
- Added `$this->authorize()` calls in controllers
- Implemented **concurrency-safe order handling** (`lockForUpdate()`)
- Added **feature tests** for authorization, validation & insufficient stock
- Integrated **GitHub Actions CI**
- Updated **README** with endpoint documentation & examples

---

## 🧠 About

**Author:** Vivek Singh  
**Framework:** Laravel 10.x  
**License:** MIT  
**Last Updated:** November 10, 2025
