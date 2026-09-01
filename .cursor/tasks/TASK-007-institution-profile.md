# TASK-007: Institution Profile

**Roadmap phase:** Phase 3 — Core Master Data
**Estimated focus:** One focused feature

## Task ID

TASK-007

## Title

Institution Profile

## Objective

Implement single-institution profile data used for branding defaults, timezone, and locale.

## Background

PRD institution needs and DATABASE `institutions`. MVP is single-organization — do not add tenant_id everywhere.

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

- TASK-001
- TASK-002
- TASK-004
- TASK-006 (optional logo upload)

## Files likely affected

```text
database/migrations/*_institutions*
app/Models/Institution.php
app/Actions/Institution/*
app/Livewire/Admin/Settings/InstitutionProfile.php
tests/Feature/Institution/*
```

## Database changes

- `institutions` core fields: name, contact, timezone, locale, logo/favicon refs, etc.
- Single row expected for MVP.

## Backend requirements

- Read/update institution profile Action.
- Timezone/locale defaults available to app config/display helpers.

## Frontend requirements

- Admin institution profile form
- Display name in layout footer/header as appropriate

## Validation rules

- Name required
- Timezone valid
- Locale valid
- Logo/favicon via file rules if present

## Authorization rules

- Administrator only.

## Business rules

- One institution context for MVP; no multi-tenant switching.

## Edge cases

- Missing institution row on fresh install — seed or create-on-first-save.

## Security considerations

- No secrets in institution profile fields.

## Testing requirements

- Update profile; unauthorized denied; timezone persisted.

## Acceptance criteria

- [ ] Admin can view/update institution profile
- [ ] Timezone/locale stored
- [ ] Non-admin denied

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
