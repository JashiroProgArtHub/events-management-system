# Installation & Setup Guide - SAO Event Management System

## Quick Start (5 minutes)

### 1. Install Dependencies
```bash
cd c:\Users\Admin\Desktop\Jashen\web-projects\ipt\events-management-system
composer install
```

### 2. Configure Environment
```bash
# Create or edit .env file with:
APP_KEY=
DB_DATABASE=sao_events
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Key & Migrate
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 4. Start Server
```bash
php artisan serve
# Visit: http://localhost:8000
# Login: admin / password123
```

---

## Detailed Installation Steps

### Prerequisites
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher  
- **Composer**: Latest version
- **Node.js**: Optional (for asset compilation)

### Step-by-Step Setup

#### Step 1: Clone/Navigate to Project
```bash
cd c:\Users\Admin\Desktop\Jashen\web-projects\ipt\events-management-system
```

#### Step 2: Install PHP Dependencies
```bash
composer install
```

#### Step 3: Create Environment File
Create `.env` file in project root:
```env
APP_NAME="SAO Event Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

APP_KEY=

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sao_events
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=noreply@saoevents.local
MAIL_FROM_NAME="${APP_NAME}"
```

#### Step 4: Generate Application Key
```bash
php artisan key:generate
```

#### Step 5: Create Database
**Option A: MySQL Command Line**
```bash
mysql -u root -p
CREATE DATABASE sao_events;
EXIT;
```

**Option B: MySQL Workbench or PhpMyAdmin**
- Create new database named `sao_events`
- Set character set to `utf8mb4`
- Set collation to `utf8mb4_unicode_ci`

#### Step 6: Run Migrations
```bash
php artisan migrate
```

Expected output:
```
Migrating: 2024_01_01_000000_create_admins_table
Migrated:  2024_01_01_000000_create_admins_table (###ms)
Migrating: 2024_01_02_000000_create_events_table
Migrated:  2024_01_02_000000_create_events_table (###ms)
Migrating: 2024_01_03_000000_create_participants_table
Migrated:  2024_01_03_000000_create_participants_table (###ms)
```

#### Step 7: Seed Database (Optional - Adds Demo Data)
```bash
php artisan db:seed
```

This creates:
- 1 admin account (username: `admin`, password: `password123`)
- 4 sample events
- 20+ sample participants

#### Step 8: Start Development Server
```bash
php artisan serve
```

Output:
```
Laravel development server started on [http://127.0.0.1:8000]
```

#### Step 9: Access Application
- **URL**: `http://localhost:8000`
- **Login**: Username `admin` / Password `password123`

---

## Troubleshooting

### Issue: "SQLSTATE[HY000]: General error: 1030 Got error..."
**Solution**:
```bash
# Check database connection in .env
# Ensure MySQL is running
# Verify database exists
mysql -u root -p -e "SHOW DATABASES;"
```

### Issue: "Migration table not found"
**Solution**:
```bash
php artisan migrate:fresh
# Or rollback and re-run
php artisan migrate:rollback
php artisan migrate
```

### Issue: "Class ... not found" or Autoloader errors
**Solution**:
```bash
# Regenerate autoload files
composer dump-autoload
php artisan cache:clear
```

### Issue: "Composer memory limit error"
**Solution**:
```bash
# Increase memory limit
php -d memory_limit=-1 composer.phar install
```

### Issue: Blank page or 500 error
**Solution**:
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Regenerate key
php artisan key:generate
```

### Issue: Port 8000 already in use
**Solution**:
```bash
# Use different port
php artisan serve --port=8001

# Or kill process using port 8000
# On Windows:
netstat -ano | findstr :8000
taskkill /PID <PID> /F
```

---

## Database Schema Verification

After migration, verify tables were created:

```bash
# Connect to MySQL
mysql -u root -p sao_events

# Show tables
SHOW TABLES;

# Verify admins table
DESC admins;

# Verify events table
DESC events;

# Verify participants table
DESC participants;
```

---

## First Login & Initial Setup

### Default Admin Credentials
- **Username**: `admin`
- **Email**: `admin@saoevents.com`
- **Password**: `password123`

### First Steps
1. Login with default credentials
2. Change password immediately
3. Navigate to Dashboard to see demo data
4. Create a new event to familiarize yourself
5. Add participants to an event

---

## File Permissions (Linux/Mac)

If running on Linux/Mac, ensure proper permissions:

```bash
# Set directory permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Set file ownership
sudo chown -R www-data:www-data /path/to/project
```

---

## Development Mode Commands

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Database Commands
```bash
# Fresh migration (drops and recreates all tables)
php artisan migrate:fresh

# Rollback one batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Re-seed database
php artisan db:seed
```

### Development Utilities
```bash
# List all routes
php artisan route:list

# Show Laravel version
php artisan --version

# Interactive shell
php artisan tinker

# Generate dummy data (if factories exist)
php artisan tinker
# Then type:
# App\Models\Admin::factory(5)->create()
```

---

## Production Deployment

### Before Going Live
1. **Change APP_ENV to production**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Disable query logging**
   ```env
   DB_LOG_QUERIES=false
   ```

3. **Use strong password for database**
   ```env
   DB_PASSWORD=secure_password_here
   ```

4. **Change default admin credentials**
   ```bash
   php artisan tinker
   # Update admin password:
   $admin = App\Models\Admin::first();
   $admin->password = Hash::make('new_strong_password');
   $admin->save();
   ```

5. **Run in production mode**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan event:cache
   ```

6. **Enable HTTPS**
   - Obtain SSL certificate
   - Update APP_URL to https://

7. **Set up proper logging**
   - Configure log rotation
   - Monitor error logs

8. **Database backups**
   - Set up automatic backups
   - Test restore procedures

---

## Running on Different Servers

### Apache
- Enable mod_rewrite
- Point DocumentRoot to `public` folder
- Add .htaccess rules (already included)

### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/project/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Docker
Create `Dockerfile`:
```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    mysql-client \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install

EXPOSE 9000
```

---

## Support & Documentation

- **Laravel Docs**: https://laravel.com/docs/12.x
- **Eloquent ORM**: https://laravel.com/docs/12.x/eloquent
- **Blade Templates**: https://laravel.com/docs/12.x/blade
- **Bootstrap 5**: https://getbootstrap.com/docs/5.3

---

## Next Steps

1. ✅ Installation complete
2. 📖 Read [README.md](README.md) for feature overview
3. 🔍 Explore the codebase structure
4. 🚀 Create your first event
5. 📊 View dashboard analytics
6. 🔐 Update security configurations

Enjoy using the SAO Event Management System! 🎉
