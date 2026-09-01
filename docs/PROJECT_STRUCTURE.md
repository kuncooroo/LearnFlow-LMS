# PROJECT STRUCTURE — LearnFlow LMS

## Document Information

| Field | Value |
|---|---|
| Product | LearnFlow LMS |
| Document | Recommended Laravel Directory & Module Structure |
| Version | 1.0 |
| Architecture | Laravel Modular Monolith |
| Stack Target | Laravel 13.x, PHP 8.4.x, MySQL 8.4.x, Blade, Livewire, Alpine.js, Tailwind CSS |
| Sources | `PRD`, `SRS`, `SYSTEM_DESIGN`, `DATABASE`, `BUSINESS_FLOW`, `CURSOR.md` |

> This document defines **where code lives** and **what each layer owns**.  
> It intentionally avoids microservices, mandatory repositories, DDD ceremony, and package-per-module extraction for MVP.

---

# 1. Architecture Decision

## Recommended Style

```text
Laravel Modular Monolith
├── Laravel-conventional top-level folders
└── Domain-grouped subfolders inside each layer
```

**Why this shape**

1. Matches `SYSTEM_DESIGN` ADR-001 / ADR-002 / ADR-004.
2. Follows Laravel conventions (`CURSOR.md` §8) so Artisan, IDE, and onboarding stay simple.
3. Keeps logical Core Platform vs LMS Domain boundaries without Composer packages.
4. Scales by adding folders, not by inventing frameworks.
5. Keeps business logic in Actions/Services so a future API can reuse the same use cases.

## What We Explicitly Avoid for MVP

| Pattern | Status | Reason |
|---|---|---|
| Microservices | Rejected | One deployable app on VPS |
| Package-per-module (`nwidart/modules`, etc.) | Not default | Extra ceremony without proven need |
| Repository per model | Rejected | Eloquent is the persistence API |
| Fat Controllers / Fat Livewire | Rejected | Business rules belong in Actions |
| God Services (`CommonService`) | Rejected | Prefer focused Actions |
| DTOs everywhere | Rejected | Use only when typed input adds clarity |
| Premature `tenant_id` everywhere | Rejected | Multi-tenancy is future SaaS work |
| Helpers for business logic | Rejected | Domain rules live in Actions/Models/Policies |

---

# 2. Logical Modules

Modules are **logical**, not separate deployables.

## 2.1 Core Platform

| Module | Owns |
|---|---|
| Auth | Login, logout, password reset, session |
| Users | User CRUD, activate/deactivate, CSV import |
| Access | Roles, permissions, role assignment |
| Institution | Institution profile, branding, settings |
| Files | File metadata, private/public storage access |
| Notifications | In-app + email notification delivery |
| Audit | Append-only activity logs |
| Dashboard | Role-aware dashboard foundation |

## 2.2 LMS Domain

| Module | Owns |
|---|---|
| Categories | Course categories |
| Courses | Course lifecycle, instructor assignment, visibility |
| Enrollments | Student ↔ Course participation states |
| Content | Modules, lessons, lesson resources |
| Assignments | Assignments, submissions, late rules |
| Quizzes | Quizzes, questions, options, attempts, scoring |
| Grades | Grade records, publication, gradebook |
| Progress | Lesson completions, course progress % |
| Announcements | Course announcements |
| Discussions | Threads, replies, open/closed |
| Reports | Read-only aggregates + CSV export |

---

# 3. Recommended Directory Tree

