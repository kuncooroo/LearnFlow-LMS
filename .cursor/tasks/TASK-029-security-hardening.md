# TASK-029: Security Hardening

**Roadmap phase:** Phase 10 — Security
**Estimated focus:** One focused feature

## Task ID

TASK-029

## Title

Security Hardening

## Objective

Harden authentication, authorization, uploads, sessions, CSRF, rate limits, escaping, and production security configuration.

## Background

Security already required in earlier tasks; this task is a focused review + remediation pass before UAT.

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

- TASK-001 through TASK-028 functionally complete enough to review.

## Files likely affected

```text
app/Http/Middleware/*
config/session.php
config/auth.php
routes/*
app/Policies/* (coverage gaps)
docs/security-checklist.md (new)
tests/Feature/Security/*
```

## Database changes

- None expected; fix only if security schema gaps found.

## Backend requirements

- Rate limit login/reset
- Review all policies for IDOR
- Private file route audit
- Production secure headers/session config documented
- Permission escalation tests

## Frontend requirements

- Ensure no sensitive data in HTML comments/JS; fix escaping issues.

## Validation rules

- Confirm upload deny list for executables.

## Authorization rules

Verify denial of:
- cross-student grades/submissions
- cross-course instructor mutations
- guest course data
- private files
- self role escalation

## Business rules

- No business rule changes unless fixing violations of PRD.

## Edge cases

- Enumerate IDs; CSRF; password reset abuse.

## Security considerations

- Full checklist execution; secrets audit; debug off in prod example.

## Testing requirements

- Security feature tests listed in ROADMAP Phase 10.

## Acceptance criteria

- [ ] Security checklist completed
- [ ] Critical IDOR/authz gaps fixed
- [ ] Rate limits on auth
- [ ] Private files verified
- [ ] No secrets in repo

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
