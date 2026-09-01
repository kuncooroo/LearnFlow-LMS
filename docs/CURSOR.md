# CURSOR.md
# LearnFlow LMS — Permanent AI Development Instructions

## Document Purpose

This file defines **permanent engineering instructions for AI coding assistants** working on LearnFlow LMS.

These rules apply to every coding task unless a newer project document explicitly replaces them.

AI assistants must treat this file as a **development guardrail**, not as optional guidance.

---

# 1. Project Identity

## Project

**LearnFlow LMS**

## Product Type

Commercial Learning Management System intended for:

- self-hosted source-code distribution;
- institutional deployment;
- future SaaS evolution;
- future white-label distribution.

## Primary Users

- Administrator;
- Instructor / Lecturer / Teacher / Trainer;
- Student / Learner;
- Program Manager;
- Management Viewer.

---

# 2. Technical Stack

Target stack:

```text
Backend:
Laravel 13.x

PHP:
PHP 8.4.x

Database:
MySQL 8.4.x

Frontend:
Blade
Livewire
Alpine.js
Tailwind CSS

Deployment:
VPS
```

## Stack Verification Rule

Before making architectural or dependency-sensitive changes:

1. inspect the actual project;
2. inspect `composer.json`;
3. inspect `composer.lock`;
4. inspect `package.json`;
5. inspect frontend lock files;
6. inspect relevant configuration;
7. verify actual installed versions.

Do not assume the requested stack is identical to the currently installed environment.

If the project has not yet been bootstrapped, follow the target stack above.

Never silently upgrade or downgrade:

- Laravel;
- PHP;
- MySQL;
- Livewire;
- Tailwind CSS;
- Alpine.js;
- major dependencies.

---

# 3. Authoritative Project Documents

Before implementing a feature, AI assistants should inspect the relevant project documents.

Primary documents:

```text
docs/PRD.md
docs/SRS.md
docs/SYSTEM_DESIGN.md
docs/BUSINESS_FLOW.md
docs/DATABASE.md
docs/UI_UX.md
CURSOR.md
```

Authority order:

```text
PRD
↓
SRS
↓
SYSTEM_DESIGN
↓
BUSINESS_FLOW
↓
DATABASE
↓
UI_UX
↓
Implementation
```

If implementation conflicts with the PRD:

> The PRD wins unless the user explicitly changes the requirement.

Do not silently reinterpret business requirements.

---

# 4. Mandatory AI Workflow Before Editing Code

Before changing any file, the AI assistant must:

1. read the task carefully;
2. identify the relevant module;
3. inspect existing files in that module;
4. inspect nearby conventions;
5. inspect routes;
6. inspect related models;
7. inspect related migrations;
8. inspect policies;
9. inspect services/actions;
10. inspect tests;
11. inspect UI components;
12. identify existing reusable components;
13. identify relevant project documentation;
14. determine the smallest safe change.

The AI must understand the current architecture before writing new code.

---

# 5. AI Change Discipline

## Mandatory Rule

Never perform broad unrelated refactoring while implementing a small feature.

Example:

Requested:

```text
Add Course Status filter
```

Allowed:

```text
Course list query
Filter UI
Tests
```

Not allowed without explicit justification:

```text
Rewrite Course module
Rename unrelated models
Change application architecture
Replace Livewire patterns
Introduce a new package
Reformat the entire project
```

Every code change must have a direct relationship to the requested task.

---

# 6. Architecture Rules

LearnFlow uses a:

> **Laravel Modular Monolith**

Do not introduce microservices unless there is strong and documented technical justification.

Logical architecture:

```text
Presentation Layer
    ↓
Application Layer
    ↓
Domain / Business Rules
    ↓
Persistence / Infrastructure
```

## Presentation Layer

Includes:

- Routes;
- Controllers;
- Livewire components;
- Blade views;
- Form Requests.

## Application Layer

Includes:

- Actions;
- Services;
- transactional use cases;
- orchestration logic.

## Domain Layer

Includes:

- Eloquent models;
- domain rules;
- policies;
- domain services where justified.

## Infrastructure Layer

Includes:

- MySQL;
- queues;
- filesystem;
- notifications;
- mail;
- logging;
- cache.

---

# 7. Module Boundaries

Maintain clear boundaries.

## Core Platform

```text
Authentication
Users
Roles
Permissions
Institution Settings
Branding
Files
Notifications
Activity Logs
Dashboard Foundation
```

## LMS Domain

```text
Course Categories
Courses
Instructor Assignments
Enrollments
Modules
Lessons
Assignments
Submissions
Quizzes
Quiz Attempts
Grades
Learning Progress
Announcements
Discussions
Reports
```