```text
learnflow-lms/
├── app/
│   ├── Actions/                         # Application use cases (primary business entry)
│   │   ├── Auth/
│   │   ├── Users/
│   │   ├── Access/
│   │   ├── Institution/
│   │   ├── Files/
│   │   ├── Courses/
│   │   ├── Enrollments/
│   │   ├── Content/
│   │   ├── Assignments/
│   │   ├── Quizzes/
│   │   ├── Grades/
│   │   ├── Progress/
│   │   ├── Announcements/
│   │   ├── Discussions/
│   │   └── Reports/
│   │
│   ├── Models/                          # Eloquent models (flat; ~30 entities)
│   │   ├── Concerns/                    # Shared model traits (optional)
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── Institution.php
│   │   ├── InstitutionSetting.php
│   │   ├── File.php
│   │   ├── ActivityLog.php
│   │   ├── CourseCategory.php
│   │   ├── Course.php
│   │   ├── CourseInstructor.php
│   │   ├── Enrollment.php
│   │   ├── Module.php
│   │   ├── Lesson.php
│   │   ├── LessonCompletion.php
│   │   ├── Assignment.php
│   │   ├── Submission.php
│   │   ├── Quiz.php
│   │   ├── Question.php
│   │   ├── AnswerOption.php
│   │   ├── QuizAttempt.php
│   │   ├── QuizAnswer.php
│   │   ├── Grade.php
│   │   ├── Announcement.php
│   │   ├── DiscussionThread.php
│   │   └── DiscussionReply.php
│   │
│   ├── Enums/                           # Backed enums for status / type fields
│   │   ├── UserStatus.php
│   │   ├── CourseStatus.php
│   │   ├── EnrollmentStatus.php
│   │   ├── LessonStatus.php
│   │   ├── AssignmentStatus.php
│   │   ├── QuizStatus.php
│   │   ├── QuizAttemptStatus.php
│   │   ├── GradePublicationStatus.php
│   │   ├── DiscussionStatus.php
│   │   └── ...
│   │
│   ├── Policies/                        # Authorization
│   │   ├── UserPolicy.php
│   │   ├── CoursePolicy.php
│   │   ├── EnrollmentPolicy.php
│   │   ├── LessonPolicy.php
│   │   ├── AssignmentPolicy.php
│   │   ├── SubmissionPolicy.php
│   │   ├── QuizPolicy.php
│   │   ├── GradePolicy.php
│   │   ├── AnnouncementPolicy.php
│   │   ├── DiscussionThreadPolicy.php
│   │   ├── ReportPolicy.php
│   │   └── FilePolicy.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Login / password reset controllers if not Fortify/Breeze-only
│   │   │   ├── Admin/
│   │   │   ├── Instructor/
│   │   │   ├── Student/
│   │   │   └── Shared/                  # File download, profile, etc.
│   │   ├── Requests/                    # Form Requests, grouped by domain
│   │   │   ├── Users/
│   │   │   ├── Courses/
│   │   │   ├── Enrollments/
│   │   │   ├── Content/
│   │   │   ├── Assignments/
│   │   │   ├── Quizzes/
│   │   │   ├── Grades/
│   │   │   └── ...
│   │   └── Middleware/
│   │       ├── EnsureUserIsActive.php
│   │       └── EnsureRole.php           # Prefer policies; middleware only for coarse gates
│   │
│   ├── Livewire/                        # Interactive UI state
│   │   ├── Admin/
│   │   │   ├── Users/
│   │   │   ├── Courses/
│   │   │   ├── Enrollments/
│   │   │   ├── Reports/
│   │   │   └── Settings/
│   │   ├── Instructor/
│   │   │   ├── Courses/
│   │   │   ├── Content/
│   │   │   ├── Assignments/
│   │   │   ├── Quizzes/
│   │   │   ├── Gradebook/
│   │   │   └── Discussions/
│   │   ├── Student/
│   │   │   ├── Courses/
│   │   │   ├── Lessons/
│   │   │   ├── Assignments/
│   │   │   ├── Quizzes/
│   │   │   └── Grades/
│   │   └── Shared/
│   │       ├── Dashboard/
│   │       ├── Notifications/
│   │       └── Profile/
│   │
│   ├── Services/                        # Cohesive orchestration ONLY when justified
│   │   ├── Audit/
│   │   │   └── ActivityLogger.php
│   │   ├── Files/
│   │   │   └── FileStorageService.php
│   │   ├── Progress/
│   │   │   └── CourseProgressCalculator.php
│   │   └── Reports/
│   │       ├── UserReportQuery.php
│   │       ├── EnrollmentReportQuery.php
│   │       ├── CourseActivityReportQuery.php
│   │       ├── AssignmentSubmissionReportQuery.php
│   │       ├── GradeReportQuery.php
│   │       └── ProgressReportQuery.php
│   │
│   ├── Data/                            # Optional DTOs — create only when needed
│   │   └── ...                          # e.g. ImportUserRow.php
│   │
│   ├── Events/
│   │   ├── CoursePublished.php
│   │   ├── AssignmentPublished.php
│   │   ├── AssignmentSubmitted.php
│   │   ├── GradePublished.php
│   │   ├── AnnouncementPublished.php
│   │   └── EnrollmentChanged.php
│   │
│   ├── Listeners/
│   │   ├── SendAssignmentPublishedNotification.php
│   │   ├── SendGradePublishedNotification.php
│   │   ├── SendAnnouncementPublishedNotification.php
│   │   └── NotifyInstructorOfSubmission.php
│   │
│   ├── Notifications/
│   │   ├── AssignmentPublishedNotification.php
│   │   ├── GradePublishedNotification.php
│   │   ├── AnnouncementPublishedNotification.php
│   │   ├── SubmissionReceivedNotification.php
│   │   └── DeadlineReminderNotification.php
│   │
│   ├── Jobs/
│   │   ├── ProcessUserCsvImport.php
│   │   ├── GenerateReportExport.php
│   │   ├── SendBulkNotifications.php
│   │   ├── SendDeadlineReminders.php
│   │   └── CleanupTemporaryExports.php
│   │
│   ├── Mail/                            # Optional; prefer Notifications for MVP
│   ├── Exceptions/
│   │   └── BusinessRuleException.php
│   ├── Support/
│   │   ├── Traits/                      # Cross-cutting, non-domain traits
│   │   └── Helpers/                     # Tiny pure helpers only (rare)
│   ├── View/
│   │   └── Components/                  # Blade class components (buttons, alerts, etc.)
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── EventServiceProvider.php
│       └── ...
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│       ├── RoleSeeder.php
│       ├── PermissionSeeder.php
│       ├── DemoUserSeeder.php
│       └── ...
│
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── guest.blade.php
│   │   │   └── partials/
│   │   ├── components/                  # Anonymous Blade components
│   │   ├── auth/
│   │   ├── admin/
│   │   ├── instructor/
│   │   ├── student/
│   │   ├── shared/
│   │   ├── livewire/                    # Livewire Blade views (mirror Livewire classes)
│   │   │   ├── admin/
│   │   │   ├── instructor/
│   │   │   ├── student/
│   │   │   └── shared/
│   │   ├── emails/                      # If custom mail views are needed
│   │   └── errors/
│   └── lang/                            # Optional i18n later
│
├── routes/
│   ├── web.php                          # Thin entry; prefer includes
│   ├── auth.php
│   ├── admin.php
│   ├── instructor.php
│   ├── student.php
│   └── console.php
│
├── storage/
│   ├── app/
│   │   ├── private/                     # Protected academic files
│   │   └── public/                      # Branding / public assets
│   └── ...
│
├── tests/
│   ├── Unit/
│   │   ├── Enums/
│   │   ├── Actions/                     # Pure / deterministic action pieces
│   │   └── Services/
│   │       └── Progress/
│   ├── Feature/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   ├── Instructor/
│   │   ├── Student/
│   │   └── Shared/
│   └── Livewire/
│       ├── Admin/
│       ├── Instructor/
│       └── Student/
│
├── docs/                                # PRD, SRS, SYSTEM_DESIGN, etc.
└── CURSOR.md
```

