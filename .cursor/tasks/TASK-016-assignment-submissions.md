# TASK-016: Assignment Submissions

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-016

## Title

Assignment Submissions

## Objective

Allow enrolled students to submit text/file submissions once per assignment with server timestamps and late detection.

## Background

FR-ASG-002–005. MVP: one final submission per student per assignment. submitted_at is server authoritative.

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

- TASK-015
- TASK-011
- TASK-006

## Files likely affected

```text
database/migrations/*_submissions*
database/migrations/*_submission_files*
app/Models/Submission.php
app/Actions/Assignments/SubmitAssignmentAction.php
app/Policies/SubmissionPolicy.php
app/Livewire/Student/Assignments/Submit*
tests/Feature/Assignments/Submissions*
```

## Database changes

- `submissions` unique(assignment_id, user_id) for MVP
- `submission_files` relations
- submitted_at, is_late flags

## Backend requirements

- SubmitAssignmentAction in transaction: validate eligibility, store text/files, set submitted_at now(), compute late
- Prevent duplicate submission
- Event `AssignmentSubmitted` for notifications later

## Frontend requirements

- Student submit form with text/file per mode
- Confirmation; late warning if applicable
- View own submission receipt

## Validation rules

- Content required per mode
- File rules via FileStorageService
- Assignment must be published/open

## Authorization rules

- Active enrollment required
- Student submits only as self
- Cannot submit to another student's identity

## Business rules

- One submission MVP
- Late if after due_at and allow_late
- If late not allowed after due → reject
- Success only after persistence

## Edge cases

- Double-click double submit
- Closed assignment
- Suspended enrollment
- Empty text+file

## Security considerations

- Server time only
- Private storage for submission files
- Authorize file download to owner/instructor

## Testing requirements

- Happy path
- Late allowed/denied
- Duplicate blocked
- Unauthorized/cross-user denied
- Transaction rollback on file failure if designed

## Acceptance criteria

- [ ] Enrolled student can submit
- [ ] Timestamp + late correct
- [ ] Duplicate prevented
- [ ] Files private + authorized

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
