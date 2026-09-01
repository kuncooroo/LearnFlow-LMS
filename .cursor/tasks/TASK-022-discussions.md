# TASK-022: Discussions

**Roadmap phase:** Phase 5 — Secondary Modules
**Estimated focus:** One focused feature

## Task ID

TASK-022

## Title

Discussions

## Objective

Implement optional per-course discussions with threads, replies, and open/closed moderation.

## Background

PRD MVP-012 / FR-DISC-*. Keep basic — no nested enterprise forum features.

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
- TASK-011

## Files likely affected

```text
database/migrations/*_discussion_threads*
database/migrations/*_discussion_replies*
app/Models/DiscussionThread.php
app/Models/DiscussionReply.php
app/Actions/Discussions/*
app/Livewire/Student/Discussions/*
app/Livewire/Instructor/Discussions/*
tests/Feature/Discussions/*
```

## Database changes

- Threads + replies tables; course discussion_enabled flag on courses if designed.

## Backend requirements

- Create thread/reply; close/open thread; disable discussions per course.

## Frontend requirements

- Course discussion index; thread view; reply form; closed state UI.

## Validation rules

- Body required; course discussions enabled.

## Authorization rules

- Active enrollment for student participate; Instructor/Admin moderate.

## Business rules

- Closed thread rejects new replies; disabled course discussions block create.

## Edge cases

- Reply to closed; student from other course; XSS in body.

## Security considerations

- Escape content; authorize thread course scope.

## Testing requirements

- Create/reply; closed rejects; unauthorized denied; disable switch.

## Acceptance criteria

- [ ] Threads/replies work when enabled
- [ ] Closed threads block replies
- [ ] Scope enforced

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
