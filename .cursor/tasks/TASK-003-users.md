# TASK-003: Users

**Roadmap phase:** Phase 2 — Users / Roles / Permissions
**Estimated focus:** One focused feature

## Task ID

TASK-003

## Title

Users

## Objective

Deliver Administrator user management: create/update, search, pagination, activate/deactivate, and CSV import foundation without destructive academic deletes.

## Background

PRD MVP-002 / FR-USER-*. Users are the identity foundation for enrollment and grading history. Soft lifecycle via status, not hard delete.

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

- TASK-001
- TASK-002
- TASK-004 may proceed in parallel for role assignment wiring, but user-role attach needs roles seeded.

## Files likely affected

```text
app/Models/User.php
app/Actions/Users/*
app/Http/Controllers/Admin/UserController.php
app/Http/Requests/Users/*
app/Livewire/Admin/Users/*
app/Policies/UserPolicy.php
resources/views/admin/users/*
resources/views/livewire/admin/users/*
database/factories/UserFactory.php
tests/Feature/Admin/Users/*
tests/Livewire/Admin/Users/*
```

## Database changes

- Ensure `users` columns per DATABASE.md (name, email, password, status, timestamps, etc.).
- No hard-delete of users with academic history.

## Backend requirements

- Admin CRUD for user profile fields (no destroy of academic identity).
- Activate / deactivate Actions with audit hooks (audit implementation may depend on TASK-005).
- Search by name/email + pagination.
- Optional CSV import Action/Job: validate header/rows; report success/skipped/failed.
- Assign role(s) when TASK-004 available.

## Frontend requirements

- User index (search, filter status, pagination)
- Create / edit forms
- Detail view
- Deactivate/reactivate confirmation
- CSV import UI with result summary
- Empty/loading/error states

## Validation rules

- Name required
- Email/login unique
- Password rules on create / optional on update
- Status enum
- CSV: file type, headers, per-row validation, duplicate detection

## Authorization rules

- Only users with user-manage permission (Administrator) can CRUD
- Users cannot escalate own privileges via form tampering
- Instructors/Students denied admin user routes

## Business rules

- Deactivate does not delete submissions/grades/enrollments/audit
- Duplicate email rejected
- Inactive users cannot login (already TASK-002)

## Edge cases

- Deactivate self (block or warn per product rule — prefer block last admin)
- Import partial failures reported, not silently dropped
- Editing user that is inactive

## Security considerations

- Never return password hashes to UI
- Authorize every mutation
- CSV upload size/type limits

## Testing requirements

- Create/update/search/paginate
- Duplicate email
- Deactivate/reactivate preserves related data
- Unauthorized access denied
- CSV valid/invalid rows
- Direct URL authorization

## Acceptance criteria

- [ ] Admin can create and update users
- [ ] Search/pagination works
- [ ] Deactivate preserves history
- [ ] Unauthorized roles denied
- [ ] CSV import reports outcomes

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