---

# 4. Layer Responsibilities

```text
HTTP / Livewire
    → Form Request or Livewire validation
    → Policy / Gate
    → Action (or justified Service)
    → Model / Enum / Domain rule
    → DB transaction (if multi-write)
    → Event (optional, after commit)
    → Job / Notification (non-critical side effects)
    → Blade / Livewire response
```

| Layer | May do | Must not do |
|---|---|---|
| Controllers / Livewire | Validate, authorize, call Action, return UI | Quiz scoring, enrollment rules, grade math, multi-model workflows |
| Form Requests | Shape validation, authorize() when useful | Persist academic state |
| Actions | One use case, transactions, domain orchestration | Render HTML, hold UI state |
| Services | Cohesive multi-method capability (audit, files, reports) | Become god objects |
| Models | Relations, casts, scopes, small state helpers | Giant workflows |
| Policies | Capability + scope + relationship checks | Persist data |
| Events / Listeners | Secondary effects after success | Authoritative grade/enrollment writes |
| Jobs | Slow/retryable side effects | Be the only place core academic write succeeds |
| Views | Presentation, simple conditionals | Business calculations / DB queries |

---

# 5. Where Each Concern Belongs

## 5.1 Models — `app/Models`

**Belong here:** Eloquent entities from `DATABASE.md`.

