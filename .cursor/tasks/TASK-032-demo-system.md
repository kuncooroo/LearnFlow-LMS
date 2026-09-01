# TASK-032: Demo System

**Roadmap phase:** Phase 13 — Demo System
**Estimated focus:** One focused feature

## Task ID

TASK-032

## Title

Demo System

## Objective

Create safe demo seed data, demo accounts, demo banner, restrictions, and reset capability.

## Background

ROADMAP Phase 13. Demo must not affect production mode behavior.

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

- TASK-031
- TASK-030

## Files likely affected

```text
database/seeders/DemoSeeder.php
app/Support/Demo/*
config/learnflow.php (demo flags)
resources/views/components/demo-banner.blade.php
tests/Feature/Demo/*
```

## Database changes

- Seed fictional institution, users, courses, content, assessments, grades, discussions.

## Backend requirements

- Demo mode detection; block destructive actions; reset command/job.

## Frontend requirements

- Demo banner/notice; clearly communicate restrictions.

## Validation rules

- N/A

## Authorization rules

- Demo restrictions separate from production policies; never fake success.

## Business rules

- Demo credentials fictional; reset returns known state.

## Edge cases

- Production with demo flag off unaffected; blocked action messaging.

## Security considerations

- Protect demo credentials docs; no real PII.

## Testing requirements

- Login each demo role; workflow smoke; restriction tests; reset test.

## Acceptance criteria

- [ ] Demo roles demonstrate core workflows
- [ ] Restrictions clear and honest
- [ ] Reset works
- [ ] Production unaffected when demo disabled

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
