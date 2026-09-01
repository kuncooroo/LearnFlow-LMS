# TASK-008: Course Categories

**Roadmap phase:** Phase 3 — Core Master Data
**Estimated focus:** One focused feature

## Task ID

TASK-008

## Title

Course Categories

## Objective

Implement course category CRUD with activate/deactivate, list, and search.

## Background

Categories organize courses. Required before course create flows.

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

- TASK-001 through TASK-004

## Files likely affected

```text
database/migrations/*_course_categories*
app/Models/CourseCategory.php
app/Actions/Courses/*Category*
app/Livewire/Admin/Courses/Categories/*
app/Policies/CourseCategoryPolicy.php
tests/Feature/Categories/*
```

## Database changes

- `course_categories` per DATABASE.md (name, slug/status, timestamps).

## Backend requirements

- Create/update/list/search; activate/deactivate; prevent destructive delete if courses attached (prefer deactivate).

## Frontend requirements

- Admin category index/form; empty states; status badge.

## Validation rules

- Name required/unique; status enum.

## Authorization rules

- Admin manage; others read only if needed.

## Business rules

- Inactive category should not be selectable for new courses (existing courses retain category).

## Edge cases

- Delete/deactivate category in use.

## Security considerations

- Authorize mutations.

## Testing requirements

- CRUD; uniqueness; unauthorized; in-use deactivate.

## Acceptance criteria

- [ ] Admin can manage categories
- [ ] Search/list works
- [ ] In-use category handled safely

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