Do not move domain behavior between modules without architectural justification.

---

# 8. Laravel Convention Rules

Mandatory:

- follow Laravel directory conventions;
- follow framework naming conventions;
- prefer Eloquent relationships;
- prefer Laravel validation;
- prefer Policies/Gates;
- prefer Laravel notifications;
- prefer Laravel jobs/queues;
- prefer Laravel scheduler;
- prefer Laravel filesystem;
- prefer Laravel cache;
- prefer Laravel logging.

Do not reinvent framework functionality.

---

# 9. PHP Standards

Use modern PHP compatible with the verified project runtime.

Mandatory:

- enable strict, clear type usage where appropriate;
- use return types;
- use parameter types;
- use nullable types explicitly;
- prefer constructor property promotion where appropriate;
- avoid dynamic properties;
- avoid unnecessary static state;
- avoid global helpers for business logic;
- avoid deeply nested conditionals;
- prefer early returns;
- keep methods focused;
- keep classes cohesive.

Follow PSR-compatible formatting and Laravel formatting conventions.

---

# 10. Naming Conventions

## Classes

```text
CourseController
CreateCourseAction
EnrollStudentAction
GradeSubmissionAction
CoursePolicy
CreateCourseRequest
SendGradePublishedNotification
GenerateGradeReportJob
```

## Models

Singular PascalCase:

```text
User
Course
Enrollment
Assignment
Submission
Quiz
QuizAttempt
Grade
```

## Tables

Plural snake_case:

```text
users
courses
enrollments
quiz_attempts
lesson_completions
```

## Methods

Use intention-revealing verbs:

```text
publish()
archive()
enroll()
suspend()
complete()
grade()
calculateScore()
markCompleted()
```

Avoid vague names:

```text
handleData()
processThing()
doStuff()
manage()
run()
```

unless the framework convention requires `handle()`.

---

# 11. Model Rules

Models represent persisted domain state.

Models may contain:

- relationships;
- casts;
- scopes;
- small domain state helpers;
- safe computed attributes.

Models should not become giant service objects.

Avoid placing complex workflows directly inside models.

Example:

Acceptable:

```text
course->isPublished()
enrollment->isActive()
grade->isPublished()
```

Prefer an Action/Service for:

```text
Enroll a Student
Finalize Quiz Attempt
Grade Submission
Publish Course
Archive Course
```

---

# 12. Eloquent Relationship Rules

Define explicit relationships.

Examples:

```text
Course hasMany Modules
Course hasMany Enrollments
Course belongsTo Category

Enrollment belongsTo Course
Enrollment belongsTo User

Assignment belongsTo Course
Assignment hasMany Submissions
```

Never perform repeated manual foreign-key queries when an Eloquent relationship exists.

Prevent N+1 queries.

Use eager loading appropriately.

Example:

```text
Course::with(['category', 'instructors'])
```

instead of triggering queries inside loops.

Do not eager-load large relationships unnecessarily.

---

# 13. Controller Rules

Controllers must remain thin.

Controllers may:

1. receive validated request;
2. authorize;
3. invoke Action/Service;
4. return response.

Controllers must not contain:

- long database workflows;
- quiz scoring;
- enrollment rules;
- grade calculation;
- complex conditional business logic;
- transaction orchestration.

Bad pattern:

```text
Controller
→ validation
→ 15 queries
→ calculations
→ notifications
→ audit
→ redirect
```

Preferred:

```text
Controller
→ Form Request
→ Policy
→ Action
→ Response
```

---

# 14. Service / Action Rules

Use Actions or Services when logic:

- spans multiple models;
- is reused;
- requires a transaction;
- triggers side effects;
- represents a business use case.

Examples:

```text
CreateCourseAction
AssignInstructorAction
EnrollStudentAction
SubmitAssignmentAction
GradeSubmissionAction
StartQuizAttemptAction
FinalizeQuizAttemptAction
PublishGradeAction
ArchiveCourseAction
```

Actions should have one clear responsibility.

Avoid generic services like:

```text
CommonService
HelperService
UtilityService
DataService
```

unless they represent a real cohesive responsibility.

---

# 15. Repository Strategy

Repository Pattern is **not mandatory**.

Default:

> Use Eloquent directly through application/service boundaries.

Create repository/query objects only when:

- queries are complex;
- reporting queries are reusable;
- multiple data sources exist;
- persistence abstraction creates real value;
- testing requires a meaningful boundary.

Never create one repository for every model simply to satisfy a pattern.

