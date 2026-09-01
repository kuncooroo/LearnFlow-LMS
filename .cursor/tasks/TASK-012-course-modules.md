# TASK-012: Course Modules

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-012

## Title

Course Modules

## Objective

Implement ordered modules within a course as containers for lessons.

## Background

FR-LESSON-001/002. Modules structure course content.

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

- TASK-009
- TASK-010

## Files likely affected

```text
database/migrations/*_modules*
app/Models/Module.php
app/Actions/Content/*
app/Livewire/Instructor/Content/Modules*
app/Policies/ModulePolicy.php
tests/Feature/Content/Modules*
```

## Database changes

- `modules`: course_id, title, position/order, timestamps.

## Backend requirements

- CRUD module; reorder; course-scoped queries; eager-load safe lists.

## Frontend requirements

- Instructor module list/reorder UI (Alpine/Livewire); Admin may also manage.

## Validation rules

- Title required; course_id valid; order integer >= 0.

## Authorization rules

- Instructor assigned to course or Admin.

## Business rules

- Modules belong to one course; ordering stable.

## Edge cases

- Reorder conflicts; delete module with lessons (block or cascade per DATABASE rules — prefer restrict + explicit lesson handling).

## Security considerations

- Course scope IDOR checks.

## Testing requirements

- Create/reorder; unauthorized instructor B denied; student cannot mutate.

## Acceptance criteria

- [ ] Modules CRUD + order
- [ ] Scoped authorization
- [ ] Student cannot manage modules

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
