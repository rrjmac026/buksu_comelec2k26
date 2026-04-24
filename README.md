# COMELEC 2K26 - Online Voting System

<p align="center">
  <strong>A modern Laravel-based online voting management system for educational institutions</strong>
</p>

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
- [Database Setup](#database-setup)
- [Environment Configuration](#environment-configuration)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [User Roles & Permissions](#user-roles--permissions)
- [Database Schema](#database-schema)
- [API & Features Documentation](#api--features-documentation)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## 📌 About

**COMELEC 2K26** is a comprehensive online voting system designed for educational institutions. It enables students to participate in organizational elections with secure authentication, real-time vote counting, and detailed reporting capabilities.

**Built with:**
- Laravel 12 (PHP Framework)
- MySQL/MariaDB (Database)
- Tailwind CSS (Styling)
- Alpine.js (Interactivity)
- FPDF (PDF Generation)

---

## ✨ Features

### Core Voting Features
- **Secure Authentication**: User login with role-based access control
- **Multi-Position Voting**: Support for multiple election positions
- **Real-time Vote Counting**: Live vote updates and results
- **PDF Reporting**: Generate election reports as PDF files
- **Activity Logging**: Complete audit trail of all user actions
- **Organization Management**: Create and manage multiple organizations
- **Candidate Management**: Upload and manage candidate information with photos
- **Partylist Management**: Organize candidates into partylists

### Administrative Features
- **Database Backups**: Automated backup system with scheduling
- **Election Settings**: Configure election dates and parameters
- **User Management**: Create and manage user accounts
- **Analytics Dashboard**: View voting statistics and trends
- **Feedback System**: Collect voter feedback and suggestions

### Security Features
- CSRF Protection
- Password hashing with Bcrypt
- IP logging for suspicious activity
- Session management
- Role-based authorization

---

## 🖥️ System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher
- **MySQL/MariaDB**: 5.7 or higher
- **Node.js**: 18.0 or higher (for frontend compilation)
- **Composer**: Latest version
- **npm**: 9.0 or higher

### Recommended Setup
- PHP 8.3+
- MariaDB 10.4+
- 2GB RAM
- Modern web browser (Chrome, Firefox, Safari, Edge)

---

## 📦 Installation Guide

### Step 1: Clone or Download the Repository

```bash
cd c:\Users\Jam\Desktop\comelec2k26
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install Node.js Dependencies

```bash
npm install
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

This command creates a unique encryption key for your application in the `.env` file.

### Step 5: Build Frontend Assets

```bash
npm run build
```

Or for development with hot reloading:

```bash
npm run dev
```

---

## 🗄️ Database Setup

### **CRITICAL: Database Import Instructions**

The `comelec2k26.sql` file contains the complete database schema and sample data.

#### Method 1: Using phpMyAdmin (Recommended for Beginners)

1. **Open phpMyAdmin**
   - Navigate to `http://localhost/phpmyadmin`
   - Login with your MySQL credentials

2. **Create Database**
   - Click "New" in the left sidebar
   - Database name: `comelec2k26`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

3. **Import SQL File**
   - Select the `comelec2k26` database
   - Click the "Import" tab
   - Click "Choose File"
   - Select `comelec2k26.sql` from your project root
   - Click "Import" at the bottom

#### Method 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create the database
CREATE DATABASE comelec2k26 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Exit MySQL
exit;

# Import the SQL file
mysql -u root -p comelec2k26 < comelec2k26.sql
```

#### Method 3: Using Laravel Artisan (Alternative)

If you have a fresh database, you can use migrations and seeders:

```bash
# Run migrations to create tables
php artisan migrate

# Run seeders to populate sample data
php artisan db:seed
```

### Database Tables Overview

| Table | Purpose |
|-------|---------|
| `users` | User accounts and authentication |
| `candidates` | Election candidates with photos and platforms |
| `casted_votes` | Recorded votes with voting records |
| `positions` | Election positions (e.g., President, VP) |
| `partylists` | Political parties/organizations |
| `organizations` | Educational organizations |
| `colleges` | Academic colleges/departments |
| `election_settings` | Election configuration and dates |
| `feedback` | Voter feedback and suggestions |
| `activity_logs` | Audit trail of user actions |
| `data_backups` | Database backup records |

---

## ⚙️ Environment Configuration

### Step 1: Copy Environment File

```bash
copy .env.example .env
```

Or on Linux/Mac:
```bash
cp .env.example .env
```

### Step 2: Edit `.env` File

Update the following critical variables:

```env
APP_NAME=COMELEC2K26
APP_ENV=local
APP_KEY=                    # Will be filled by key:generate
APP_DEBUG=true              # Set to false in production
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=comelec2k26
DB_USERNAME=root
DB_PASSWORD=                # Your MySQL password

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@comelec2k26.com
MAIL_FROM_NAME="COMELEC 2K26"
```

### Step 3: Verify Database Connection

```bash
php artisan tinker
# Then type: DB::connection()->getPdo()
# Should return connection object without errors
```

---

## 🚀 Running the Application

### Method 1: Using Laravel Artisan (Development Server)

```bash
# Terminal 1: Start PHP development server
php artisan serve

# Terminal 2: Build frontend with hot reload
npm run dev
```

Access the application at: `http://localhost:8000`

### Method 2: Using Virtual Host (Apache/Nginx)

Configure your web server to point to the `public` directory.

### Method 3: Using Docker (If installed)

```bash
# Start containers with Laravel Sail
./vendor/bin/sail up
```

---

## 📂 Project Structure

```
comelec2k26/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Custom middleware
│   │   └── Requests/         # Form validation requests
│   ├── Models/               # Eloquent models
│   │   ├── User.php
│   │   ├── Candidate.php
│   │   ├── CastedVote.php
│   │   ├── Position.php
│   │   └── ... (other models)
│   ├── Services/             # Business logic services
│   ├── Jobs/                 # Queue jobs
│   └── Helpers/              # Helper functions
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories for testing
├── routes/
│   ├── web.php               # Web routes
│   ├── auth.php              # Authentication routes
│   └── console.php           # Console commands
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Tailwind CSS
│   └── js/                   # JavaScript components
├── config/
│   ├── app.php               # Application configuration
│   ├── database.php          # Database configuration
│   ├── auth.php              # Authentication config
│   └── ... (other configs)
├── storage/
│   ├── app/                  # Application files
│   ├── logs/                 # Application logs
│   └── framework/            # Framework files
├── public/
│   ├── index.php             # Application entry point
│   ├── assets/               # Static assets
│   └── storage/              # User uploads
├── tests/                    # Unit and feature tests
├── .env                      # Environment variables
├── composer.json             # PHP dependencies
├── package.json              # Node.js dependencies
└── comelec2k26.sql          # Database SQL dump
```

---

## 👥 User Roles & Permissions

### 1. **Admin**
- Full system access
- Manage users and organizations
- Configure election settings
- View all reports and statistics
- Manage backup operations
- Access activity logs

### 2. **Voter (Student)**
- View candidates and positions
- Cast votes in enabled positions
- View personal voting history
- Submit feedback
- Cannot view others' votes

### 3. **Candidate**
- View personal profile and vote count (if enabled)
- Cannot vote or access admin features

### 4. **Organization Manager** (if implemented)
- Manage candidates and partylists
- View organization-specific reports
- Cannot access other organizations

---

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'voter', 'candidate', 'manager'),
    status ENUM('active', 'inactive') DEFAULT 'active',
    college_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Candidates Table
```sql
CREATE TABLE candidates (
    candidate_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    partylist_id BIGINT NOT NULL,
    position_id BIGINT NOT NULL,
    college_id BIGINT NOT NULL,
    course VARCHAR(100),
    photo VARCHAR(255),
    platform TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (partylist_id) REFERENCES partylists(id),
    FOREIGN KEY (position_id) REFERENCES positions(id)
);
```

### Casted Votes Table
```sql
CREATE TABLE casted_votes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    candidate_id BIGINT NOT NULL,
    position_id BIGINT NOT NULL,
    college_id BIGINT,
    voted_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(user_id, position_id),  -- Prevent duplicate votes
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(candidate_id),
    FOREIGN KEY (position_id) REFERENCES positions(id)
);
```

---

## 🎯 API & Features Documentation

### Authentication Endpoints

**Login**
```bash
POST /login
Body: { email: string, password: string }
Response: Authenticated user with session
```

**Logout**
```bash
POST /logout
Response: { message: "Successfully logged out" }
```

**Register** (if enabled)
```bash
POST /register
Body: { name, email, password, password_confirmation }
Response: User created with authentication
```

### Voting Endpoints

**Get Available Positions**
```bash
GET /api/positions
Response: Array of positions with candidates
```

**Cast Vote**
```bash
POST /api/votes
Body: { position_id: int, candidate_id: int }
Response: { success: true, message: "Vote cast successfully" }
```

**Get Voting Results** (Admin only)
```bash
GET /api/results
Response: Vote counts by position and candidate
```

### Admin Endpoints

**Create Backup**
```bash
POST /admin/backups/create
Response: Backup file path
```

**Get Activity Logs**
```bash
GET /admin/activity-logs
Response: Paginated activity logs
```

---

## 🔍 Troubleshooting

### Common Issues & Solutions

#### 1. "No Application Key"
```bash
# Fix: Generate the application key
php artisan key:generate
```

#### 2. "SQLSTATE[HY000]: General error: 1030 Got error"
```bash
# Issue: Database not connected properly
# Solution: Verify .env database credentials and ensure MySQL is running
php artisan migrate:fresh --seed
```

#### 3. "Class Not Found" Errors
```bash
# Fix: Regenerate autoloader
composer dump-autoload
```

#### 4. "npm ERR! Cannot find module"
```bash
# Fix: Reinstall dependencies
npm install
npm run build
```

#### 5. CORS or 404 Errors
```bash
# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

#### 6. Permission Denied on Storage
```bash
# On Windows (run as Administrator):
# Skip - Usually not needed

# On Linux/Mac:
chmod -R 775 storage bootstrap/cache
```

---

## 📝 Default Login Credentials

After importing the database, you can login with:

| Role | Email | Password |
|------|-------|----------|
| Admin | `macalutasreyramesesjudeiii@gmail.com` | Check seeders or reset |
| Voter | `1901102366@student.buksu.edu.ph` | Check seeders or reset |

> ⚠️ **IMPORTANT**: Change these credentials immediately in production!

To reset passwords:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->password = Hash::make('newpassword');
>>> $user->save();
```

---

## 🧪 Testing

### Run Feature Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test tests/Feature/VotingTest.php
```

### Generate Test Coverage
```bash
php artisan test --coverage
```

---

## 📚 Laravel Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templating](https://laravel.com/docs/blade)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)

---

## 📄 License

MIT License - See LICENSE file for details

---

## 👤 Support

For issues or questions, refer to the troubleshooting section or contact the development team.

**Last Updated**: April 2026

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