Keep models **flat**. There are ~30 domain tables; nested `Models/Course/Course.php` adds noise without value.

Models may contain:

- relationships;
- casts (including Enums);
- query scopes (`published()`, `active()`);
- small helpers (`isPublished()`, `isActive()`).

Models must **not** contain:

- enroll student workflow;
- finalize quiz attempt;
- grade submission;
- CSV import logic.

Example:

```text
app/Models/Course.php
app/Models/Enrollment.php
app/Models/Grade.php
```

---

## 5.2 Controllers — `app/Http/Controllers/{Admin|Instructor|Student|Shared}`

**Belong here:** Thin HTTP entry points for:

- classic page loads / redirects;
- file download streaming;
- simple CRUD that is not Livewire-driven;
- export download endpoints.

Preferred flow:

```text
Controller
→ Form Request
→ Policy
→ Action
→ redirect / view / download
```

Group by **actor area**, not by random feature dump:

```text
Admin/UserController.php
Admin/CourseController.php
Instructor/AssignmentController.php
Student/SubmissionController.php
Shared/FileDownloadController.php
```

Livewire-heavy screens may skip Controllers entirely and route to Livewire full-page components. That is fine — do not force Controllers for every page.

---

## 5.3 Services — `app/Services` (sparingly)

**Use a Service when** logic is cohesive, multi-method, and reused across Actions — not for every model.

| Service | Justification |
|---|---|
| `ActivityLogger` | Shared audit write API used by many Actions |
| `FileStorageService` | Validate + store + metadata + private path rules |
| `CourseProgressCalculator` | Shared progress formula from SRS |
| `*ReportQuery` | Complex read queries / filters / exports |

**Do not create:**

```text
CourseService
UserService
CommonService
HelperService
DataService
```

unless a real cohesive responsibility emerges.

Default preference:

> **Action first.** Promote to Service only when multiple Actions share a stable capability.

---

## 5.4 Actions — `app/Actions/{Domain}`

**Primary home for business use cases.**

One Action = one clear responsibility. Invoked from Controllers, Livewire, Jobs, or Artisan.

Examples aligned with SRS / CURSOR:

```text
Actions/Users/CreateUserAction.php
Actions/Users/ChangeUserStatusAction.php
Actions/Users/ImportUsersFromCsvAction.php
Actions/Courses/CreateCourseAction.php
Actions/Courses/PublishCourseAction.php
Actions/Courses/ArchiveCourseAction.php
Actions/Courses/AssignInstructorAction.php
Actions/Enrollments/EnrollStudentAction.php
Actions/Enrollments/SuspendEnrollmentAction.php
Actions/Content/CreateLessonAction.php
Actions/Content/PublishLessonAction.php
Actions/Assignments/SubmitAssignmentAction.php
Actions/Assignments/GradeSubmissionAction.php
Actions/Quizzes/StartQuizAttemptAction.php
Actions/Quizzes/FinalizeQuizAttemptAction.php
Actions/Grades/PublishGradeAction.php
Actions/Progress/RecordLessonCompletionAction.php
Actions/Announcements/PublishAnnouncementAction.php
```

Action rules:

