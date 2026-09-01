# TASK-027: Notifications

**Roadmap phase:** Phase 8 — Notifications
**Estimated focus:** One focused feature

## Task ID

TASK-027

## Title

Notifications

## Objective

Deliver in-app notifications (and optional queued email) for key LMS events without coupling to academic transaction success.

## Background

ROADMAP Phase 8. Events: assignment published, grade published, announcement published, submission received, deadline reminders foundation.

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

- TASK-002
- TASK-015–017
- TASK-021
- queue foundation from TASK-001

## Files likely affected

```text
app/Notifications/*
app/Listeners/*
app/Events/*
app/Livewire/Shared/Notifications/*
database migrations for notifications table if not present
tests/Feature/Notifications/*
```

## Database changes

- Laravel `notifications` table; optional preferences columns/settings later.

## Backend requirements

- Notification classes + listeners
- Recipient resolution by course/enrollment
- Queue email channel
- Mark read / mark all read

## Frontend requirements

- Bell indicator + dropdown
- View all page
- Read/unread UI

## Validation rules

- N/A for event payloads beyond type safety.

## Authorization rules

- Users read only own notifications.

## Business rules

- Failure must not rollback grades/submissions
- Inactive/ineligible users skipped
- Course scope respected

## Edge cases

- Duplicate listener retry; missing preference defaults to on for MVP core events.

## Security considerations

- No sensitive grade details over insecure channels beyond need; authorize index.

## Testing requirements

- Recipient resolution
- Read state
- Queued mail fake
- Failed mail isolation
- Unauthorized access

## Acceptance criteria

- [ ] In-app notifications for core events
- [ ] Read/unread works
- [ ] Academic txs independent of notification failure
- [ ] Optional email queued

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