Avoid wrappers that only mirror Eloquent:

```text
find()
findAll()
create()
update()
delete()
```

without providing domain value.

---

# 16. Form Request Rules

Use Form Requests for:

- complex validation;
- reusable validation;
- create/update resource requests;
- authorization-aware form validation.

Examples:

```text
StoreCourseRequest
UpdateCourseRequest
StoreAssignmentRequest
UpdateQuizRequest
ImportUsersRequest
```

Simple Livewire forms may use Livewire validation when appropriate, but complex validation must remain clearly organized.

Never trust browser/client-side validation.

All important rules must be validated server-side.

---

# 17. Validation Rules

Validation must cover:

- required values;
- data types;
- ranges;
- unique values;
- foreign references;
- status values;
- date ordering;
- file types;
- file sizes;
- ownership/context.

Examples:

```text
score <= assignment.max_score

available_until > available_from

attempt_limit >= 1

Course must exist

Student must have active Enrollment
```

Business-rule validation belongs in domain/application logic when it depends on application state rather than input shape.

---

# 18. Authorization Rules

Use:

- Policies;
- Gates;
- capabilities/permissions.

Never rely only on:

- hidden buttons;
- disabled links;
- frontend conditions;
- route names.

Authorization must occur server-side.

Examples:

```text
CoursePolicy
AssignmentPolicy
SubmissionPolicy
QuizPolicy
GradePolicy
ReportPolicy
```

Authorization must account for:

```text
Role
+
Permission
+
Resource Scope
+
Course Assignment
+
Enrollment Status
```

---

# 19. User Role Rules

Primary MVP roles:

```text
Administrator
Instructor
Student
```

Secondary:

```text
Manager / Viewer
Super Administrator
```

Do not scatter role-name checks across the codebase.

Avoid:

```php
if ($user->role === 'admin') ...
```

everywhere.

Prefer capability and policy evaluation.

Role changes must be auditable.

---

# 20. Database Migration Rules

Mandatory:

> Never modify an existing production migration after it has been released/applied.

For schema changes:

```text
Create a new migration.
```

Migration rules:

- keep migrations focused;
- define foreign keys explicitly;
- define indexes intentionally;
- avoid silent destructive operations;
- document dangerous migration behavior;
- review large data transformations carefully.

Do not combine unrelated schema changes into one migration.

---

# 21. Database Rules

Follow `docs/DATABASE.md`.

Key rules:

- MySQL is the persistent source of truth;
- use foreign keys where relationships are concrete;
- preserve academic history;
- avoid generic JSON relations;
- avoid EAV architecture;
- use decimal for scores;
- avoid float/double for authoritative scores.

Important invariants:

```text
Student-Course Enrollment unique
Lesson Completion unique per Student/Lesson
Assignment Submission unique per Student/Assignment in MVP
Quiz Attempt unique by quiz/user/attempt number
Grade source must be Assignment OR Quiz
```

---

# 22. Database Transaction Rules

Use transactions for multi-step critical operations.

Examples:

```text
Create User + Assign Role
Enrollment Status Change + Audit
Assignment Submission + File Relations
Grade Submission + Audit
Quiz Finalization + Grade
Role Change + Audit
```

Pattern:

```text
validate
→ authorize
→ transaction
→ commit
→ dispatch non-critical side effects
```

Do not keep transactions open during slow external network calls.

Do not send non-critical email inside a transaction if it can be queued after commit.

---

# 23. Query Performance Rules

Mandatory:

- prevent N+1 queries;
- eager load intentionally;
- paginate large lists;
- use indexed filters;
- avoid query-per-row patterns;
- do not load entire large tables into memory;
- use chunking for large background operations.

Before adding cache or search infrastructure:

1. inspect query;
2. inspect indexes;
3. fix N+1;
4. reduce selected columns where helpful;
5. profile actual bottleneck.

---

# 24. Queue Rules

Use queues for slow, non-critical side effects.

Candidates:

- emails;
- bulk notifications;
- large imports;
- large exports;
- scheduled reminders;
- cleanup jobs.

Do not queue the authoritative persistence of:

- Assignment Submission;
- Grade;
- Enrollment;
- Quiz finalization;

in a way that makes the browser receive success before the core business transaction is safely stored.

Queue jobs should be retry-safe.

Avoid duplicate side effects on retry.

---

# 25. Job Rules

Jobs should:

- have one responsibility;
- contain serializable inputs;
- reload database state where appropriate;
- enforce safe retry behavior;
- log relevant failure context.

Do not pass giant model graphs into queued jobs.

Do not assume a job executes immediately.

