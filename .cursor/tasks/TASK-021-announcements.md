# TASK-021: Announcements

**Roadmap phase:** Phase 5 — Secondary Modules
**Estimated focus:** One focused feature

## Task ID

TASK-021

## Title

Announcements

## Objective

Implement course announcements with draft/publish and audience limited to eligible course users.

## Background

PRD MVP-011 / FR-ANN-*. Notifications for publish handled in TASK-027.

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
- TASK-011

## Files likely affected

```text
database/migrations/*_announcements*
app/Models/Announcement.php
app/Actions/Announcements/*
app/Livewire/Instructor/Announcements/*
app/Livewire/Student/Announcements/*
app/Policies/AnnouncementPolicy.php
tests/Feature/Announcements/*
```

## Database changes

- `announcements`: course_id, title, body, status, published_at, author_id.

## Backend requirements

- Create/update/publish Actions; list for eligible audience; event on publish.

## Frontend requirements

- Instructor compose UI; student announcement list/detail.

## Validation rules

- Title/body required; status enum; publish time optional/schedule-ready.

## Authorization rules

- Instructor assigned / Admin write; students read if enrolled active + published.

## Business rules

- Outside course scope cannot see; draft hidden from students.

## Edge cases

- Publish to archived course; inactive students excluded from notifications later.

## Security considerations

- Escape body HTML; authorize show by id.

## Testing requirements

- Visibility; draft hidden; unauthorized course denied.

## Acceptance criteria

- [ ] Publish/draft works
- [ ] Audience scoped to course
- [ ] Unauthorized denied

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
