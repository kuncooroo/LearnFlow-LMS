# TASK-014: Lesson Completion & Progress

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-014

## Title

Lesson Completion & Progress

## Objective

Track completion-enabled lesson completions and calculate course progress 0–100%.

## Background

PRD MVP-010 / FR-PROG-*. Formula: completed completion-enabled lessons / total completion-enabled lessons × 100.

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

- TASK-013
- TASK-011

## Files likely affected

```text
database/migrations/*_lesson_completions*
app/Models/LessonCompletion.php
app/Services/Progress/CourseProgressCalculator.php
app/Actions/Progress/RecordLessonCompletionAction.php
app/Livewire/Student/Progress/*
tests/Unit/Services/Progress/*
tests/Feature/Progress/*
```

## Database changes

- `lesson_completions` unique(user_id, lesson_id) + timestamps.

## Backend requirements

- Record completion Action (idempotent)
- Progress calculator service
- Expose progress on student course views

## Frontend requirements

- Mark complete control on lesson
- Progress percentage + completed/total display
- Course progress summary

## Validation rules

- Lesson must be completion-enabled and published; student enrolled active.

## Authorization rules

- Student completes only own enrollment; cannot complete for others.

## Business rules

- Progress clamped 0–100
- Unique completion per student/lesson
- Recalculate when completion changes or completion-enabled lessons change

## Edge cases

- Zero completion-enabled lessons → define safe progress (0% or N/A)
- Uncomplete if product allows (MVP: usually complete only)
- Suspended enrollment cannot complete

## Security considerations

- No forging completions for other users.

## Testing requirements

- Completion creates row
- Progress math unit tests
- Unauthorized completion denied
- Bounds 0–100

## Acceptance criteria

- [ ] Completion recorded uniquely
- [ ] Progress formula correct
- [ ] Student sees own progress only

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