---

# 26. Event Rules

Events are useful when a completed domain action should notify independent listeners.

Examples:

```text
CoursePublished
AssignmentPublished
AssignmentSubmitted
GradePublished
AnnouncementPublished
EnrollmentChanged
```

Events must not obscure critical business flow.

Avoid creating events for every trivial model update.

---

# 27. Listener Rules

Listeners should handle secondary effects.

Examples:

```text
SendAssignmentPublishedNotification
SendGradePublishedNotification
WriteOptionalAnalyticsEvent
```

Critical persistence should remain inside the primary Action/transaction.

Do not place essential grade calculation inside a listener that may fail asynchronously.

---

# 28. Notification Rules

Use Laravel Notifications where appropriate.

MVP requires:

- in-app notification.

Email may accompany supported events.

Notifications must respect:

- enrollment;
- Course scope;
- user status;
- event eligibility.

Do not notify users outside their permitted Course context.

Notification failure must not reverse a valid academic transaction.

---

# 29. Email Rules

Use Laravel Mail/Notification infrastructure.

Rules:

- no plaintext password;
- no secrets;
- no reset token logging;
- use queues for non-critical bulk email;
- email failure should be logged.

Environment-specific SMTP values belong in environment configuration.

Never hardcode SMTP credentials.

---

# 30. File Upload Rules

All uploads must be validated server-side.

Validate:

- file size;
- MIME type;
- extension if relevant;
- upload context;
- user authorization.

Protected academic files should be stored privately.

Never trust the original filename as the physical storage filename.

Store file metadata separately.

Never allow uploaded PHP/script files to become executable application code.

Examples of protected files:

- Assignment submissions;
- private Lesson resources;
- internal Course files.

---

# 31. Blade Rules

Blade templates should contain presentation logic only.

Allowed:

```text
simple conditions
loops
component composition
formatting
```

Avoid:

- business calculations;
- database queries;
- authorization logic duplicated from policies;
- complex data mutation.

Escape user-generated output by default.

Use raw HTML output only when:

1. content is intentionally rich text;
2. sanitization strategy exists;
3. output is known safe.

Never use `{!! !!}` casually.

---

# 32. Livewire Rules

Livewire components should:

- manage UI state;
- validate interaction input;
- authorize actions;
- invoke application Actions/Services;
- expose presentation data.

Avoid giant Livewire components containing entire module business logic.

Split components when they become responsible for unrelated workflows.

Prevent duplicate submissions during processing.

Use loading states.

Do not use Livewire to bypass policies or server-side validation.

---

# 33. Alpine.js Rules

Use Alpine.js for small client-side interaction.

Good use cases:

- dropdown;
- modal;
- tabs;
- sidebar toggle;
- temporary UI state;
- simple transitions.

Do not move core LMS business logic into Alpine.js.

The browser is not the source of truth for:

- score;
- enrollment;
- permission;
- submission state;
- quiz attempt limit.

---

# 34. Tailwind CSS Rules

Use the existing Tailwind design system.

Rules:

- reuse component styles;
- avoid arbitrary values unless necessary;
- maintain spacing consistency;
- maintain responsive behavior;
- maintain accessible focus states;
- avoid excessive visual complexity.

Follow `docs/UI_UX.md`.

Do not introduce another CSS framework.

---

# 35. Route Rules

Routes should:

- follow Laravel RESTful conventions where appropriate;
- use clear names;
- use middleware;
- group related modules;
- reflect resource hierarchy without excessive nesting.

Prefer route names like:

```text
courses.index
courses.show
courses.assignments.index
courses.gradebook
```

Avoid unnecessarily deep route nesting.

Never place sensitive action logic directly in route closures for production features.

---

# 36. API Rules

Public REST API is not part of the MVP.

Do not create a large API layer unless requested.

If internal JSON endpoints are needed:

- authenticate;
- authorize;
- validate;
- reuse application services.

Future public API must reuse existing business rules rather than duplicate them.

---

# 37. Search Rules

MVP search should use database-backed search/filtering.

Do not introduce:

- Elasticsearch;
- Meilisearch;
- Algolia;

without demonstrated need and explicit justification.

Optimize first:

```text
query
indexes
pagination
eager loading
```

---

# 38. Import Rules

CSV import must:

- validate file;
- validate header;
- validate each row;
- report success/skipped/failed counts;
- report failure reason;
- prevent duplicate unique identifiers.

Large imports may use queues.

Do not silently discard invalid rows without reporting them.

---

# 39. Export Rules

Exports must:

