# TASK-017: Assignment Grading

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-017

## Title

Assignment Grading

## Objective

Enable instructors to score submissions with feedback, create/update grades, publish grades, and audit changes.

## Background

FR-ASG-006–008, FR-GRADE-*. Grade is authoritative academic data.

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

- TASK-016
- TASK-005

## Files likely affected

```text
database/migrations/*_grades* (if not created)
app/Models/Grade.php
app/Actions/Assignments/GradeSubmissionAction.php
app/Actions/Grades/PublishGradeAction.php
app/Livewire/Instructor/Assignments/Grade*
tests/Feature/Assignments/Grading*
```

## Database changes

- `grades` linking to assignment submission source per DATABASE.md
- score decimal, feedback, publication status, graded_at

## Backend requirements

- GradeSubmissionAction transactional + audit
- PublishGradeAction controls student visibility
- Prevent score > max_score or < 0

## Frontend requirements

- Instructor grading UI / pending queue item
- Feedback field
- Publish control
- Student sees grade only when published (if publication mode on)

## Validation rules

- score required numeric; 0 <= score <= assignment.max_score
- feedback optional string limits

## Authorization rules

- Instructor assigned to course
- Student views own published grade only
- Admin with permission may view all

## Business rules

- Grade changes audited
- Unpublished hidden from student when publication control enabled
- Notification event ready for TASK-027

## Edge cases

- Re-grade after publish
- Grading without submission
- Concurrent grade updates

## Security considerations

- No cross-student grade leakage.

## Testing requirements

- Score limits
- Audit on change
- Student cannot see unpublished
- Cross-student denied
- Unauthorized instructor denied

## Acceptance criteria

- [ ] Instructor can grade + feedback
- [ ] Score bounds enforced
- [ ] Publish visibility correct
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