1. Accept validated input (array, Form Request data, or optional DTO).
2. Assume authorization already happened **or** re-check policy when called from Jobs.
3. Wrap multi-write academic work in a DB transaction.
4. Dispatch Events / Jobs **after** commit for non-critical side effects.
5. Keep a single public `execute(...)` / `__invoke(...)` style per project convention.

---

## 5.5 DTOs — `app/Data` (optional, rare)

**Default: do not use DTOs.**

Prefer:

- Form Request `validated()` arrays for HTTP;
- typed Action parameters for simple cases;
- Eloquent models for persisted state.

**Create a DTO only when:**

- CSV/import rows need a typed validated row object;
- an Action input is large and reused from multiple callers;
- Jobs need a serializable structured payload beyond IDs.

Examples (if needed later):

```text
app/Data/Users/ImportUserRow.php
app/Data/Reports/ReportFilterData.php
```

Do not create `CreateCourseDTO` merely to mirror every Form Request.

---

## 5.6 Enums — `app/Enums`

**Belong here:** lifecycle / status / type values from `BUSINESS_FLOW` and `DATABASE`.

```text
UserStatus: active | inactive
CourseStatus: draft | published | archived
EnrollmentStatus: active | completed | suspended | removed
LessonStatus: draft | published
AssignmentStatus: draft | published | closed
QuizStatus: draft | published | closed
QuizAttemptStatus: in_progress | submitted | ...
GradePublicationStatus: draft | published
DiscussionStatus: open | closed
```

Cast enums on models. Use enums in Policies, Actions, and validation `Rule::enum(...)`.

---

## 5.7 Policies — `app/Policies`

**Belong here:** server-side authorization combining:

```text
Capability / Permission
+ Resource scope
+ Course assignment / Enrollment relationship
+ Resource state
```

Examples:

```text
CoursePolicy
AssignmentPolicy
SubmissionPolicy
QuizPolicy
GradePolicy
ReportPolicy
FilePolicy
```

Never rely on hidden buttons alone. Livewire and Controllers must call `$this->authorize(...)` or equivalent.

Avoid scattering:

```php
if ($user->role === 'admin') { ... }
```

Prefer permissions + policies.

---

## 5.8 Form Requests — `app/Http/Requests/{Domain}`

**Belong here:** complex / reusable HTTP validation.

```text
StoreCourseRequest
UpdateCourseRequest
StoreAssignmentRequest
UpdateQuizRequest
ImportUsersRequest
StoreSubmissionRequest
```

Rules:

- validate shape, types, ranges, uniqueness, file MIME/size;
- put **state-dependent** business rules in Actions when they need DB context (active enrollment, attempt limits, etc.);
- Livewire may use component validation for simple forms; extract Form Request / shared rule objects when validation grows or is reused.

---

## 5.9 Jobs — `app/Jobs`

**Belong here:** slow, retryable, non-authoritative side effects.

Good candidates:

- emails / bulk notifications;
- large CSV import processing;
- large report CSV export;
- deadline reminders;
- temporary export cleanup.

Do **not** queue the authoritative write of:

- Assignment Submission;
- Grade;
- Enrollment;
- Quiz finalization;

in a way that returns success before MySQL commit.

Jobs should:

- accept IDs / small serializable payloads;
- reload models inside `handle()`;
- be retry-safe / idempotent where duplicates hurt.

---

## 5.10 Events — `app/Events`

**Belong here:** meaningful completed domain outcomes that need independent listeners.

Minimum useful set:

```text
CoursePublished
AssignmentPublished
AssignmentSubmitted
GradePublished
AnnouncementPublished
EnrollmentChanged
```

Do not emit an Event for every trivial `update()`.

Critical persistence stays in the Action transaction — Events must not own grade calculation or enrollment integrity.

---

## 5.11 Listeners — `app/Listeners`

**Belong here:** secondary effects after a successful domain operation.

```text
SendAssignmentPublishedNotification
SendGradePublishedNotification
NotifyInstructorOfSubmission
```

Listeners may queue themselves. Listener failure must not reverse a valid academic transaction.

---

## 5.12 Notifications — `app/Notifications`

**Belong here:** Laravel Notification classes for in-app (database) and optional mail channels.