- respect authorization;
- respect active filters;
- avoid leaking unrelated data;
- use CSV for MVP where documented.

Large exports may run asynchronously.

Temporary exports must have cleanup rules.

---

# 40. Reporting Rules

Reports are read-oriented.

Reports must not mutate source academic records.

Reports must enforce permission scope.

Avoid adding a data warehouse for MVP.

Use relational queries from:

- Users;
- Enrollments;
- Courses;
- Submissions;
- Grades;
- Lesson Completions;
- Quiz Attempts.

---

# 41. Cache Rules

Cache is optional optimization.

Never make cache the source of truth.

Suitable candidates:

- institution settings;
- branding;
- permissions;
- expensive dashboard aggregates.

Unsafe stale-cache candidates:

- Enrollment authorization;
- current Grade publication;
- Quiz attempt eligibility;
- Submission success.

Invalidate cache when underlying configuration changes.

Do not introduce Redis without justification.

---

# 42. Logging Rules

Log:

- unexpected exceptions;
- queue failures;
- scheduled job failures;
- import failures;
- export failures;
- external integration failures;
- operational anomalies.

Never log:

- passwords;
- reset tokens;
- database passwords;
- SMTP secrets;
- API secrets;
- application keys.

Production logging should provide enough context to diagnose errors safely.

---

# 43. Activity / Audit Logging Rules

Mandatory audited events include:

```text
User create/update/deactivate
Role changes
Permission changes
Course create/update/archive
Enrollment changes
Grade create/change
```

Audit record should include:

- actor;
- action;
- target;
- timestamp;
- summary;
- relevant before/after values.

Audit records must not be normally editable.

Do not store secrets inside before/after payloads.

---

# 44. Error Handling Rules

User-facing errors must be safe and understandable.

Types:

```text
Validation
Authentication
Authorization
Not Found
Business Rule
Conflict
File Upload
External Service
Unexpected Exception
```

Production must never show stack traces to end users.

Failed critical transactions must roll back.

Never show:

```text
Submission successful
```

if the Submission was not persisted.

Never show:

```text
Grade saved
```

if the transaction failed.

---

# 45. Security Rules

Mandatory:

- validate all external input;
- authorize all protected actions;
- use CSRF protection;
- use secure authentication;
- hash passwords;
- protect private files;
- use HTTPS in production;
- escape user-generated output;
- sanitize approved rich-text output;
- rate-limit sensitive endpoints where appropriate;
- never expose environment secrets;
- never commit credentials.

Never trust:

- hidden form fields;
- browser role values;
- client-calculated score;
- client-generated timestamps for authoritative academic events.

---

# 46. Sensitive Configuration Rules

Never commit:

```text
.env
production credentials
database passwords
SMTP passwords
API keys
private keys
access tokens
```

Use environment variables.

Provide safe placeholders in:

```text
.env.example
```

Never paste real secrets into source comments or documentation.

---

# 47. Testing Rules

Important business logic must have automated tests.

Minimum areas:

```text
Authentication
Inactive user login
Authorization
Course visibility
Enrollment access
Assignment submission
Late submission
Assignment grading
Quiz availability
Quiz attempt limit
Quiz scoring
Grade visibility
Progress calculation
Discussion closure
Private file access
CSV import validation
Critical audit events
```

When fixing a bug:

> Add or update a regression test whenever practical.

Do not delete failing tests simply to make the suite green.

---

# 48. Testing Types

Use appropriate levels:

## Unit Tests

For:

- deterministic calculations;
- domain rules;
- pure helpers.

## Feature Tests

For:

- routes;
- auth;
- authorization;
- CRUD workflows;
- business transactions.

## Livewire Tests

For:

- Livewire interaction;
- validation;
- component actions.

## Integration Tests

For:

- database relationships;
- transactions;
- file operations.

## Browser / E2E

Use selectively for critical journeys if project tooling supports it.

---

# 49. Test Data Rules

Use:

- factories;
- seeders;
- deterministic fixtures.

Do not depend on production data.

Tests must be isolated.

Critical test personas:

```text
Administrator
Instructor A
Instructor B
Student A
Student B
```

This helps verify cross-Course and cross-Student authorization boundaries.

---

# 50. UI/UX Rules

Follow:

```text
docs/UI_UX.md
```

Key rules:

- professional SaaS appearance;
- simple layouts;
- role-aware navigation;
- consistent CRUD patterns;
- responsive behavior;
- accessible focus states;
- meaningful empty states;
- meaningful loading states;
- contextual confirmation dialogs.

Do not introduce a radically different UI pattern for one module.

---

# 51. Accessibility Rules

Maintain:

