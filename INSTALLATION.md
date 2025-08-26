# Installation Guide

This guide will walk you through the complete installation process for the Codecanyon Database Installation and Tools Required System.

## 🚀 Quick Installation (Recommended)

### Prerequisites
- **PHP**: 8.1 or higher
- **Composer**: Latest version
- **Docker**: Docker and Docker Compose (for easy setup)
- **Web Server**: Apache/Nginx (for production)

### Step 1: Clone and Setup
```bash
# Clone the repository
git clone <your-repository-url>
cd codecanyon-database-installation-and-tools-required-system

# Install PHP dependencies
composer install

# Install Node.js dependencies (if using frontend assets)
npm install
```

### Step 2: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Start Docker Services
```bash
# Start all services (MySQL, PHP, phpMyAdmin)
docker-compose up -d

# Check if services are running
docker-compose ps
```

### Step 4: Run Installation Wizard
1. Open your browser and navigate to: `http://localhost:8000/install`
2. Follow the step-by-step installation process:
   - **Step 1**: Welcome and system requirements
   - **Step 2**: Check PHP extensions and permissions
   - **Step 3**: Database configuration
   - **Step 4**: Create admin user
   - **Step 5**: Installation complete

### Step 5: Access Your Application
- **Frontend**: `http://localhost:8000`
- **Admin Panel**: `http://localhost:8000/admin`
- **phpMyAdmin**: `http://localhost:8080`

## 🔧 Manual Installation (Advanced)

### Database Setup
```bash
# Create database manually
mysql -u root -p
CREATE DATABASE your_app_name;
CREATE USER 'your_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON your_app_name.* TO 'your_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Environment Variables
Edit your `.env` file:
```env
APP_NAME="Your Application Name"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_app_name
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### Run Migrations and Seeders
```bash
# Run database migrations
php artisan migrate

# Seed default data
php artisan db:seed

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 🐳 Docker Configuration

### Docker Compose Services
The `docker-compose.yml` file includes:

- **App**: Laravel application (PHP 8.1)
- **DB**: MySQL 8.0 database
- **phpMyAdmin**: Database management interface

### Customizing Docker Setup
```yaml
# Modify ports in docker-compose.yml
ports:
  - "8000:8000"  # App port
  - "3308:3306"  # MySQL port
  - "8080:80"    # phpMyAdmin port
```

### Docker Commands
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f

# Access container shell
docker-compose exec app bash
docker-compose exec db mysql -u root -p
```

## 🌐 Web Server Configuration

### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/your/app/public
    
    <Directory /path/to/your/app/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/app/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔒 Security Configuration

### Production Settings
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Force HTTPS
FORCE_HTTPS=true

# Secure session settings
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

### File Permissions
```bash
# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

## 📊 Database Management

### Using phpMyAdmin
1. Access `http://localhost:8080`
2. Login with:
   - **Username**: `root`
   - **Password**: `root`
3. Select your database from the left sidebar
4. Manage tables, data, and structure

### Database Backup
```bash
# Create backup
docker-compose exec db mysqldump -u root -proot your_app_name > backup.sql

# Restore backup
docker-compose exec -T db mysql -u root -proot your_app_name < backup.sql
```

## 🚨 Troubleshooting

### Common Issues

#### 1. Database Connection Failed
```bash
# Check if MySQL is running
docker-compose ps

# Check MySQL logs
docker-compose logs db

# Test connection
docker-compose exec app php artisan tinker
DB::connection()->getPdo();
```

#### 2. Permission Denied
```bash
# Fix storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Fix ownership
chown -R $USER:www-data storage/
chown -R $USER:www-data bootstrap/cache/
```

#### 3. Composer Issues
```bash
# Clear composer cache
composer clear-cache

# Update composer
composer self-update

# Install with verbose output
composer install -vvv
```

#### 4. Migration Errors
```bash
# Reset migrations
php artisan migrate:reset

# Fresh install
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

### Log Files
```bash
# View Laravel logs
tail -f storage/logs/laravel.log

# View Docker logs
docker-compose logs -f app
docker-compose logs -f db
```

## 📱 Post-Installation

### First Login
1. Navigate to `/admin/login`
2. Use the admin credentials created during installation
3. Access the dashboard at `/admin/dashboard`

### Initial Configuration
1. **Settings**: Configure site name, email, and description
2. **Users**: Create additional user accounts
3. **Security**: Review and update security settings

### Regular Maintenance
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Update dependencies
composer update
npm update

# Database maintenance
php artisan migrate
php artisan db:seed
```

## 🆘 Support

If you encounter any issues:

1. **Check Logs**: Review Laravel and Docker logs
2. **Documentation**: Refer to this guide and README.md
3. **Community**: Laravel forums and Discord
4. **Issues**: Create an issue in the repository

## 🔄 Updates

### Updating the Application
```bash
# Backup database
docker-compose exec db mysqldump -u root -proot your_app_name > backup.sql

# Pull latest changes
git pull origin main

# Update dependencies
composer install
npm install

# Run migrations
php artisan migrate

# Clear caches
php artisan config:clear
php artisan cache:clear
```

---

**Need help? Check the main README.md file for additional information and troubleshooting tips.** 