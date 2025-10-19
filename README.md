# LaravelStark

<p>
    <a href="https://github.com/dsolodev/laravelstark/actions"><img src="https://github.com/dsolodev/laravelstark/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/dt/dsolodev/laravelstark" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/v/dsolodev/laravelstark" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/dsolodev/laravelstark"><img src="https://img.shields.io/packagist/l/dsolodev/laravelstark" alt="License"></a>
</p>

**LaravelStark** is a opinionated starter kit [Laravel](https://laravel.com) with [Filament](https://filamentphp.com/)
skeleton that enforces rigorous development standards through meticulous
tooling configuration and architectural decisions that prioritize type safety, immutability, and fail-fast principles.

## Getting Started

> **Requires [PHP 8.4+](https://php.net/releases/)**.

### Installation

You can use the [Laravel Installer](https://laravel.com/docs#installing-php) to install this starter kit.

```bash
laravel new my-app --using=dsolodev/laravelstark
```

### Verify Installation

Run the test suite to ensure everything is configured correctly:

```bash
composer test
```

You should see 100% test coverage and all quality checks passing.

## Available Tooling

### Development

- `composer dev` - Starts Laravel server, queue worker, log monitoring, and Vite dev server concurrently

### Code Quality

- `composer lint` - Runs Rector (refactoring), Pint (PHP formatting), and Prettier (JS/TS formatting)
- `composer test:lint` - Dry-run mode for CI/CD pipelines

### Testing

- `composer test:type-coverage` - Ensures 100% type coverage with Pest
- `composer test:types` - Runs PHPStan at level 9 (maximum strictness)
- `composer test:unit` - Runs Pest tests with 100% code coverage requirement
- `composer test` - Runs the complete test suite (type coverage, unit tests, linting, static analysis)

### Maintenance

- `composer update:requirements` - Updates all PHP and NPM dependencies to latest versions

## License

**LaravelStark** was created by me for personal use and licensed under
the [MIT license](https://opensource.org/licenses/MIT).
