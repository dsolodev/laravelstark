# LaravelStark

<p>
    <a href="https://github.com/dsolodev/laravelstark/actions"><img src="https://github.com/dsolodev/laravelstark/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/dt/dsolodev/laravelstark" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/v/dsolodev/laravelstark" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/l/dsolodev/laravelstark" alt="License"></a>
</p>

**LaravelStark** is an opinionated starter kit for [Laravel](https://laravel.com)
with [Filament](https://filamentphp.com/) that enforces rigorous development standards through meticulous tooling
configuration and architectural decisions that prioritize type safety, immutability, and fail-fast principles.

## ✨ Features

- ✅ **100% Type Coverage** with Pest
- ✅ **PHPStan Level 9** (maximum strictness)
- ✅ **Filament 4.1** admin panel pre-configured
- ✅ **Log Viewer** (opcodesio/log-viewer)
- ✅ **Rector**, **Pint**, **Prettier** for automated code quality
- ✅ **GitHub Actions** CI/CD workflows
- ✅ **Strict Models** and immutable dates
- ✅ **SQLite** default (production-ready MySQL/PostgreSQL support)

## 📋 Prerequisites

Before installing LaravelStark, ensure you have:

- **PHP 8.4+** with extensions: `mbstring`, `xml`, `curl`, `pdo`, `sqlite3`, `pdo_sqlite`
- **Composer 2.7+**
- **Node.js 20+** and npm
- **[Laravel Installer](https://laravel.com/docs/installation#creating-a-laravel-project)** (recommended)
- **Database**: SQLite (default), MySQL 8.0+, or PostgreSQL 15+

### Installing Laravel Installer

If you haven't installed the Laravel Installer yet:

```bash
composer global require laravel/installer
```

Make sure Composer's global bin directory is in your PATH.

## 🚀 Installation

### Quick Start with Laravel Installer

You can use the [Laravel Installer](https://laravel.com/docs#installing-php) to install this starter kit.

```bash
laravel new my-app --using=dsolodev/laravelstark
cd my-app
```

### Alternative: Using Composer

```bash
composer create-project dsolodev/laravelstark my-app
cd my-app
```

---

### 1. Install Dependencies

```bash
npm install
npm run build
```

### 2. Environment Setup

The `.env` file is automatically created during installation. Generate your application key:

```bash
php artisan key:generate
```

Review and update `.env` settings as needed:

```env
APP_NAME=LaravelStark
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Configure developer email for log viewer access
DEVELOPER_EMAIL=jc@dsolo.dev

# Database (SQLite by default)
DB_CONNECTION=sqlite
```

### 3. Database Setup

The SQLite database is created automatically during installation. Run migrations and seeders:

```bash
php artisan migrate --seed
```

**Default Developer Credentials:**

- Email: `jc@dsolo.dev`
- Password: `password`

⚠️ **Change these credentials immediately in production!**

### 4. Start Development

```bash
composer dev
```

This command starts multiple services concurrently:

- **Laravel server** at `http://localhost:8000`
- **Queue worker** for background jobs
- **Log monitoring** with Pail
- **Vite dev server** for hot module replacement

**Access Points:**

- Admin Panel: `http://localhost:8000/admin`
- Log Viewer: `http://localhost:8000/log-viewer`

### 6. Verify Installation

Run the test suite to ensure everything is configured correctly:

```bash
composer test
```

You should see all tests passing with 100% coverage and quality checks.

## 🔧 Configuration

### Admin Panel Access

The Filament admin panel is located at the root path (`/`) by default. To change this:

```php
// app/Providers/Filament/AdminPanelProvider.php

public function panel(Panel $panel): Panel
{
    return $panel
        ->path('admin')  // Change from '' to 'admin'
        // ... rest of configuration
}
```

### Log Viewer Authentication

By default, only users with the developer email can access logs. Configure in `.env`:

```env
DEVELOPER_EMAIL=jc@dsolo.dev
```

Or modify the authentication logic:

```php
// app/Providers/AppServiceProvider.php

LogViewer::auth(
    fn(Request $request): bool => $request->user()?->email === config('app.developer_email')
);
```

### Database Configuration

**For MySQL:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelstark
DB_USERNAME=root
DB_PASSWORD=
```

**For PostgreSQL:**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravelstark
DB_USERNAME=postgres
DB_PASSWORD=
```

## 🧪 Testing

### Run Complete Test Suite

```bash
composer test
```

This executes:

1. ✅ Pint code style check (dry-run)
2. ✅ Rector refactoring check (dry-run)
3. ✅ Prettier formatting check
4. ✅ PHPStan static analysis (level max)

### Individual Test Commands

```bash
# Static analysis with PHPStan
composer test:types

# Type coverage check
composer test:type-coverage

# Code style check (dry-run)
composer test:lint

# Refactoring check (dry-run)
composer test:refactor
```

### Fix Code Style Issues

```bash
composer lint
```

This automatically fixes:

- PHP code style with Pint
- PHP refactoring with Rector
- JavaScript/CSS formatting with Prettier

## 📁 Project Structure

```
app/
├── Actions/              # Business logic actions (single-purpose classes)
├── Enums/                # Type-safe enumerations
├── Filament/             # Filament admin panel
│   ├── Resources/        # CRUD resources
│   ├── Pages/            # Custom pages
│   └── Widgets/          # Dashboard widgets
├── Http/
│   └── Controllers/      # HTTP controllers
├── Models/               # Eloquent models
└── Providers/            # Service providers

database/
├── factories/            # Model factories
├── migrations/           # Database migrations
└── seeders/              # Database seeders

tests/
├── Feature/              # Integration/feature tests
└── Unit/                 # Unit tests

resources/
├── css/                  # Tailwind CSS
├── js/                   # JavaScript
└── views/                # Blade templates
```

### Architecture Patterns

**Actions Pattern**

Encapsulate business logic in single-purpose action classes:

```php
// app/Actions/Users/CreateUserAction.php

final readonly class CreateUserAction
{
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);
            // Additional business logic...
            return $user;
        });
    }
}
```

**Type-Safe Enums**

Use enums for constants and status values:

```php
// app/Enums/UserRole.php

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';
}
```

## 🛠️ Development Tools

### Available Commands

```bash
# Start all development services
composer dev

# Code quality
composer lint                    # Auto-fix code style issues
composer test:lint              # Check code style (dry-run)

# Testing
composer test                   # Run full test suite
composer test:types             # Run PHPStan analysis
composer test:type-coverage     # Check type coverage

# Maintenance
composer update:requirements    # Update all dependencies
```

### Pre-configured Tools

- **[Pint](https://laravel.com/docs/pint)** - Code style fixer (PSR-12 + Laravel)
- **[Rector](https://getrector.com/)** - Automated refactoring
- **[PHPStan](https://phpstan.org/)** - Static analysis (level 9)
- **[Pest](https://pestphp.com/)** - Testing framework
- **[Peck](https://github.com/peckphp/peck)** - Spell checker
- **[Prettier](https://prettier.io/)** - JS/CSS formatter
- **[Larastan](https://github.com/larastan/larastan)** - PHPStan for Laravel
- **[Laravel Boost](https://laravel.com/docs/boost)** - Dependency updates (dev)

## 🔍 Troubleshooting

### FontAwesome Icons Not Displaying

**Problem:** Icons show as squares or don't load.

**Solutions:**

1. Verify `.npmrc` exists with correct token:

```bash
cat .npmrc
```

2. Clear npm cache and reinstall:

```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

3. Rebuild assets:

```bash
npm run build
```

4. Clear browser cache or use incognito mode

### Tests Failing

**Problem:** Tests fail after fresh installation.

**Solutions:**

1. Clear Laravel caches:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

2. Regenerate autoload files:

```bash
composer dump-autoload
```

3. Verify database:

```bash
php artisan migrate:fresh --seed
```

4. Check PHP version:

```bash
php -v  # Should be 8.4+
```

### Type Coverage Issues

**Problem:** Type coverage below 100%.

**Solution:**

1. Run type coverage check:

```bash
composer test:type-coverage
```

2. Add missing type hints to flagged methods/properties

3. Example fixes:

```php
// ❌ Before
public function handle($data)
{
    return $this->service->process($data);
}

// ✅ After
public function handle(array $data): ProcessResult
{
    return $this->service->process($data);
}
```

### Database Issues

**SQLite Issues:**

```bash
# Recreate database
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate:fresh --seed
```

**MySQL Connection Failed:**

1. Verify MySQL is running:

```bash
mysql --version
sudo systemctl status mysql  # Linux
brew services list           # macOS
```

2. Check credentials in `.env`
3. Create database:

```bash
mysql -u root -p -e "CREATE DATABASE laravelstark;"
```

### Vite Build Errors

**Problem:** `npm run build` fails.

**Solutions:**

1. Update Node.js to version 20+:

```bash
node -v
```

2. Clear Vite cache:

```bash
rm -rf node_modules/.vite
```

3. Check for port conflicts (default: 5173)

### CI/CD Failures

**Problem:** GitHub Actions failing.

**Solutions:**

1. Ensure `FONTAWESOME_PACKAGE_TOKEN` secret is set in GitHub repo:
    - Go to Settings → Secrets → Actions
    - Add new secret: `FONTAWESOME_PACKAGE_TOKEN`

2. Verify workflows in `.github/workflows/`

3. Check PHP version compatibility in workflows

## 🔐 Security

### Production Deployment Checklist

Before deploying to production:

- [ ] **Change default credentials** (`admin@example.com` / `password`)
- [ ] **Update `ADMIN_EMAIL`** in `.env` to your admin email
- [ ] **Set `APP_DEBUG=false`** in production
- [ ] **Use strong `APP_KEY`** (auto-generated, keep secure)
- [ ] **Configure proper database** (MySQL/PostgreSQL, not SQLite for high-traffic)
- [ ] **Set up mail driver** (not `log` driver)
- [ ] **Enable HTTPS** (`APP_URL=https://yourdomain.com`)
- [ ] **Review file permissions** (755 for directories, 644 for files)
- [ ] **Set up queue worker** (Supervisor or similar)
- [ ] **Configure backups** (database, storage, `.env`)
- [ ] **Never commit** `.env` or `.npmrc` files
- [ ] **Set up monitoring** (Laravel Telescope, Sentry, etc.)
- [ ] **Configure CORS** if using API
- [ ] **Set secure session cookie** (`SESSION_SECURE_COOKIE=true`)

### Environment Security

**Sensitive Files (Never Commit):**

- `.env` - Environment variables
- `.npmrc` - FontAwesome Pro token
- `storage/*.key` - Encryption keys
- `auth.json` - Composer authentication

These are already in `.gitignore`.

### User Permissions

By default, only authenticated users with `is_active = true` can access the admin panel. Modify authorization:

```php
// app/Models/User.php

public function canAccessPanel(Panel $panel): bool
{
    // Add custom logic
    return $this->is_active && $this->hasRole('admin');
}
```

### Code Standards

- Use **strict types**: `declare(strict_types = 1);`
- Add **type hints** on all methods and properties
- Follow **PSR-12** coding standards
- Maintain **100% test coverage**
- Write **descriptive commit messages**
- Run `composer test` before committing

For detailed guidelines, see [CONTRIBUTING.md](CONTRIBUTING.md).

## 📖 Resources

### Official Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Pest Documentation](https://pestphp.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Rector Documentation](https://getrector.com/documentation)

### Packages Used

- **[laravel/framework](https://github.com/laravel/framework)** - The Laravel Framework
- **[filament/filament](https://github.com/filamentphp/filament)** - Admin panel
- **[opcodesio/log-viewer](https://github.com/opcodesio/log-viewer)** - Log viewer
- **[larastan/larastan](https://github.com/larastan/larastan)** - PHPStan for Laravel
- **[pestphp/pest](https://github.com/pestphp/pest)** - Testing framework
- **[rectorphp/rector](https://github.com/rectorphp/rector)** - Automated refactoring
- **[laravel/boost](https://laravel.com/docs/boost)** - Dependency management (dev)

## 📝 License

LaravelStark is open-sourced software licensed under the [MIT license](LICENSE).

## 👤 Author

**Created by:** dsolodev  
**GitHub:** [@dsolodev](https://github.com/dsolodev)  
**Repository:** [dsolodev/laravelstark](https://github.com/dsolodev/laravelstark)

---

⭐ If you find this starter kit helpful, please consider giving it a star on GitHub!

For questions or issues, please open an [issue](https://github.com/dsolodev/laravelstark/issues) or start
a [discussion](https://github.com/dsolodev/laravelstark/discussions).
