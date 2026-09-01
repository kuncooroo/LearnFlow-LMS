# TASK-009: Courses

**Roadmap phase:** Phase 3 — Core Master Data
**Estimated focus:** One focused feature

## Task ID

TASK-009

## Title

Courses

## Objective

Implement course create/detail/list with draft/publish/archive lifecycle and visibility rules.

## Background

PRD MVP-005 / FR-COURSE-*. Course is the central LMS aggregate. Status transitions follow BUSINESS_FLOW.

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

- TASK-008
- TASK-004
- TASK-005 (audit on create/update/archive)

## Files likely affected

```text
database/migrations/*_courses*
app/Models/Course.php
app/Enums/CourseStatus.php
app/Actions/Courses/CreateCourseAction.php
app/Actions/Courses/PublishCourseAction.php
app/Actions/Courses/ArchiveCourseAction.php
app/Policies/CoursePolicy.php
app/Livewire/Admin/Courses/*
app/Livewire/Instructor/Courses/*
app/Livewire/Student/Courses/*
tests/Feature/Courses/*
```

## Database changes

- `courses` with title, code, category_id, status, description, visibility, timestamps, published_at/archived_at as designed.

## Backend requirements

- Create course in `draft`
- Publish / archive / allowed transitions via Actions
- List/search/filter/paginate
- Student catalog visibility rules
- Audit course create/update/archive

## Frontend requirements

- Admin/Instructor course management UI
- Student course list/detail for visible courses
- Status badges; confirmations for publish/archive

## Validation rules

- Title required
- Code required; uniqueness if institution setting enabled (setting may land in TASK-028 — support flag/default)
- Category exists
- Status/visibility enums
- Description limits

## Authorization rules

- Admin manage all courses
- Instructor manage assigned courses only (assignment may be TASK-010 — until then Admin-only create is ok, or create+self-assign)
- Student: no draft; enrolled-only visibility enforced with enrollment when available

## Business rules

- draft → published → archived per BUSINESS_FLOW
- Draft invisible to Student
- Archive preserves history
- Code uniqueness per settings

## Edge cases

- Publish without category
- Archive published course
- Student hits draft URL directly → 403/404

## Security considerations

- Policy on show/update; no IDOR across courses.

## Testing requirements

- Lifecycle transitions
- Draft hidden from student
- Unauthorized update denied
- Audit events
- List N+1 review

## Acceptance criteria

- [ ] Admin can create/publish/archive course
- [ ] Draft invisible to Student
- [ ] Policies enforce access
- [ ] Audit recorded

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