- keyboard navigation;
- visible focus;
- semantic HTML;
- accessible labels;
- usable validation;
- sufficient contrast;
- meaningful button labels.

Icon-only controls need accessible names.

Do not convey status only through color.

---

# 52. Documentation Rules

Update documentation when:

- architecture changes;
- database schema changes;
- business flow changes;
- major module behavior changes;
- deployment requirements change;
- new environment variables are introduced;
- upgrade procedure changes.

Relevant docs:

```text
docs/PRD.md
docs/SRS.md
docs/SYSTEM_DESIGN.md
docs/BUSINESS_FLOW.md
docs/DATABASE.md
docs/UI_UX.md
CURSOR.md
```

Do not change PRD business rules merely to match implementation mistakes.

---

# 53. Git Discipline

Keep commits focused.

Preferred:

```text
feat: add course status filter
fix: prevent duplicate course enrollment
test: cover grade publication authorization
docs: update enrollment workflow
```

Avoid commits containing unrelated changes.

Do not commit:

- `.env`;
- generated secrets;
- local IDE files unless project-approved;
- temporary debug files;
- database dumps containing sensitive data;
- build artifacts unless repository policy requires them.

---

# 54. Refactoring Discipline

Refactoring is allowed when required to safely implement the feature.

Rules:

- keep refactor scope small;
- preserve public behavior;
- keep tests passing;
- avoid renaming unrelated files/classes;
- do not perform formatting churn across unrelated files.

Before a large refactor:

1. explain why it is necessary;
2. identify affected modules;
3. identify compatibility risk;
4. add/confirm test coverage.

---

# 55. Backward Compatibility

Maintain backward compatibility whenever practical.

Before changing:

- public methods;
- database columns;
- configuration keys;
- route names;
- component contracts;
- stored statuses;
- event payloads;

inspect existing consumers.

Do not silently break existing flows.

Use deprecation/migration strategy where appropriate.

---

# 56. Dependency Rules

Never introduce a package without justification.

Before installing a package:

1. check whether Laravel already provides the capability;
2. inspect existing dependencies;
3. identify maintenance status;
4. identify version compatibility;
5. identify security implications;
6. explain why the dependency is necessary.

Do not add packages for trivial helpers.

Prefer Laravel-native functionality.

---

# 57. Production Migration Safety

Never modify a production migration that may already have been executed.

Schema change:

```text
Existing migration
        ↓
DO NOT EDIT
        ↓
Create new migration
```

Before destructive schema changes:

- backup;
- assess data impact;
- create migration path;
- maintain compatibility when possible.

---

# 58. Business Rule Protection

Do not silently change business rules.

Examples of protected rules:

```text
Inactive User cannot login.

Draft Course is invisible to Student.

Student requires active Enrollment for private Course.

Student cannot view another Student's Grade.

Assignment score cannot exceed maximum score.

Quiz attempts cannot exceed configured limit.

Grade changes must be auditable.

Enrollment changes must be auditable.

Course archive preserves history.
```

If code conflicts with documented requirements:

1. identify the conflict;
2. do not silently choose a new rule;
3. follow the authoritative documentation unless user explicitly changes it.

---

# 59. Academic Data Integrity

Treat these as high-value data:

```text
Enrollments
Submissions
Quiz Attempts
Grades
Lesson Completions
Audit Logs
```

Never casually:

- delete;
- overwrite;
- reset;
- recalculate destructively.

Changes to historical academic records require explicit business rules and auditability.

---

# 60. Status Transition Rules

Follow `docs/BUSINESS_FLOW.md`.

## User

```text
active ↔ inactive
```

## Course

```text
draft → published
draft → archived
published → draft if allowed
published → archived
archived → published only if explicitly allowed
```

## Enrollment

```text
active → completed
active → suspended
active → removed
suspended → active
suspended → removed
completed → active only for authorized reopen
```

## Lesson

```text
draft ↔ published
```

## Assignment

```text
draft → published
published → closed
closed → published if authorized
```

## Quiz

```text
draft → published
published → closed
closed → published if authorized
```

## Discussion

```text
open ↔ closed
```

Do not create arbitrary undocumented status transitions.

---

# 61. Assignment Submission Rules

MVP assumes one final Submission per Student per Assignment.

Do not add version/resubmission support unless the requirement changes.

Submission success requires:

```text
valid Student
+
active Enrollment
+
available Assignment
+
valid text/file
+
successful persistence
```

`submitted_at` must use authoritative server time.

Late status must use server time.

---

# 62. Quiz Rules

MVP question types:

```text
Multiple Choice
True / False
```

