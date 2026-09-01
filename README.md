# LearnFlow LMS

Commercial Learning Management System built as a **Laravel modular monolith**.

## Verified stack (TASK-001)

| Component | Target | Verified |
|---|---|---|
| PHP | 8.4.x | 8.4.25 |
| Laravel | 13.x | 13.29.0 |
| Livewire | 4.x | 4.4.3 |
| Tailwind CSS | 4.x | via Vite build |
| Alpine.js | bundled | via Livewire ESM bundle |
| MySQL | 8.4.x | configure locally |

See `docs/VERIFIED_STACK.md` for environment notes.

## Requirements

- PHP 8.4+
- Composer
- Node.js 20+
- MySQL 8.4+ (recommended) or SQLite with `pdo_sqlite` enabled

## Local setup

```bash
cp .env.example .env
php artisan key:generate
composer install
npm install
npm run build
php artisan migrate
php artisan serve
```

Visit `http://127.0.0.1:8000`.

## Development

```bash
composer dev
```

Runs the Laravel server, queue listener, log tail, and Vite dev server together.

## Testing

```bash
php artisan test
```

Database connectivity tests skip automatically when the configured driver is unavailable.

## Documentation

Authoritative product and engineering docs live in `docs/`:

- `docs/PRD.md`
- `docs/SRS.md`
- `docs/SYSTEM_DESIGN.md`
- `docs/BUSINESS_FLOW.md`
- `docs/DATABASE.md`
- `docs/PROJECT_STRUCTURE.md`
- `docs/ROADMAP.md`
- `CURSOR.md`

## Architecture

Follow `docs/PROJECT_STRUCTURE.md`. Application code is grouped by layer (`Actions`, `Livewire`, `Policies`, etc.) with domain subfolders.

## License

MIT
