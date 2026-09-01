# TASK-028: Settings & Branding

**Roadmap phase:** Phase 9 — Settings
**Estimated focus:** One focused feature

## Task ID

TASK-028

## Title

Settings & Branding

## Objective

Provide Admin institution settings groups: branding, localization, learning defaults, notification toggles, file upload limits.

## Background

PRD MVP-004 / ROADMAP Phase 9. Configurable without code changes. Secrets stay in environment, not settings table.

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

- TASK-007
- TASK-006
- TASK-027

## Files likely affected

```text
database/migrations/*_institution_settings*
app/Models/InstitutionSetting.php
app/Actions/Institution/*Settings*
app/Livewire/Admin/Settings/*
tests/Feature/Settings/*
```

## Database changes

- `institution_settings` key/value (cast/json) per DATABASE.md.

## Backend requirements

- Settings read/update Actions with cache invalidation if cached
- Apply timezone/locale/file limits/course code uniqueness/default attempt limit

## Frontend requirements

- Settings sections UI
- Branding logo/favicon upload
- Flash success; validation errors

## Validation rules

- Known keys only
- File limits numeric ranges
- Logo mime/size
- Booleans for toggles

## Authorization rules

- Administrator only.

## Business rules

- Do not add speculative settings; only approved product settings.

## Edge cases

- Invalid timezone; cache stale after update.

## Security considerations

- No SMTP secrets in settings; authorize; validate uploads.

## Testing requirements

- Authz; validation; branding appears; cache invalidation; bad input.

## Acceptance criteria

- [ ] Admin updates settings groups
- [ ] Branding visible in layout
- [ ] Non-admin denied
- [ ] Secrets not stored in settings

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
