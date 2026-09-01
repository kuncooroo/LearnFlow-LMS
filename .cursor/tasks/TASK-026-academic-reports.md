# TASK-026: Academic Reports

**Roadmap phase:** Phase 7 — Reporting
**Estimated focus:** One focused feature

## Task ID

TASK-026

## Title

Academic Reports

## Objective

Implement Assignment Submission, Grade, and Progress reports with role scoping and CSV export.

## Background

Completes ROADMAP Phase 7 report set. Instructor sees assigned courses only; students do not get management reports.

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
- TASK-017
- TASK-014
- TASK-025 (shared export patterns)

## Files likely affected

```text
app/Services/Reports/AssignmentSubmissionReportQuery.php
app/Services/Reports/GradeReportQuery.php
app/Services/Reports/ProgressReportQuery.php
app/Livewire/Instructor/Reports/*
app/Policies/ReportPolicy.php
tests/Feature/Reports/Academic*
```

## Database changes

- None new.

## Backend requirements

- Scoped queries; unpublished grades handling; CSV export.

## Frontend requirements

- Instructor/Admin academic report UIs; filters; export.

## Validation rules

- Course filter required for instructor; dates valid.

## Authorization rules

- Student denied
- Instructor assigned courses only
- Admin broader permission

## Business rules

- Grade report must not expose unpublished beyond permission; read-only.

## Edge cases

- Course with no submissions; progress with zero lessons.

## Security considerations

- Cross-course denial; temp export protection.

## Testing requirements

- Scope; unpublished; CSV; unauthorized student.

## Acceptance criteria

- [ ] Three academic reports work
- [ ] Instructor scope enforced
- [ ] Student cannot access

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
