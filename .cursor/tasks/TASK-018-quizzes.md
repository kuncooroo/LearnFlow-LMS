# TASK-018: Quizzes

**Roadmap phase:** Phase 4 — Primary Business Workflow
**Estimated focus:** One focused feature

## Task ID

TASK-018

## Title

Quizzes

## Objective

Implement quiz authoring with MCQ and True/False questions, options, weights, attempt limits, and availability windows.

## Background

PRD MVP-008 / FR-QUIZ-001–003. No essay/matching/pools in MVP.

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

## Files likely affected

```text
database/migrations/*_quizzes*
database/migrations/*_questions*
database/migrations/*_answer_options*
app/Models/Quiz.php
app/Models/Question.php
app/Models/AnswerOption.php
app/Enums/QuizStatus.php
app/Actions/Quizzes/*
app/Policies/QuizPolicy.php
app/Livewire/Instructor/Quizzes/*
tests/Feature/Quizzes/Authoring*
```

## Database changes

- `quizzes`, `questions`, `answer_options` per DATABASE.md
- attempt_limit, duration_minutes nullable, available_from/until, status

## Backend requirements

- Quiz CRUD + publish/close
- Question/option CRUD with correct key + weight
- Prevent publishing empty quiz

## Frontend requirements

- Instructor quiz builder UI
- Question type switch MCQ / T-F
- Student list of published quizzes (attempt UI in TASK-019)

## Validation rules

- Title required; attempt_limit >= 1; availability_until > available_from; weights > 0; exactly one correct option for MVP question types as designed

## Authorization rules

- Assigned Instructor/Admin; students cannot author.

## Business rules

- draft/published/closed
- MVP question types only

## Edge cases

- Edit quiz after attempts exist (restrict destructive question edits); close quiz.

## Security considerations

- Do not expose correct answers to students before/during attempt inappropriately.

## Testing requirements

- Create MCQ/TF; publish; student cannot see draft; validation on windows.

## Acceptance criteria

- [ ] Quiz authoring works for MCQ + T/F
- [ ] Attempt limit & availability stored
- [ ] Draft hidden from students

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