MVP requires in-app notification. Email may accompany supported events.

Respect:

- enrollment / course scope;
- user active status;
- event eligibility.

---

## 5.13 Repositories — generally **not used**

Per ADR-004 / SRS §15 / CURSOR §15:

> Use Eloquent directly through Actions/Services.

**Allowed substitute when justified:** Report Query objects under `app/Services/Reports/`.

Do **not** create:

```text
CourseRepository::find()
CourseRepository::create()
```

wrappers that only mirror Eloquent.

If a complex reusable query later needs isolation, name it by purpose:

```text
CourseCatalogQuery
GradebookQuery
```

not `CourseRepository`.

---

## 5.14 Traits — `app/Models/Concerns` or `app/Support/Traits`

**Belong here:** small reusable behavior with a clear shared purpose.

Good:

```text
Models/Concerns/HasStatusTimestamps.php
Models/Concerns/BelongsToCourse.php
```

Avoid:

- traits that hide business workflows;
- mega-traits used by unrelated models;
- traits as a dumping ground for helpers.

Prefer composition via Actions/Services over trait soup.

---

## 5.15 Helpers — `app/Support/Helpers` (rare)

**Almost never for business logic.**

Allowed examples:

- formatting display dates with institution timezone;
- safe filename sanitization used by FileStorageService;
- tiny pure functions with no DB access.

Forbidden:

- `enroll_student()` helper;
- `calculate_grade()` helper;
- global helper bag for domain rules.

Prefer class methods / Actions / Enums.

---

## 5.16 Livewire Components — `app/Livewire/{Admin|Instructor|Student|Shared}`

**Belong here:** interactive UI state for LMS CRUD and workflows.

Livewire should:

1. hold UI state (filters, modals, forms);
2. validate interaction input;
3. authorize;
4. call Actions/Services;
5. expose presentation data.

Livewire must **not** become a second service layer containing quiz scoring, enrollment rules, or grade publication workflows.

Split components when a class starts owning unrelated workflows (e.g. separate `AssignmentIndex` vs `GradeSubmissionForm`).

Mirror Blade views under `resources/views/livewire/...`.

---

## 5.17 Views — `resources/views`

| Path | Purpose |
|---|---|
| `layouts/` | App / guest shells, nav, flash |
| `components/` | Reusable Blade UI atoms |
| `admin/`, `instructor/`, `student/` | Role-area pages (non-Livewire) |
| `livewire/` | Livewire templates |
| `auth/` | Login / reset |
| `emails/` | Mail templates if needed |
| `errors/` | Safe error pages |

Views may contain simple loops/conditions/formatting only. No business calculations, no ad-hoc authorization logic, no N+1 queries inside Blade.

---

## 5.18 Tests — `tests/{Unit|Feature|Livewire}`

| Type | Location | Cover |
|---|---|---|
| Unit | `tests/Unit` | Progress formula, quiz scoring helpers, enum transitions, pure calculators |
| Feature | `tests/Feature` | Auth, policies, enrollment, submission, grading, quiz finalize, audit, imports |
| Livewire | `tests/Livewire` | Component validation, UI actions, authorization paths |

Minimum coverage targets from CURSOR §47:

- inactive user login blocked;
- draft course invisible to student;
- enrollment-gated access;
- assignment submit + late rules;
- quiz attempt limit + scoring;
- grade visibility;
- progress calculation;
- private file access;
- CSV import validation;
- critical audit events.

Use factories + seed personas: Administrator, Instructor A/B, Student A/B.

---

# 6. Request Flow Examples

## 6.1 Student submits assignment

```text
Livewire Student\Assignments\SubmitAssignment
  → validate input + file
  → authorize SubmissionPolicy / AssignmentPolicy
  → Assignments\SubmitAssignmentAction
      → check active enrollment + availability
      → transaction: submission + file metadata
      → commit
      → event AssignmentSubmitted
  → Listener queues Instructor notification
  → UI success state
```

## 6.2 Instructor finalizes quiz scoring path