Do not add:

- essay;
- matching;
- fill-in;
- random pools;
- advanced grading;

unless requested.

Quiz scoring must be deterministic.

Never trust browser-computed final score.

Finalization must be protected against duplicate submission.

---

# 63. Grade Rules

Grade is authoritative academic data.

Rules:

- score >= 0;
- score <= max score;
- Student sees only own Grade;
- Instructor access is Course-scoped;
- Grade changes are audited;
- Grade publication visibility is consistent.

Do not derive grades from client-submitted totals.

---

# 64. File Storage Rules

Follow `docs/DATABASE.md` and `docs/SYSTEM_DESIGN.md`.

Use centralized File metadata.

Do not embed binary files in MySQL.

Private file access:

```text
Authenticate
→ Authorize parent resource
→ Serve protected file
```

Do not expose private Submission files using permanent predictable public URLs.

---

# 65. Settings Rules

Standard institution configuration should use product settings.

Do not create customer-specific hardcoded behavior when a generic approved setting can represent it.

However:

> Do not add dozens of speculative settings.

Settings must represent real product requirements.

Secrets are environment configuration, not institution settings.

---

# 66. Demo Mode Rules

If demo mode exists:

- clearly indicate demo restrictions;
- do not fake successful destructive actions;
- protect demo credentials;
- prevent destructive reset-sensitive actions;
- production mode must not inherit demo restrictions.

Demo behavior must remain separate from normal production authorization rules.

---

# 67. Performance Rules

Target behavior follows the SRS.

Important:

- paginate large tables;
- eager load relationships;
- avoid repeated aggregate queries;
- optimize indexes before adding infrastructure;
- queue slow exports/imports;
- cache only where safe.

Do not optimize prematurely with complex infrastructure.

---

# 68. Scalability Rules

Initial strategy:

> Vertical scaling first.

Do not introduce:

- Kubernetes;
- sharding;
- Kafka;
- service mesh;
- distributed database;
- microservices;

for MVP.

Future scale can separate:

- database;
- object storage;
- queue;
- web nodes;

when actual usage justifies it.

---

# 69. SaaS / Multi-Tenant Rules

Multi-tenancy is not part of MVP.

Do not casually add:

```text
tenant_id
```

to every table.

Future tenancy requires explicit architecture decisions covering:

- tenant identity;
- database isolation;
- cache isolation;
- queue isolation;
- file isolation;
- custom domains;
- billing;
- tenant backups.

The existing Institution model is not sufficient to claim SaaS isolation.

---

# 70. API and Webhook Future Readiness

Do not create public APIs/webhooks until requested.

Maintain business logic outside Blade so future APIs can reuse Actions/Services.

Future integration should call:

```text
same authorization
same validation
same domain rules
same application actions
```

not duplicate business logic.

---

# 71. Debugging Rules

When debugging:

1. reproduce the issue;
2. inspect logs;
3. inspect relevant request;
4. inspect database state;
5. inspect authorization;
6. inspect relationships;
7. inspect tests;
8. identify root cause;
9. fix minimally;
10. add regression test.

Do not hide errors with broad exception swallowing.

Avoid:

```php
try {
    ...
} catch (\Throwable $e) {
    return true;
}
```

or similar patterns that conceal failure.

---

# 72. AI-Specific File Editing Rules

Before modifying a file:

- read the entire relevant section;
- inspect imports/use statements;
- inspect neighboring methods;
- identify project conventions;
- inspect related tests.

When editing:

- preserve style;
- preserve naming;
- preserve architecture;
- make the smallest coherent change.

After editing:

- review diff;
- remove unused imports;
- ensure formatting;
- ensure tests;
- ensure no debug code remains.

---

# 73. AI Must Not Guess Existing Architecture

If a file/class/service is referenced:

> Search for it before assuming it exists.

Never invent:

- service names;
- table names;
- routes;
- models;
- components;
- packages;

and then build on those assumptions without checking the repository.

---

# 74. AI Must Reuse Existing Components

Before creating:

- a new button component;
- modal component;
- table component;
- permission helper;
- service abstraction;
- upload handler;
- status badge;

search the existing project first.

Prefer reuse over duplication.

---

# 75. AI Must Avoid Duplicate Business Logic

If the same rule is required in multiple places:

Bad:

```text
Controller A rule
Controller B same rule
Livewire component same rule
Job same rule
```

Preferred:

```text
Central Action / Domain Rule / Policy
```

Then reuse it.

---

# 76. AI Must Respect Existing Tests

Before changing tested behavior:

