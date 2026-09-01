# TASK-020: Gradebook

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-020

## Title

Gradebook

## Objective

Provide course gradebook views for instructors/admins and student own-grades view with publication rules.

## Background

PRD MVP-009 / FR-GRADE-001–004. Read/aggregate grades from assignments and quizzes.

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

- TASK-017
- TASK-019

## Files likely affected

```text
app/Livewire/Instructor/Gradebook/*
app/Livewire/Student/Grades/*
app/Policies/GradePolicy.php
app/Services/Reports/GradebookQuery.php (optional)
tests/Feature/Gradebook/*
```

## Database changes

- No new tables required unless materialized views added (avoid).

## Backend requirements

- Query gradebook by course with eager loading; enforce publication for student payloads.

## Frontend requirements

- Instructor gradebook table (students × activities)
- Student my-grades page
- Empty states; filters

## Validation rules

- Filters validated (student id, activity type).

## Authorization rules

- Instructor: assigned courses only
- Student: own grades only
- Admin: permission-gated

## Business rules

- Unpublished grades hidden from students when publication control enabled.

## Edge cases

- Archived course still viewable to authorized roles; student without grades.

## Security considerations

- Strict cross-student denial; pagination.

## Testing requirements

- Instructor scope; student isolation; unpublished hidden; unauthorized denied.

## Acceptance criteria

- [ ] Instructor gradebook works for assigned course
- [ ] Student sees only own permitted grades
- [ ] Admin permission path works

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
