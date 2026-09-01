# TASK-011: Enrollments

**Roadmap phase:** Phase 3 — Core Master Data
**Estimated focus:** One focused feature

## Task ID

TASK-011

## Title

Enrollments

## Objective

Implement student enrollment into courses with status transitions and auditability.

## Background

PRD MVP enrollment / FR-ENR-*. States: active, completed, suspended, removed. Unique student-course enrollment.

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
- TASK-003
- TASK-005

## Files likely affected

```text
database/migrations/*_enrollments*
app/Models/Enrollment.php
app/Enums/EnrollmentStatus.php
app/Actions/Enrollments/*
app/Policies/EnrollmentPolicy.php
app/Livewire/Admin/Enrollments/*
tests/Feature/Enrollments/*
```

## Database changes

- `enrollments` with user_id, course_id, status, status timestamps, unique(user_id, course_id).

## Backend requirements

- Enroll student (active)
- Transition: complete / suspend / remove / reactivate per BUSINESS_FLOW
- List/filter by course/status
- Audit all changes
- Gates for student course access used by later modules

## Frontend requirements

- Admin enrollment management per course
- Bulk enroll optional if simple; otherwise single + CSV later
- Status change confirmations

## Validation rules

- Student user exists with Student role
- Course exists
- Valid status transitions only
- Duplicate enrollment rejected

## Authorization rules

- Admin manage enrollments
- Instructor may view enrollments for assigned courses if permitted
- Student cannot enroll self unless product says otherwise (MVP: Admin enrolls)

## Business rules

- Suspended/removed cannot access protected course activities
- Unique enrollment per student/course
- Changes audited

## Edge cases

- Re-enroll after removed (business rule: reactivate vs new — follow BUSINESS_FLOW)
- Enroll into archived/draft course (define: usually allow admin but student still can't see draft content)
- Inactive student user

## Security considerations

- No student self-elevation into courses.

## Testing requirements

- Enroll; duplicate; suspend; remove; reactivate
- Access denial when suspended
- Audit
- Unauthorized

## Acceptance criteria

- [ ] Enrollment states work per BUSINESS_FLOW
- [ ] Duplicates prevented
- [ ] Access rules ready for content modules
- [ ] Audited

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
