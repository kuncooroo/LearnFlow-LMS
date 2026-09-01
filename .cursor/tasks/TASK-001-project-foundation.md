# TASK-001: Project Foundation

**Roadmap phase:** Phase 0 — Project Foundation
**Estimated focus:** Bootstrap only; no LMS business features

## Task ID

TASK-001

## Title

Project Foundation

## Objective

Bootstrap a clean Laravel modular monolith with verified stack, base layouts, asset pipeline, env templates, test harness, and directory conventions ready for feature work.

## Background

LearnFlow is a greenfield commercial LMS. ROADMAP Phase 0 requires a verifiable foundation before authentication or domain features. Stack target: Laravel 13.x, PHP 8.4.x, MySQL 8.4.x, Blade, Livewire, Alpine.js, Tailwind CSS on VPS.

**Authoritative references**
- `docs/PRD.md`
- `docs/SRS.md`
- `docs/SYSTEM_DESIGN.md`
- `docs/DATABASE.md`
- `docs/BUSINESS_FLOW.md`
- `docs/ROADMAP.md`
- `docs/PROJECT_STRUCTURE.md`
- `CURSOR.md`

## Dependencies

- None (first implementation task).

## Files likely affected

```text
composer.json
package.json
.env.example
README.md
bootstrap/
config/
app/Providers/
app/Actions/ (empty scaffold dirs per PROJECT_STRUCTURE)
app/Models/
app/Livewire/
resources/views/layouts/
resources/css/
resources/js/
routes/web.php
tests/
docs/ (ensure canonical doc copies/links)
phpunit.xml / pest.php
```

## Database changes

- Create initial Laravel operational tables only as required by verified drivers (sessions/jobs/cache if DB-backed).
- No LMS business tables yet.
- Confirm MySQL connection and clean `migrate` on empty database.

## Backend requirements

- Create/verify Laravel application.
- Record verified versions of Laravel, PHP, MySQL, Livewire, Alpine, Tailwind in docs if they differ from targets.
- Establish module directory conventions from `docs/PROJECT_STRUCTURE.md`.
- Configure logging, exception handling, and environment-controlled debug.
- Add base middleware group structure for later auth routes.
- Ensure queue/cache/mail have safe local defaults without secrets in repo.

## Frontend requirements

- Base Blade layout (`layouts/app`, `layouts/guest`) with Tailwind.
- Alpine.js loaded for small UI interactions.
- One sample Livewire component proving Livewire + Blade integration.
- Base error pages (404/403/500) without stack traces in production mode.
- Asset build via Vite succeeds.

## Validation rules

- N/A for business forms; ensure env validation for required APP/DB keys in installer later is not blocked by missing `.env.example` keys.

## Authorization rules

- No role system yet. Protect nothing beyond future placeholders. Do not fake auth.

## Business rules

- No LMS business rules. Do not invent multi-tenancy or payment tables.

## Edge cases

- Missing `.env` fails clearly.
- Asset build failure is detectable.
- Migration on empty DB succeeds idempotently for foundation tables.

## Security considerations

- Never commit `.env` or credentials.
- Provide safe `.env.example` placeholders only.
- Debug must be env-controlled.
- Secure session cookie defaults prepared for later production hardening.

## Testing requirements

- Application boots.
- Database connectivity smoke test.
- Simple feature test (home/guest page).
- Simple Livewire render test.
- `php artisan test` (or project test command) runs green.

## Acceptance criteria

- [ ] App starts locally
- [ ] DB connects; clean migrations run
- [ ] Frontend assets compile
- [ ] Blade + Livewire + Alpine + Tailwind work
- [ ] Test suite command executes
- [ ] No secrets in repository
- [ ] Version verification noted if TBD → actual

## Definition of Done

- [ ] Objective implemented as specified
- [ ] Validation implemented server-side
- [ ] Authorization enforced server-side (not UI-only)
- [ ] Business rules match PRD / BUSINESS_FLOW
- [ ] Error, empty, and loading states handled where relevant
- [ ] Audit behavior implemented if required by this task
- [ ] Automated tests added and passing
- [ ] No credentials committed
- [ ] No unrelated refactor
- [ ] Documentation updated if behavior/schema/env changed
- [ ] N+1 checked for new list/detail queries