```text
Student\Quizzes\TakeQuiz (Livewire)
  → Quizzes\FinalizeQuizAttemptAction
      → ownership + in-progress checks
      → deterministic scoring
      → transaction: attempt + answers + grade
      → commit
  → optional GradePublished later via separate Action
```

## 6.3 Admin imports users

```text
Admin\Users\ImportUsers (Livewire)
  → validate CSV
  → Users\ImportUsersFromCsvAction
      → (small) sync process OR dispatch ProcessUserCsvImport Job
  → report success / skipped / failed rows
```

---

# 7. Routing Structure

```text
routes/
├── web.php          # require auth/admin/instructor/student
├── auth.php
├── admin.php        # middleware: auth + active + admin capability
├── instructor.php
├── student.php
└── console.php
```

Naming examples:

```text
admin.users.index
admin.courses.index
instructor.courses.assignments.index
student.courses.show
student.assignments.submit
shared.files.download
```

Keep nesting shallow. Prefer course-scoped resources without deep trees.

No public REST API in MVP. Internal JSON only if Livewire/UI truly needs it — still through Actions + Policies.

---

# 8. Database & Infrastructure Placement

| Concern | Location |
|---|---|
| Schema | `database/migrations` |
| Factories | `database/factories` |
| Seeders | `database/seeders` |
| Private files | `storage/app/private` (+ `files` metadata table) |
| Public branding | `storage/app/public` |
| Queue failed jobs | Laravel `failed_jobs` (if DB driver) |
| Scheduler | `routes/console.php` / `bootstrap/app.php` schedule |

Never edit released production migrations — add a new migration.

---

# 9. Naming Conventions

| Kind | Pattern | Example |
|---|---|---|
| Model | Singular PascalCase | `QuizAttempt` |
| Table | Plural snake_case | `quiz_attempts` |
| Action | Verb + Noun + `Action` | `EnrollStudentAction` |
| Policy | Noun + `Policy` | `EnrollmentPolicy` |
| Form Request | `Store/Update` + Noun + `Request` | `StoreCourseRequest` |
| Enum | Noun + purpose | `CourseStatus` |
| Job | Verb phrase + `Job` optional | `GenerateReportExport` |
| Notification | Event + `Notification` | `GradePublishedNotification` |
| Livewire | Domain noun / intent | `GradebookTable` |
| Test | Behavior under test | `StudentCannotViewOtherGradesTest` |

---

# 10. Growth Rules (Keep It Simple)

1. **Start flat inside each layer; group by domain when a folder exceeds ~8–12 related classes.**
2. **Add an Action before adding a Service.**
3. **Add a Report Query before adding a Repository.**
4. **Add a DTO only after arrays become error-prone.**
5. **Extract a Livewire child component before growing a god component.**
6. **Do not introduce module packages until multiple teams or release boundaries require them.**
7. **Do not add `tenant_id` to all tables until SaaS tenancy is designed.**
8. **Keep academic writes synchronous and transactional; keep email/export async.**

---

# 11. Mapping to Authoritative Docs

| Doc | How this structure honors it |
|---|---|
| PRD | Modules cover centralized LMS workflows (users → courses → assess → grade → report) |
| SRS | Modular monolith; Actions/Services; no mandatory repositories; Blade/Livewire |
| SYSTEM_DESIGN | Presentation / Application / Domain / Infrastructure layers |
| BUSINESS_FLOW | Status Enums + Actions for each status transition workflow |
| DATABASE | Flat Eloquent models matching entity list |
| CURSOR.md | Thin controllers, Action-first use cases, policies, queues for side effects only |

---

# 12. Final Recommendation

Use a **Laravel-conventional modular monolith**:

```text
Actions  = business use cases
Models   = persisted domain state
Policies = authorization
Requests = input shape validation
Livewire = interactive UI
Jobs     = async side effects
Events   = decoupling notifications/analytics
Services = rare shared capabilities (audit, files, progress, reports)
```

This stays maintainable as LearnFlow grows, remains familiar to Laravel developers, and preserves a clean path to future API/SaaS work — without paying abstraction tax on day one.
