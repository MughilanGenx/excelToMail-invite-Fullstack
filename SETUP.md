# TC Invitation Mail - Setup Guide

## Project Overview

**TC Invitation Mail** is a Laravel 12 web application for managing bulk email invitations. It allows users to:
- Upload Excel files with recipient data
- Map Excel columns to custom labels
- Save and manage recipient lists
- Send bulk invitation emails with delivery tracking
- View mail delivery reports with success/failure status

## System Requirements

### Prerequisites
- **PHP**: 8.2 or higher
- **Node.js**: 18+ (for npm)
- **Composer**: Latest version (for PHP package management)
- **Database**: SQLite (included) or MySQL/PostgreSQL
- **Git** (optional, for version control)

### Supported Operating Systems
- Windows 10/11
- macOS (Intel/Apple Silicon)
- Linux (Ubuntu 20.04+)

## Installation Steps

### 1. Clone or Setup the Project
```bash
cd d:\Laravel Project\tc-invitation-mail
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy environment file
copy .env.example .env
# On Linux/Mac: cp .env.example .env
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Build Frontend Assets
```bash
npm run build
```

### 7. Run Database Migrations
```bash
php artisan migrate
```

### 8. Start the Application
```bash
# Option 1: Simple mode (development server only)
php artisan serve

# Option 2: Full development with queue and logs (recommended)
composer run dev
```

The application will be accessible at: `http://localhost:8000`

## Quick Setup (One Command)

Run the automated setup script from `composer.json`:
```bash
composer run setup
```

This will automatically:
- Install composer dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Install npm dependencies
- Build frontend assets

## Package Dependencies

### PHP Packages (composer.json)

**Core Dependencies:**
- `laravel/framework: ^12.0` - Laravel framework
- `laravel/tinker: ^2.10.1` - Interactive REPL for Laravel
- `phpoffice/phpspreadsheet: ^5.6` - Excel file handling (reading/writing)

**Development Dependencies:**
- `laravel/pail: ^1.2.2` - Real-time log viewer
- `laravel/pint: ^1.24` - Code style formatter
- `laravel/sail: ^1.41` - Docker development environment
- `mockery/mockery: ^1.6` - Mocking library for tests
- `nunomaduro/collision: ^8.6` - Error handling and display
- `phpunit/phpunit: ^11.5` - Testing framework
- `fakerphp/faker: ^1.23` - Fake data generation

### Node Packages (package.json)

**Build & Development Tools:**
- `vite: ^7.0.7` - Fast build tool and dev server
- `laravel-vite-plugin: ^2.0.0` - Laravel integration for Vite
- `concurrently: ^9.0.1` - Run multiple processes simultaneously

**Frontend Styling:**
- `tailwindcss: ^4.0.0` - Utility-first CSS framework
- `@tailwindcss/vite: ^4.0.0` - Tailwind CSS Vite plugin

**HTTP Client:**
- `axios: ^1.11.0` - Promise-based HTTP client for JavaScript

## Database Schema

### Tables Created

#### 1. users
- Default Laravel users table
- Stores application users

#### 2. excel_column_data
- `id`: Primary key
- `column_name`: Custom user-defined label
- `excel_column`: Original Excel header
- `data`: Comma-separated values (e.g., emails)
- `timestamps`: Created and updated timestamps

#### 3. mail_logs
- `id`: Primary key
- `subject`: Email subject line
- `from_name`: Sender's name
- `record_id`: Reference to excel_column_data
- `total`: Total emails to send
- `sent`: Successfully sent count
- `failed`: Failed delivery count
- `timestamps`: Created and updated timestamps

#### 4. mail_log_details
- `id`: Primary key
- `log_id`: Reference to mail_logs (cascade delete)
- `email`: Recipient email address
- `recipient_name`: Recipient's display name
- `status`: Delivery status (sent/failed)
- `error`: Error message (if failed)
- `timestamps`: Created and updated timestamps

## Configuration Files

### Key Configuration Files

