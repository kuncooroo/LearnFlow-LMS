# TASK-025: Operational Reports

**Roadmap phase:** Phase 7 — Reporting
**Estimated focus:** One focused feature

## Task ID

TASK-025

## Title

Operational Reports

## Objective

Implement User, Enrollment, and Course Activity reports with filters, pagination, and CSV export.

## Background

PRD MVP-014. Reports are read-oriented and must not mutate academic data.

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

- TASK-003
- TASK-009
- TASK-011
- TASK-023

## Files likely affected

```text
app/Services/Reports/UserReportQuery.php
app/Services/Reports/EnrollmentReportQuery.php
app/Services/Reports/CourseActivityReportQuery.php
app/Actions/Reports/*
app/Livewire/Admin/Reports/*
app/Jobs/GenerateReportExport.php
tests/Feature/Reports/Operational*
```

## Database changes

- None new; indexed queries on existing tables.

## Backend requirements

- Report query objects; CSV export sync/async; authorization-scoped queries.

## Frontend requirements

- Report pages with filters/date ranges; empty states; export button.

## Validation rules

- Date ranges ordered; filter enums valid.

## Authorization rules

- Admin/manager permissions; Instructor only if scoped — default Admin for operational.

## Business rules

- Archived courses remain reportable; no writes.

## Edge cases

- Large CSV → queue; no data empty state.

## Security considerations

- No data leakage beyond permission; export files temporary + cleanup.

## Testing requirements

- Permission; filters; CSV matches filters; empty; query performance sanity.

## Acceptance criteria

- [ ] Three operational reports work
- [ ] CSV export respects filters
- [ ] Unauthorized denied

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
