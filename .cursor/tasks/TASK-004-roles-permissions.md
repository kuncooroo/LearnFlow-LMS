# TASK-004: Roles & Permissions

**Roadmap phase:** Phase 2 — Users / Roles / Permissions
**Estimated focus:** One focused feature

## Task ID

TASK-004

## Title

Roles & Permissions

## Objective

Implement roles, permissions catalog, role-permission mapping, user-role assignment, and Policy/Gate conventions for MVP roles.

## Background

PRD MVP-003. MVP primary roles: Administrator, Instructor, Student. Optional Manager/Viewer only if needed without complexity. Prefer capability checks over scattered role string compares.

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
- TASK-003 (for user-role UI assignment)

## Files likely affected

```text
database/migrations/*_roles*
database/migrations/*_permissions*
database/migrations/*_role_user*
database/migrations/*_permission_role*
app/Models/Role.php
app/Models/Permission.php
app/Actions/Access/*
app/Policies/*
app/Providers/AuthServiceProvider.php
database/seeders/RoleSeeder.php
database/seeders/PermissionSeeder.php
tests/Feature/Access/*
```

## Database changes

- `roles`, `permissions`, `role_user`, `permission_role` per DATABASE.md.
- Seed Administrator, Instructor, Student (+ optional Manager/Viewer).

## Backend requirements

- Permission catalog for MVP capabilities.
- Assign/revoke roles on users (transaction + audit).
- Map permissions to roles.
- Register Policies/Gates conventions.
- Helpers for capability checks used by Policies — not ad-hoc `role ===` everywhere.

## Frontend requirements

- Admin role assignment on user form/detail
- Optional role/permission management screens (keep simple)
- Navigation visibility may hide links but never replaces server auth

## Validation rules

- Role name unique
- Permission name/key unique
- Cannot assign unknown role/permission IDs

## Authorization rules

- Only Administrator (or permission) manages roles/permissions
- Prevent removing last Administrator role from sole admin if configured

## Business rules

- Role changes auditable
- Permission changes take effect on subsequent authorization checks
- Students/Instructors cannot manage access control

## Edge cases

- User with multiple roles (if allowed) — define MVP: typically one primary role
- Orphan permissions
- Seeder idempotency

## Security considerations

- No client-supplied role trust
- Authorize all access-control mutations
- Audit actor + before/after

## Testing requirements

- Seed roles exist
- Assign role
- Permission grant/deny via Policy
- Unauthorized role management denied
- Audit event for role change

## Acceptance criteria

- [ ] Core roles seeded
- [ ] Permission catalog exists
- [ ] User-role assignment works
- [ ] Policies/Gates usable by later modules
- [ ] Unauthorized access denied
- [ ] Changes auditable

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
