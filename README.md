# Asset Management System

A PHP-based asset management system built for DAW course project.

## Features

- ✅ MVC Architecture
- ✅ Equipment CRUD Operations
- ✅ Employee Management
- ✅ Allocation System
- ✅ Authentication & Authorization (Login Required!)
- ✅ Image Carousel
- ✅ Responsive Design
- ✅ SQL Injection Protection (Prepared Statements)
- ✅ XSS Protection
- ✅ Unit Tests (PHPUnit) - 16 tests passing!

## Requirements

- PHP 7.4 or higher
- SQLite
- Composer

## Installation

1. Clone the repository
```bash
git clone <repository-url>
cd proiect_DAW
```

2. Install dependencies
```bash
composer install
```

3. Initialize database
```bash
php config/init_db.php
```

4. Start PHP built-in server
```bash
php -S localhost:8000
```

5. Open browser
```
http://localhost:8000
```

## Login

The application requires login to access.

**Credentials:**
- Email: `admin@company.com`
- Password: `admin123`

You will be automatically redirected to the login page if not authenticated.

## Running Tests

```bash
vendor/bin/phpunit tests/
```

All 16 tests should pass! ✅

## Project Structure

```
proiect_DAW/
├── config/          # Database configuration
├── controller/       # Controllers (MVC)
├── model/          # Models (MVC)
├── view/           # Views (MVC)
├── public/         # Public assets (CSS, images)
├── tests/          # PHPUnit tests
└── index.php       # Entry point with authentication
```

## Protected Routes

The following routes require authentication:
- `/index.php` - Redirects to login if not logged in
- Equipment management (all actions)
- Allocation management

Only the login page is accessible without authentication.

## Technologies Used

- PHP
- SQLite
- HTML5
- CSS3 (Responsive Design)
- PHPUnit
- PDO (Prepared Statements)

## Grading Requirements Met

### Nota 3: Database ✅
- Database in 3rd normal form
- SQLite database

### Nota 4: Functional Scenarios ✅
1. Add equipment
2. View equipment list
3. Delete equipment
4. Allocate equipment

### Nota 5: MVC Pattern ✅
- Model, View, Controller all implemented

### Nota 6: Site Content ✅
- Images (carousel)
- Text
- Tables (equipment list)
- Links
- Forms

### Nota 7: Classes & Interface ✅
- 3+ classes: EquipmentModel, EmployeeModel, AllocationModel, ServerModel
- 1 interface: CRUDInterface
- Authentication implemented

### Nota 8: Advanced Features ✅
- Inheritance: ServerModel extends EquipmentModel
- 2 exceptions: InvalidCredentialsException, StockZeroException
- Image carousel/slideshow

### Nota 9: CSS & Responsive Design ✅
- 2 CSS files: main.css, responsive.css
- 50+ CSS properties total
- Responsive design with media queries

### Nota 10: Tests & Security ✅
- 16 PHPUnit tests (more than required 5)
- SQL injection protection (prepared statements)
- XSS protection (htmlspecialchars)
- Git usage
- Clean code

## Authors

DAW Project Team
