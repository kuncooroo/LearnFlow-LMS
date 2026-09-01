# TASK-002: Authentication

**Roadmap phase:** Phase 1 — Authentication
**Estimated focus:** One focused feature

## Task ID

TASK-002

## Title

Authentication

## Objective

Implement secure login, logout, session management, password reset, and inactive-user enforcement.

## Background

PRD MVP-001 / FR-AUTH-* and ROADMAP Phase 1. Authentication is Laravel-native; MFA/SSO/OAuth are out of MVP.

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
- Minimal `users` table fields required for auth (may ship with this task if not yet present).

## Files likely affected

```text
database/migrations/*_create_users_table.php
database/migrations/*_password_reset_tokens*
app/Models/User.php
app/Http/Controllers/Auth/*
app/Http/Requests/Auth/*
app/Actions/Auth/*
resources/views/auth/*
routes/auth.php
routes/web.php
tests/Feature/Auth/*
```

## Database changes

- `users` with auth fields + `status` (`active`/`inactive`) if not already created.
- `password_reset_tokens` (or framework equivalent).
- `sessions` if database session driver is chosen.

## Backend requirements

- Login with email/identifier + password.
- Logout invalidates session.
- Password reset request + tokenized reset form.
- Reject inactive users before establishing authenticated session.
- Password hashed with framework hasher.
- Role-aware dashboard redirect placeholder (roles may still be stubbed).
- Optional security/auth failure logging without leaking identifiers.

## Frontend requirements

- Login page
- Forgot password page
- Reset password page
- Validation/error feedback without revealing whether account exists
- Loading/disabled submit to prevent double post

## Validation rules

- Email/identifier required
- Password required on login
- Reset email format valid
- New password confirmed + min length per policy
- Token required and valid on reset

## Authorization rules

- Guests only for login/reset routes
- Authenticated users redirected away from login
- Protected routes require auth middleware (smoke route ok)

## Business rules

- Only `active` users may authenticate
- Used reset tokens cannot be reused
- Reset tokens expire per config
- Logout ends session

## Edge cases

- Unknown identifier → generic failure
- Inactive user → generic or explicit inactive denial without enumeration if PRD requires generic
- Expired/invalid/reused reset token
- Concurrent session logout

## Security considerations

- No plaintext passwords in logs
- No reset tokens in logs
- CSRF on all forms
- Rate-limit login/reset where practical
- Generic auth failure messaging

## Testing requirements

- Active login success
- Invalid password
- Unknown identifier
- Inactive account blocked
- Logout
- Reset request / valid reset / expired / reused token
- Guest blocked from protected route

## Acceptance criteria

- [ ] Active user can login
- [ ] Inactive user cannot login
- [ ] Invalid credentials rejected safely
- [ ] Logout works
- [ ] Password reset flow works with expiry + single use
- [ ] No stack traces in production-like config

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
