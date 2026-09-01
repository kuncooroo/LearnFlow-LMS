# TASK-005: Audit Trail Foundation

**Roadmap phase:** Phase 2 / Cross-cutting (PRD MVP-015)
**Estimated focus:** One focused feature

## Task ID

TASK-005

## Title

Audit Trail Foundation

## Objective

Implement append-only activity/audit logging service and storage for mandatory audited events.

## Background

PRD MVP-015 and CURSOR audit rules. Operational logs ≠ audit logs. Audit records must not be normally editable.

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
- TASK-003 / TASK-004 for first consumers

## Files likely affected

```text
database/migrations/*_activity_logs*
app/Models/ActivityLog.php
app/Services/Audit/ActivityLogger.php
app/Actions/... (call sites)
app/Livewire/Admin/Audit/* (optional read UI)
tests/Feature/Audit/*
```

## Database changes

- `activity_logs` with actor, action, target type/id, summary, before/after JSON, timestamps.
- No update/delete UI for normal operators.

## Backend requirements

- `ActivityLogger` service API used by Actions.
- Record: user create/update/deactivate, role/permission changes, and stubs ready for course/enrollment/grade.
- Admin read/search of audit entries (basic).

## Frontend requirements

- Optional Admin audit log list with filters (actor, action, date)
- Detail view of before/after summary
- Empty state

## Validation rules

- Filter inputs sanitized; no writes from UI.

## Authorization rules

- Only Administrator (audit permission) can view audit logs.

## Business rules

- Append-only
- Must not store secrets/passwords/tokens in payloads
- Academic/admin critical events required by CURSOR §43

## Edge cases

- Actor deleted/deactivated still readable by id/name snapshot if stored
- Large before/after payloads truncated safely if needed

## Security considerations

- No secrets in audit payloads
- Read access tightly controlled
- Tamper resistance: no edit endpoints

## Testing requirements

- Logging on user deactivate
- Logging on role change
- Unauthorized cannot read
- Payload excludes password

## Acceptance criteria

- [ ] ActivityLogger available to Actions
- [ ] Mandatory early events recorded
- [ ] Admin can view logs
- [ ] Records not editable via app

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
