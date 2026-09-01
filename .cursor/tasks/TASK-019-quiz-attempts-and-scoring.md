# TASK-019: Quiz Attempts & Scoring

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-019

## Title

Quiz Attempts & Scoring

## Objective

Allow students to start/finalize quiz attempts with deterministic auto-scoring, attempt limits, and gradebook integration.

## Background

FR-QUIZ-004–007. Never trust browser score. Prevent duplicate finalization.

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

- TASK-018
- TASK-011
- grades schema from TASK-017

## Files likely affected

```text
database/migrations/*_quiz_attempts*
database/migrations/*_quiz_answers*
app/Models/QuizAttempt.php
app/Models/QuizAnswer.php
app/Actions/Quizzes/StartQuizAttemptAction.php
app/Actions/Quizzes/FinalizeQuizAttemptAction.php
app/Livewire/Student/Quizzes/TakeQuiz.php
tests/Feature/Quizzes/Attempts*
tests/Unit/Quizzes/Scoring*
```

## Database changes

- `quiz_attempts` unique(quiz_id, user_id, attempt_number)
- `quiz_answers`
- final score fields; started_at/submitted_at

## Backend requirements

- Start attempt if eligible (enrollment, window, limit, published)
- Save answers; finalize in transaction: score deterministically; write grade; lock attempt
- Reject second finalize

## Frontend requirements

- Take quiz UI
- Timer display if duration set (server enforces)
- Submit confirmation; results per visibility rules

## Validation rules

- Answers reference valid options; attempt in progress.

## Authorization rules

- Active enrollment; own attempts only.

## Business rules

- Attempt count <= limit
- Outside window rejected
- Deterministic scoring from keys/weights
- Duration enforced server-side on finalize

## Edge cases

- Double submit
- Time expiry mid-attempt
- Concurrent finalize
- Zero questions

## Security considerations

- Do not accept client total score
- Hide answer key until policy allows
- IDOR protection on attempt ids

## Testing requirements

- Scoring unit tests
- Limit exceeded
- Window rejected
- Duplicate finalize
- Cross-user attempt access denied

## Acceptance criteria

- [ ] Start/finalize works
- [ ] Auto-score correct
- [ ] Limits/windows enforced
- [ ] Grade recorded

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
