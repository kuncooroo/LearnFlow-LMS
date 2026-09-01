# TASK-013: Lessons

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-013

## Title

Lessons

## Objective

Implement lessons inside modules with content types text/file/URL/embed and draft/published visibility.

## Background

PRD MVP-006 / FR-LESSON-*. Draft lessons invisible to students.

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

- TASK-012
- TASK-006
- TASK-011

## Files likely affected

```text
database/migrations/*_lessons*
app/Models/Lesson.php
app/Enums/LessonStatus.php
app/Actions/Content/*Lesson*
app/Livewire/Instructor/Content/Lessons*
app/Livewire/Student/Lessons/*
app/Policies/LessonPolicy.php
tests/Feature/Content/Lessons*
```

## Database changes

- `lessons`: module_id, title, content fields/type, status, order, completion_enabled, resource file refs, timestamps.

## Backend requirements

- Lesson CRUD; publish/draft; order; attach file resources via FileStorageService
- Student show only if course accessible + lesson published

## Frontend requirements

- Instructor lesson editor
- Student lesson reader
- Support text, file download (authorized), external URL, embed link display

## Validation rules

- Title required; type enum; URL format when type=url/embed; file required when type=file; status enum

## Authorization rules

- Mutate: assigned Instructor/Admin
- View: Student with access path (published course + enrollment rules) and published lesson

## Business rules

- Draft hidden from Student
- Order within module
- completion_enabled flag consumed by TASK-014

## Edge cases

- Publish lesson in draft course
- Broken embed URL
- Direct access to draft lesson ID

## Security considerations

- Escape rich text; sanitize approved HTML if any
- Private lesson files via authorized download

## Testing requirements

- Draft hidden; published visible to enrolled student
- Unauthorized instructor denied
- File lesson download auth

## Acceptance criteria

- [ ] Lesson types supported
- [ ] Draft/publish works
- [ ] Student visibility correct

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