**`.env` - Environment Variables**
```
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# For MySQL: DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=tc_invitation
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

**`config/app.php`** - Application configuration
**`config/mail.php`** - Mail driver configuration
**`config/database.php`** - Database connection settings

## Application Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── ExcelController.php    - Upload & manage Excel data
│   │   └── MailController.php     - Send & track mail campaigns
│   ├── Mail/
│   │   └── InvitationMail.php     - Email template class
│   └── Models/
│       ├── ExcelColumnData.php    - Excel data model
│       ├── MailLog.php            - Mail campaign log
│       ├── MailLogDetail.php      - Individual mail delivery status
│       └── User.php               - User model
├── database/
│   ├── migrations/                - Database schema
│   ├── factories/                 - Test data factories
│   └── seeders/                   - Database seeders
├── resources/
│   ├── views/                     - Blade templates
│   │   ├── compose-mail.blade.php - Email composition interface
│   │   ├── excel-upload.blade.php - File upload form
│   │   ├── mail-report.blade.php  - Delivery report
│   │   └── ...
│   ├── js/                        - JavaScript/frontend code
│   └── css/                       - Tailwind CSS styles
├── routes/
│   └── web.php                    - Web application routes
├── config/                        - Configuration files
└── public/
    └── index.php                  - Application entry point
```

## Available Routes

### Excel Management
- `GET /excel-data` - Upload Excel file interface
- `POST /excel-data` - Upload Excel file
- `POST /excel-data/save` - Save column mapping
- `GET /excel-data/saved` - View saved data
- `GET /excel-data/{id}/edit` - Edit record
- `PUT /excel-data/{id}` - Update record
- `DELETE /excel-data/{id}` - Delete record

### Mail Campaign
- `GET /send-mail` - Compose email interface
- `POST /send-mail` - Send bulk emails
- `GET /send-mail/report/{logId}` - View delivery report

### Home
- `GET /` - Home page

## Running the Application

### Development Mode (Recommended)
```bash
composer run dev
```
This starts:
- PHP development server
- Queue listener
- Log viewer (Pail)
- Vite dev server (CSS/JS hot reload)

### Simple Development
```bash
php artisan serve
```
Application runs at `http://localhost:8000`

### Build for Production
```bash
npm run build
php artisan config:cache
```

## Testing

Run tests with PHPUnit:
```bash
composer run test
```

Or run tests directly:
```bash
php artisan test
```

## Database Operations

### Run Migrations
```bash
php artisan migrate
```

### Rollback Migrations
```bash
php artisan migrate:rollback
```

### Reset Database
```bash
php artisan migrate:reset
```

### Refresh Database
```bash
php artisan migrate:refresh
```

### Seed Database
```bash
php artisan db:seed
```

## Mail Configuration

### Development (Logging)
Default setup logs emails to `storage/logs/laravel.log`

### SMTP Configuration
Update `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Available Mail Drivers
- `log` - Log to file (development)
- `smtp` - Send via SMTP server
- `mailgun` - Mailgun service
- `ses` - AWS SES
- `sendmail` - System sendmail

## Troubleshooting

### Issue: PHP not found
**Solution**: Ensure PHP is installed and in PATH, or use full path to PHP executable

### Issue: Composer packages not installing
**Solution**: 
```bash
composer install --no-interaction
composer update
```

### Issue: NPM packages not installing
**Solution**:
```bash
npm install --legacy-peer-deps
npm cache clean --force
```

### Issue: Database migrations fail
**Solution**:
```bash
php artisan migrate:reset
php artisan migrate
```

### Issue: Vite assets not loading in development
**Solution**:
```bash
npm run dev
# In another terminal:
php artisan serve
```

## Environment Variables Reference

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | Laravel |
| `APP_ENV` | Environment (local/production) | local |
| `APP_DEBUG` | Enable debug mode | true |
| `APP_URL` | Application URL | http://localhost:8000 |
| `DB_CONNECTION` | Database driver | sqlite |
| `MAIL_MAILER` | Mail driver | log |
| `MAIL_FROM_ADDRESS` | From email address | noreply@example.com |

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vite Guide](https://vitejs.dev)
- [Tailwind CSS](https://tailwindcss.com)
- [PHP Spreadsheet](https://phpspreadsheet.readthedocs.io)

## License

MIT License - see LICENSE file for details

## Support

For issues or questions, check the Laravel documentation or review the application logs at `storage/logs/`.
