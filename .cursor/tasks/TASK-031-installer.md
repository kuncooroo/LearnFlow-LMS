# TASK-031: Installer

**Roadmap phase:** Phase 12 — Installer
**Estimated focus:** One focused feature

## Task ID

TASK-031

## Title

Installer

## Objective

Build a Laravel-native installation flow for commercial self-hosted setup with lock after success.

## Background

ROADMAP Phase 12. Required for source-code product distribution.

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

- TASK-030 core tests passing
- Stable migrations/settings

## Files likely affected

```text
app/Http/Controllers/Install/*
app/Livewire/Install/*
resources/views/install/*
routes/install.php
app/Actions/Install/*
tests/Feature/Install/*
```

## Database changes

- Runs migrations during install; creates admin + institution.

## Backend requirements

- Steps: requirements → env → DB check → migrate → admin → institution → lock
- Write env carefully; never expose secrets in UI logs
- Lock file/flag prevents re-install

## Frontend requirements

- Wizard UI with clear errors; progress steps.

## Validation rules

- DB credentials; admin email unique; password rules; requirements PHP extensions.

## Authorization rules

- Installer only when not locked; disabled in installed production.

## Business rules

- Migration failure ≠ success; partial install recovery guidance.

## Edge cases

- Invalid DB; re-run attempt after lock; missing extensions.

## Security considerations

- Lock installer; no credential echo; HTTPS note for production.

## Testing requirements

- Clean install; invalid DB; duplicate install blocked; lock; boot after install.

## Acceptance criteria

- [ ] Fresh environment installs successfully
- [ ] Admin + institution created
- [ ] Installer locks
- [ ] Failures reported honestly

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