- read the tests;
- determine why behavior exists;
- update tests only when requirement changes.

Never change expected values merely because new code does not pass.

---

# 77. AI Must Not Mask Failures

Do not:

- disable validation;
- remove authorization;
- comment out tests;
- catch and ignore exceptions;
- return fake success;
- use nullable operators to hide broken relationships without understanding cause.

Fix the root issue.

---

# 78. AI Package Installation Rule

Before installing a package, the AI must state internally:

```text
Problem:
Why native Laravel is insufficient:
Candidate package:
Version compatibility:
Maintenance risk:
Security impact:
Removal cost:
```

If Laravel-native functionality is sufficient:

> Do not install the package.

---

# 79. AI Migration Rule

Before writing a migration:

1. inspect all existing migrations;
2. inspect current table structure;
3. inspect `docs/DATABASE.md`;
4. determine whether migration is new or modification;
5. never rewrite an existing production migration;
6. add indexes/FKs intentionally;
7. assess data migration needs.

---

# 80. AI Authorization Verification Rule

For every new protected feature, test at least:

```text
Authorized role → allowed
Unauthorized role → denied
Wrong Course scope → denied
Wrong Student resource → denied
Unauthenticated → denied
```

Where applicable.

---

# 81. AI CRUD Checklist

For a new CRUD feature, verify:

```text
Index
Search
Filter if required
Pagination
Create
Validation
Authorization
Edit
Status transition
Detail page
Empty state
Loading state
Error state
Audit if required
Tests
```

Do not automatically implement hard Delete.

Use domain status or archive where product rules require history.

---

# 82. AI Feature Completion Checklist

Before considering a task complete:

- [ ] Requirement understood
- [ ] Existing implementation inspected
- [ ] Architecture respected
- [ ] Business rule unchanged unless requested
- [ ] Validation added
- [ ] Authorization added
- [ ] Transactions used if required
- [ ] N+1 checked
- [ ] Pagination used where required
- [ ] Uploads validated if present
- [ ] Sensitive data protected
- [ ] Error states handled
- [ ] Loading states handled
- [ ] Audit event added if required
- [ ] Notification behavior checked
- [ ] Tests added/updated
- [ ] Existing tests pass
- [ ] Documentation updated if needed
- [ ] No unrelated refactor
- [ ] No unnecessary package
- [ ] No debug code
- [ ] No credentials committed

---

# 83. AI Response Discipline

When reporting implementation work, AI should be concise and factual.

Mention:

1. what changed;
2. important architectural decisions;
3. tests performed;
4. unresolved risks or blockers.

Do not claim:

```text
fully tested
production ready
secure
```

unless the relevant verification was actually performed.

---

# 84. Prohibited Patterns

Avoid unless explicitly justified:

```text
Fat Controllers
God Services
God Models
Business Logic in Blade
Business Logic in Alpine.js
Raw SQL concatenated with user input
Unpaginated large tables
Public URLs for private files
Role checks duplicated everywhere
Hardcoded credentials
Hardcoded institution branding
Huge generic helper classes
Repository for every model
Microservices for MVP
Premature tenant_id everywhere
Premature Redis requirement
Premature Elasticsearch
Silent exception swallowing
Editing existing production migrations
Large unrelated refactors
```

---

# 85. Core Engineering Priorities

When trade-offs occur, use this priority:

```text
1. Correctness
2. Security
3. Data Integrity
4. Business Rule Compliance
5. Authorization
6. Testability
7. Maintainability
8. User Experience
9. Performance
10. Scalability
11. Architectural Elegance
```

Do not sacrifice correctness for abstraction elegance.

---

# 86. Final Permanent Instruction

Every AI coding assistant working on LearnFlow LMS must follow this workflow:

```text
READ REQUIREMENT
    ↓
INSPECT EXISTING CODE
    ↓
IDENTIFY EXISTING PATTERN
    ↓
DESIGN SMALLEST SAFE CHANGE
    ↓
VALIDATE
    ↓
AUTHORIZE
    ↓
IMPLEMENT BUSINESS LOGIC
    ↓
USE TRANSACTION IF NEEDED
    ↓
HANDLE SIDE EFFECTS
    ↓
TEST
    ↓
REVIEW DIFF
    ↓
UPDATE DOCUMENTATION IF REQUIRED
```

The guiding rule is:

> **Understand first. Change second.**

Do not invent architecture when the project already has one.

Do not silently change business rules.

Do not introduce complexity without demonstrated value.

Prefer Laravel-native functionality.

Keep LearnFlow simple, secure, maintainable, commercially reusable, and compatible with future upgrades.
