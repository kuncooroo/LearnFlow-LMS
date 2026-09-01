# TASK-010: Instructor Assignment

**Roadmap phase:** Phase 3 — Core Master Data
**Estimated focus:** One focused feature

## Task ID

TASK-010

## Title

Instructor Assignment

## Objective

Allow assigning/removing one or more Instructors to a Course and enforce course-scoped instructor authorization.

## Background

FR-COURSE-005. Instructors teach only assigned courses unless Admin.

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
- TASK-004

## Files likely affected

```text
database/migrations/*_course_instructors*
app/Models/CourseInstructor.php
app/Actions/Courses/AssignInstructorAction.php
app/Actions/Courses/RemoveInstructorAction.php
app/Livewire/Admin/Courses/Instructors/*
tests/Feature/Courses/InstructorAssignment*
```

## Database changes

- `course_instructors` unique(course_id, user_id).

## Backend requirements

- Assign/remove instructor Actions; update CoursePolicy to require assignment for instructor mutations.

## Frontend requirements

- Admin UI to manage instructors on course; list assigned instructors.

## Validation rules

- User must exist and have Instructor role; no duplicates.

## Authorization rules

- Admin assigns; Instructor cannot assign self to arbitrary courses.

## Business rules

- Multiple instructors per course allowed; removal does not delete academic history.

## Edge cases

- Assign non-instructor user; remove last instructor; inactive instructor user.

## Security considerations

- Prevent privilege gain via assignment of Admin-only capabilities.

## Testing requirements

- Assign/remove; duplicate blocked; instructor scope on course update; unauthorized denied.

## Acceptance criteria

- [ ] Multiple instructors assignable
- [ ] Instructor scope enforced in policies
- [ ] Duplicates prevented

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
