# Verified Stack — LearnFlow LMS

Recorded during **TASK-001 Project Foundation** on the development machine used for bootstrap.

| Component | Target (docs) | Verified actual | Notes |
|---|---|---|---|
| PHP | 8.4.x | 8.4.25 | CLI runtime used for Artisan and tests |
| Laravel Framework | 13.x | 13.29.0 | `php artisan --version` |
| Laravel Skeleton | 13.x | 13.0.0 | `laravel/laravel` project template |
| Livewire | 4.x | 4.4.3 | Required for Laravel 13 compatibility |
| PHPUnit | 12.x | 12.5.34 | via `composer.lock` |
| Node.js | 20+ | 22.20.0 | for Vite asset pipeline |
| npm | 10+ | 10.9.3 | |
| Tailwind CSS | 4.x | lockfile-driven | built with Vite |
| Alpine.js | bundled | Livewire ESM bundle | `resources/js/app.js` |
| MySQL | 8.4.x | **Not verified in this environment** | `mysql` CLI not available on PATH; configure per deployment |

## Environment notes

- `pdo_mysql` is available in PHP.
- `pdo_sqlite` is **not** enabled in the current PHP build, so PHPUnit's default sqlite in-memory configuration will skip DB connectivity tests unless MySQL is configured or sqlite is enabled.
- `.env.example` defaults to MySQL to match product target architecture.

## Re-verification command

After dependency or runtime changes, update this file:

```bash
php -v
php artisan --version
composer show laravel/framework livewire/livewire --installed
node -v
npm -v
```
