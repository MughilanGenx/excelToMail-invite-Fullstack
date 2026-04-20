# TC Invitation Mail

<p align="center">
A Laravel 12 application for managing bulk email invitations with Excel integration and delivery tracking.
</p>

## About This Project

**TC Invitation Mail** is a web application built with Laravel 12 that simplifies bulk email campaigns. Features include:

- 📊 **Excel Integration** - Upload and parse Excel files with recipient data
- 🏷️ **Column Mapping** - Map Excel columns to custom labels
- 📧 **Bulk Email** - Send invitation emails to multiple recipients
- 📈 **Delivery Tracking** - Monitor email delivery status with detailed reports
- 💾 **Data Management** - Save and manage recipient lists
- 🎨 **Modern UI** - Built with Tailwind CSS and responsive design

### Tech Stack

- **Backend**: Laravel 12 Framework
- **Frontend**: Blade Templates + Tailwind CSS + Vite
- **Data Processing**: PHPOffice/PhpSpreadsheet
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Testing**: PHPUnit

## Quick Start

### Installation (One Command)
```bash
composer run setup
```

This will automatically:
1. Install all PHP dependencies
2. Install all Node.js dependencies
3. Generate application key
4. Run database migrations
5. Build frontend assets

### Start Development Server
```bash
# Option 1: Full development environment (recommended)
composer run dev

# Option 2: Simple server only
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Complete Setup Guide

For detailed setup instructions, database schema, configuration options, and troubleshooting, see [SETUP.md](SETUP.md).

## System Requirements

- **PHP 8.2+**
- **Node.js 18+**
- **Composer**
- **SQLite, MySQL, or PostgreSQL**

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── ExcelController.php      # Excel upload & management
│   │   └── MailController.php       # Email campaigns
│   ├── Mail/
│   │   └── InvitationMail.php       # Email template
│   └── Models/
│       ├── ExcelColumnData.php
│       ├── MailLog.php
│       ├── MailLogDetail.php
│       └── User.php
├── database/
│   └── migrations/                  # Database schema
├── resources/
│   ├── views/                       # Blade templates
│   ├── css/                         # Tailwind styles
│   └── js/                          # Frontend scripts
├── routes/
│   └── web.php                      # Application routes
└── config/                          # Configuration files
```

## Core Features

### 1. Excel Data Upload
- Upload Excel files with recipient information
- Automatic column detection
- Custom column mapping (rename/organize)
- Data preview before saving

### 2. Recipient Management
- View saved recipient lists
- Edit column data
- Delete records
- Search and filter functionality

### 3. Bulk Email Campaigns
- Compose invitation emails
- Select recipient source
- Attach templates
- Schedule sending

### 4. Delivery Tracking
- Real-time delivery status
- Success/failure reports
- Error logging
- Recipient-level tracking
- Campaign analytics

## Dependencies Summary

### PHP Packages (via Composer)
- **laravel/framework ^12.0** - Web framework
- **phpoffice/phpspreadsheet ^5.6** - Excel file processing
- **laravel/tinker ^2.10.1** - Interactive shell
- Development: Testing, code formatting, error handling

### Node Packages (via npm)
- **vite ^7.0** - Build tool & dev server
- **tailwindcss ^4.0** - CSS framework
- **laravel-vite-plugin ^2.0** - Laravel integration
- **axios ^1.11** - HTTP client
- **concurrently ^9.0** - Multi-process runner

See [SETUP.md](SETUP.md) for the complete package list and versions.

## Database Schema

The application uses 4 main tables:

1. **excel_column_data** - Stores imported Excel column data
2. **mail_logs** - Tracks email campaigns
3. **mail_log_details** - Individual email delivery records
4. **users** - Application users

## Configuration

### Environment Variables (.env)

```ini
APP_NAME=TC Invitation Mail
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@example.com
```

## Running Tests

```bash
# Run all tests
composer run test

# Or directly
php artisan test
```

## Database Management

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database
php artisan migrate:reset
```

## Development Commands

```bash
# Start full dev environment
composer run dev

# Start simple server
php artisan serve

# Build frontend
npm run build

# Dev frontend (with hot reload)
npm run dev

# Format code
php artisan pint

# Interactive shell
php artisan tinker
```

## Troubleshooting

**PHP not found?** Ensure PHP is installed and in your system PATH.

**Composer install fails?** Try: `composer install --no-interaction`

**Assets not loading?** Run: `npm install` then `npm run build`

**Database errors?** Run: `php artisan migrate:reset` then `php artisan migrate`

See [SETUP.md](SETUP.md) for detailed troubleshooting guide.

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vite Guide](https://vitejs.dev)
- [Tailwind CSS](https://tailwindcss.com)
- [PHPSpreadsheet](https://phpspreadsheet.readthedocs.io)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
