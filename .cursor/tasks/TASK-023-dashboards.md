# TASK-023: Dashboards & Operational Views

**Roadmap phase:** Phase 5 — Secondary Modules
**Estimated focus:** One focused feature

## Task ID

TASK-023

## Title

Dashboards & Operational Views

## Objective

Build role-aware dashboards and operational views: student upcoming work, instructor pending grading, course overviews.

## Background

PRD MVP-013 and ROADMAP Phase 5 operational views. Presentation aggregation only — no new academic writes.

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

- TASK-014
- TASK-016
- TASK-017
- TASK-020
- TASK-021

## Files likely affected

```text
app/Livewire/Shared/Dashboard/*
app/Livewire/Instructor/WorkQueue/*
app/Livewire/Student/Overview/*
resources/views/livewire/**/dashboard*
tests/Feature/Dashboard/*
```

## Database changes

- None required (read models).

## Backend requirements

- Query services/actions for dashboard cards scoped by role; prevent N+1.

## Frontend requirements

- Admin dashboard foundation
- Instructor pending grading queue
- Student upcoming assignments/quizzes + progress snapshot
- Empty states

## Validation rules

- N/A beyond filter inputs.

## Authorization rules

- Each widget scoped; no cross-course instructor leakage; student own data only.

## Business rules

- Read-only; respect draft/publish and enrollment.

## Edge cases

- User with no courses; large queues paginated.

## Security considerations

- Same as underlying policies.

## Testing requirements

- Role widgets; unauthorized data absent; empty states.

## Acceptance criteria

- [ ] Each primary role sees useful dashboard
- [ ] Instructor queue scoped
- [ ] Student overview scoped

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
