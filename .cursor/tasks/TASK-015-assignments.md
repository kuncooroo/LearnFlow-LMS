# TASK-015: Assignments

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-015

## Title

Assignments

## Objective

Implement assignment create/edit with draft/publish/close, due dates, max score, and late policy settings.

## Background

PRD MVP-007 / FR-ASG-001. Assignments are instructor-authored assessment activities.

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
- TASK-006

## Files likely affected

```text
database/migrations/*_assignments*
database/migrations/*_assignment_files*
app/Models/Assignment.php
app/Enums/AssignmentStatus.php
app/Actions/Assignments/*
app/Policies/AssignmentPolicy.php
app/Livewire/Instructor/Assignments/*
tests/Feature/Assignments/*
```

## Database changes

- `assignments` + optional `assignment_files`
- Fields: title, instructions, due_at, max_score, status, allow_late, submission_mode, etc.

## Backend requirements

- CRUD + publish/close Actions
- Attach optional files
- Availability checks helper for submissions task

## Frontend requirements

- Instructor assignment list/editor
- Student sees published assignments in course (read-only list in this task or with TASK-016)

## Validation rules

- Title required; max_score > 0 decimal; due_at ordered if present; status enum; mode enum

## Authorization rules

- Assigned Instructor/Admin mutate; students read published only when enrolled.

## Business rules

- draft → published → closed transitions
- Closed not accepting new submissions (enforced in TASK-016)

## Edge cases

- Publish without max_score; due in the past; close then reopen if authorized.

## Security considerations

- Course-scoped policies.

## Testing requirements

- Lifecycle; student cannot see draft; unauthorized instructor denied.

## Acceptance criteria

- [ ] Assignment lifecycle works
- [ ] Draft hidden from students
- [ ] Max score & due date stored

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
