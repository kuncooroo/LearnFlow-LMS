# LearnFlow LMS — Cursor Development Tasks

Task documents for implementing the MVP as a Laravel modular monolith.

## How to use

1. Implement tasks in ID order unless dependencies allow parallel work.
2. Open one task file per Cursor session/agent when possible.
3. Do not expand scope beyond the task's objective.
4. Follow `CURSOR.md` and `docs/PROJECT_STRUCTURE.md`.
5. Mark Definition of Done checkboxes mentally before moving on.

## Authority order

```text
PRD → SRS → SYSTEM_DESIGN → BUSINESS_FLOW → DATABASE → UI_UX → ROADMAP → Implementation
```

## Task index

| ID | File | Title | Roadmap phase |
|---|---|---|---|
| TASK-001 | [TASK-001-project-foundation.md](./TASK-001-project-foundation.md) | Project Foundation | Phase 0 — Project Foundation |
| TASK-002 | [TASK-002-authentication.md](./TASK-002-authentication.md) | Authentication | Phase 1 — Authentication |
| TASK-003 | [TASK-003-users.md](./TASK-003-users.md) | Users | Phase 2 — Users / Roles / Permissions |
| TASK-004 | [TASK-004-roles-permissions.md](./TASK-004-roles-permissions.md) | Roles & Permissions | Phase 2 — Users / Roles / Permissions |
| TASK-005 | [TASK-005-audit-trail.md](./TASK-005-audit-trail.md) | Audit Trail Foundation | Phase 2 / Cross-cutting (PRD MVP-015) |
| TASK-006 | [TASK-006-file-storage-foundation.md](./TASK-006-file-storage-foundation.md) | File Storage Foundation | Phase 3 — Core Master Data (Files) |
| TASK-007 | [TASK-007-institution-profile.md](./TASK-007-institution-profile.md) | Institution Profile | Phase 3 — Core Master Data |
| TASK-008 | [TASK-008-course-categories.md](./TASK-008-course-categories.md) | Course Categories | Phase 3 — Core Master Data |
| TASK-009 | [TASK-009-courses.md](./TASK-009-courses.md) | Courses | Phase 3 — Core Master Data |
| TASK-010 | [TASK-010-instructor-assignment.md](./TASK-010-instructor-assignment.md) | Instructor Assignment | Phase 3 — Core Master Data |
| TASK-011 | [TASK-011-enrollments.md](./TASK-011-enrollments.md) | Enrollments | Phase 3 — Core Master Data |
| TASK-012 | [TASK-012-course-modules.md](./TASK-012-course-modules.md) | Course Modules | Phase 4 — Primary Business Workflow |
| TASK-013 | [TASK-013-lessons.md](./TASK-013-lessons.md) | Lessons | Phase 4 — Primary Business Workflow |
| TASK-014 | [TASK-014-lesson-completion-and-progress.md](./TASK-014-lesson-completion-and-progress.md) | Lesson Completion & Progress | Phase 4 — Primary Business Workflow |
| TASK-015 | [TASK-015-assignments.md](./TASK-015-assignments.md) | Assignments | Phase 4 — Primary Business Workflow |
| TASK-016 | [TASK-016-assignment-submissions.md](./TASK-016-assignment-submissions.md) | Assignment Submissions | Phase 4 — Primary Business Workflow |
| TASK-017 | [TASK-017-assignment-grading.md](./TASK-017-assignment-grading.md) | Assignment Grading | Phase 4 — Primary Business Workflow |
| TASK-018 | [TASK-018-quizzes.md](./TASK-018-quizzes.md) | Quizzes | Phase 4 — Primary Business Workflow |
| TASK-019 | [TASK-019-quiz-attempts-and-scoring.md](./TASK-019-quiz-attempts-and-scoring.md) | Quiz Attempts & Scoring | Phase 4 — Primary Business Workflow |
| TASK-020 | [TASK-020-gradebook.md](./TASK-020-gradebook.md) | Gradebook | Phase 4 — Primary Business Workflow |
| TASK-021 | [TASK-021-announcements.md](./TASK-021-announcements.md) | Announcements | Phase 5 — Secondary Modules |
| TASK-022 | [TASK-022-discussions.md](./TASK-022-discussions.md) | Discussions | Phase 5 — Secondary Modules |
| TASK-023 | [TASK-023-dashboards.md](./TASK-023-dashboards.md) | Dashboards & Operational Views | Phase 5 — Secondary Modules |
| TASK-024 | [TASK-024-financial-scope-deferred.md](./TASK-024-financial-scope-deferred.md) | Financial Scope Checkpoint (Deferred) | Phase 6 — Financial Modules (Not in MVP) |
| TASK-025 | [TASK-025-operational-reports.md](./TASK-025-operational-reports.md) | Operational Reports | Phase 7 — Reporting |
| TASK-026 | [TASK-026-academic-reports.md](./TASK-026-academic-reports.md) | Academic Reports | Phase 7 — Reporting |
| TASK-027 | [TASK-027-notifications.md](./TASK-027-notifications.md) | Notifications | Phase 8 — Notifications |
| TASK-028 | [TASK-028-settings-and-branding.md](./TASK-028-settings-and-branding.md) | Settings & Branding | Phase 9 — Settings |
| TASK-029 | [TASK-029-security-hardening.md](./TASK-029-security-hardening.md) | Security Hardening | Phase 10 — Security |
| TASK-030 | [TASK-030-full-testing-uat.md](./TASK-030-full-testing-uat.md) | Full Testing & UAT | Phase 11 — Testing |
| TASK-031 | [TASK-031-installer.md](./TASK-031-installer.md) | Installer | Phase 12 — Installer |
| TASK-032 | [TASK-032-demo-system.md](./TASK-032-demo-system.md) | Demo System | Phase 13 — Demo System |
| TASK-033 | [TASK-033-documentation.md](./TASK-033-documentation.md) | Documentation | Phase 14 — Documentation |
| TASK-034 | [TASK-034-release-preparation.md](./TASK-034-release-preparation.md) | Release Preparation | Phase 15 — Release Preparation |

## Suggested milestones

| Milestone | Tasks | Outcome |
|---|---|---|
| A — Technical foundation | TASK-001 → TASK-005 | Auth + users + RBAC + audit |
| B — LMS foundation | TASK-006 → TASK-011 | Files, institution, courses, enrollment |
| C — Functional LMS alpha | TASK-012 → TASK-020 | Content, assessments, grades, progress |
| D — Product beta | TASK-021 → TASK-028 | Comms, dashboards, reports, notifications, settings |
| E — Release candidate | TASK-029 → TASK-033 | Security, UAT, installer, demo, docs |
| F — v1.0 | TASK-034 | Release preparation |

## Explicitly deferred

- Financial / billing / e-commerce (TASK-024 checkpoint)
- Multi-tenancy / SaaS billing
- SSO / MFA / OAuth
- Public REST API
- SCORM / xAPI / LTI / AI

_Generated 34 tasks._
