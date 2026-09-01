# Software Requirements Specification (SRS)
# LearnFlow LMS

---

## 1. System Overview

### 1.1 Purpose

Dokumen ini mendefinisikan Software Requirements Specification untuk **LearnFlow LMS** berdasarkan `docs/PRD.md` sebagai **authoritative product requirement**. SRS menerjemahkan kebutuhan produk menjadi kebutuhan sistem, arsitektur aplikasi, aturan teknis, kualitas layanan, keamanan, data, deployment, testing, dan maintainability.

Jika terdapat perbedaan antara SRS ini dan PRD terkait perilaku produk, **PRD harus menjadi sumber kebenaran utama** dan SRS harus disesuaikan.

### 1.2 Product Summary

LearnFlow LMS adalah aplikasi web Learning Management System untuk mengelola:

- authentication;
- users;
- roles dan permissions;
- institution settings dan branding;
- courses;
- course categories;
- instructor assignment;
- student enrollment;
- modules;
- lessons;
- assignments;
- submissions;
- quizzes;
- quiz attempts;
- grading;
- gradebook;
- learning progress;
- announcements;
- discussions;
- notifications;
- dashboards;
- reports;
- import/export;
- audit trails.

MVP harus mendukung tiga role utama:

1. Administrator;
2. Instructor;
3. Student.

Manager/Viewer dan Super Administrator dapat tersedia sesuai kebutuhan deployment dan permission, tetapi tidak boleh menambah kompleksitas workflow inti MVP secara tidak perlu.

### 1.3 Environment Inspection Result

Pada saat SRS ini dibuat, artifact project yang tersedia untuk diperiksa adalah:

- `docs/PRD.md`;
- dokumen prompt/project instruction.

Tidak ditemukan konfigurasi project runtime seperti:

- `composer.json`;
- `composer.lock`;
- `package.json`;
- `package-lock.json`;
- `.env`;
- `.env.example`;
- Docker configuration;
- PHP runtime configuration;
- MySQL server configuration;
- web server configuration;
- CI/CD configuration.

Karena actual environment belum dapat diverifikasi, versi framework/runtime/database harus dicatat sebagai berikut:

| Component | Requested Target | Verified Actual Version |
|---|---|---|
| Backend Framework | Laravel 13.x | **TBD — Requires Environment Verification** |
| PHP | PHP 8.4.x | **TBD — Requires Environment Verification** |
| Database | MySQL 8.4.x | **TBD — Requires Environment Verification** |
| Server Rendering | Blade | **TBD — Requires Environment Verification** |
| Reactive UI | Livewire | **TBD — Requires Environment Verification** |
| Lightweight JS | Alpine.js | **TBD — Requires Environment Verification** |
| CSS | Tailwind CSS | **TBD — Requires Environment Verification** |
| Deployment | VPS | VPS deployment is a product constraint; actual OS/web server/runtime are **TBD** |

### 1.4 Stack Decision Rule

**SYS-STACK-001** Sebelum implementasi dimulai, engineering harus memeriksa project configuration aktual dan memperbarui versi terverifikasi pada dokumen teknis.

**SYS-STACK-002** Jika project merupakan greenfield project, target stack yang diminta adalah Laravel + PHP + MySQL + Blade + Livewire + Alpine.js + Tailwind CSS, tetapi versi final hanya boleh ditetapkan setelah compatibility verification.

**SYS-STACK-003** Dependency tambahan tidak boleh diperkenalkan jika kemampuan yang sama dapat dipenuhi secara memadai oleh Laravel atau komponen stack yang sudah disetujui.

**SYS-STACK-004** Arsitektur MVP harus menggunakan **modular monolith**, bukan microservices.

---

## 2. System Context

### 2.1 Context Diagram

```text
                        +----------------------+
                        |   Institution Admin  |
                        +----------+-----------+
                                   |
                                   v
+------------+            +--------+---------+           +---------------+
| Instructor |----------->|   LearnFlow LMS  |<----------|    Student    |
+------------+            +--------+---------+           +---------------+
                                   |
                       +-----------+-----------+
                       |                       |
                       v                       v
                +-------------+         +--------------+
                | File Storage|         | Email Service|
                +-------------+         +--------------+
                       |
                       v
                +-------------+
                |   MySQL DB  |
                +-------------+
```

### 2.2 Internal System Boundaries

LearnFlow MVP terdiri dari dua logical areas:

```text
LEARNFLOW
│
├── CORE PLATFORM
│   ├── Authentication
│   ├── Users
│   ├── Roles
│   ├── Permissions
│   ├── Institution Settings
│   ├── Branding
│   ├── Notifications
│   ├── Files
│   ├── Activity Logs
│   └── Dashboard Foundation
│
└── LMS DOMAIN
    ├── Course Categories
    ├── Courses
    ├── Enrollment
    ├── Modules
    ├── Lessons
    ├── Assignments
    ├── Submissions
    ├── Quizzes
    ├── Quiz Attempts
    ├── Gradebook
    ├── Learning Progress
    ├── Announcements
    ├── Discussions
    └── Reports
```

### 2.3 External Dependencies

External services pada MVP harus dibuat seminimal mungkin.

Allowed external dependency categories:

- SMTP/email provider;
- optional object/file storage;
- optional monitoring/backup destination.

Out of MVP:

- payment gateway;
- video conference provider;
- SCORM provider;
- AI provider;
- third-party marketplace;
- SaaS billing;
- SSO provider;
- mobile push service.

---

## 3. Technical Objectives

### TO-001 — Simple Architecture
Sistem harus dapat dijalankan sebagai satu deployable Laravel web application untuk MVP.

### TO-002 — Clear Domain Boundaries
Core platform concern dan LMS domain concern harus dipisahkan secara logis agar perubahan pada satu module tidak secara tidak perlu memengaruhi module lain.

### TO-003 — Secure by Default
Authentication, authorization, validation, file access, grade access, dan audit trail harus diterapkan sebagai behavior sistem, bukan hanya kontrol tampilan.

### TO-004 — Transactional Integrity
Operasi bisnis yang mengubah beberapa data terkait harus bersifat atomik jika partial completion dapat menghasilkan data tidak konsisten.

### TO-005 — Commercial Maintainability
Konfigurasi institusi, branding, dan permission tidak boleh membutuhkan perubahan core source code untuk use case standar.

### TO-006 — VPS Friendly
MVP harus dapat dioperasikan pada deployment VPS standar tanpa kebutuhan microservice infrastructure.

### TO-007 — SaaS Readiness Without Premature Multi-Tenancy
Design tidak boleh menghalangi evolusi ke SaaS, namun tenant isolation dan SaaS billing tidak termasuk MVP.

### TO-008 — Testability
Business rules penting harus dapat diuji secara otomatis dan tidak hanya bergantung pada UI testing.

---

## 4. Functional Requirements

Functional requirements di bagian ini mempertahankan intent `docs/PRD.md`.

### 4.1 Authentication

**SFR-AUTH-001** Sistem harus mengautentikasi hanya user aktif dengan credential valid.

**SFR-AUTH-002** Sistem harus menolak user nonaktif sebelum protected application state diberikan.

**SFR-AUTH-003** Sistem harus menyediakan password reset dengan token yang memiliki masa berlaku.

**SFR-AUTH-004** Token password reset yang sudah berhasil digunakan tidak boleh digunakan ulang.

**SFR-AUTH-005** Logout harus mengakhiri session aktif user.

### 4.2 User Management

**SFR-USER-001** Administrator harus dapat membuat user dengan nama, unique login identifier/email, dan role.

**SFR-USER-002** Sistem harus mencegah duplicate identifier sesuai uniqueness rule deployment.

**SFR-USER-003** User dapat dinonaktifkan tanpa menghapus submission, grades, enrollment history, atau audit history.

**SFR-USER-004** List user harus searchable dan pageable.

### 4.3 Course

**SFR-COURSE-001** Course harus memiliki title, code, category, status, description, dan visibility.

**SFR-COURSE-002** Course `draft` tidak boleh tersedia kepada Student.

**SFR-COURSE-003** Course privat hanya dapat dibuka Student dengan active enrollment.

**SFR-COURSE-004** Sistem harus mendukung satu atau lebih Instructor pada satu Course.

### 4.4 Enrollment

**SFR-ENR-001** Administrator dapat membuat enrollment Student ke Course.

**SFR-ENR-002** Enrollment harus mendukung minimal `active`, `completed`, `suspended`, dan `removed`.

**SFR-ENR-003** Perubahan enrollment harus auditable.

**SFR-ENR-004** Suspended/removed enrollment tidak boleh memperoleh akses baru terhadap protected course activities.

### 4.5 Learning Content

**SFR-CONT-001** Course harus dapat memiliki beberapa Module.

**SFR-CONT-002** Module harus dapat diurutkan.

**SFR-CONT-003** Module harus dapat memiliki beberapa Lesson.

**SFR-CONT-004** Lesson harus mendukung content type minimal text, file/resource, external URL, dan embedded content link.

**SFR-CONT-005** Lesson draft tidak boleh terlihat Student.

### 4.6 Assignment and Submission

**SFR-ASG-001** Instructor yang memiliki scope Course harus dapat membuat Assignment.

**SFR-ASG-002** Assignment harus mendukung title, instruction, optional due date, maximum score, status, dan optional attachment.

**SFR-ASG-003** Student dengan active enrollment dapat membuat Submission sesuai submission mode yang diizinkan.

**SFR-ASG-004** Submission harus menyimpan authoritative server-side timestamp.

**SFR-ASG-005** Late submission harus diberi status/indicator `late` jika terjadi setelah due date dan late submission diperbolehkan.

**SFR-ASG-006** Instructor dapat memberi score dan feedback.

**SFR-ASG-007** Score tidak boleh melebihi maximum score.

**SFR-ASG-008** Grade change harus auditable.

### 4.7 Quiz

**SFR-QUIZ-001** Instructor dapat membuat Quiz pada Course yang dikelolanya.

**SFR-QUIZ-002** Quiz MVP harus mendukung Multiple Choice dan True/False.

**SFR-QUIZ-003** Quiz dapat memiliki attempt limit, optional duration, dan optional availability window.

**SFR-QUIZ-004** Sistem harus menolak attempt yang berada di luar availability window.

**SFR-QUIZ-005** Sistem harus mencegah attempt melebihi limit.

**SFR-QUIZ-006** Sistem harus menghitung skor otomatis berdasarkan question key dan weight.

**SFR-QUIZ-007** Setiap attempt harus memiliki attempt number, start timestamp, submit timestamp, dan final score.

### 4.8 Gradebook

**SFR-GRADE-001** Instructor hanya dapat melihat gradebook Course dalam scope-nya.

**SFR-GRADE-002** Student hanya dapat melihat grade miliknya sendiri.

**SFR-GRADE-003** Administrator dapat melihat gradebook jika permission diberikan.

**SFR-GRADE-004** Unpublished grade tidak boleh terlihat Student jika grade publication control diaktifkan.

### 4.9 Progress

**SFR-PROG-001** Sistem harus menghitung course progress dari lesson yang completion-enabled.

**SFR-PROG-002** Calculated progress harus selalu berada pada rentang 0 sampai 100 persen.

**SFR-PROG-003** Progress harus diperbarui setelah completion state berubah.

### 4.10 Announcement

**SFR-ANN-001** Admin atau Instructor dalam Course scope dapat membuat Announcement.

**SFR-ANN-002** Published announcement hanya tersedia bagi eligible audience.

### 4.11 Discussion

**SFR-DISC-001** Discussion dapat dinonaktifkan per Course.

**SFR-DISC-002** Active enrolled Student dapat membuat thread atau reply saat Discussion aktif.

**SFR-DISC-003** Closed thread tidak boleh menerima reply baru.

### 4.12 Dashboard, Reporting, Search, Import/Export

Requirement detail mengikuti bagian khusus 28–30 dan product dashboard/report requirements dari PRD.

---

## 5. Non-Functional Requirements

### NFR-SYS-001 — Reliability
Request yang berhasil melakukan write harus menghasilkan persistent state yang dapat dibaca kembali.

### NFR-SYS-002 — Authorization Integrity
Tidak boleh ada protected business operation yang hanya mengandalkan hiding UI tanpa server-side authorization.

### NFR-SYS-003 — Responsive UI
Core workflow harus dapat digunakan melalui modern desktop browser serta mobile/tablet browser.

### NFR-SYS-004 — Accessibility
Interactive controls utama harus keyboard reachable dan memiliki accessible naming yang dapat dipahami.

### NFR-SYS-005 — Consistency
Validation, error feedback, table filtering, pagination, form action, dan notification UI harus menggunakan pola yang konsisten.

### NFR-SYS-006 — Operational Simplicity
MVP tidak boleh membutuhkan distributed services untuk beroperasi.

### NFR-SYS-007 — Observability
Application error dan operational event penting harus dapat dilacak melalui logging.

### NFR-SYS-008 — Data Integrity
Foreign references dan business invariants penting harus dijaga oleh application rules dan database constraints saat sesuai.

---

## 6. Application Architecture

### 6.1 Architecture Style

Recommended architecture:

**Laravel Modular Monolith**

```text
Web Browser
    |
    v
Presentation Layer
Blade + Livewire + Alpine.js
    |
    v
Application Layer
Actions / Use Cases / Services
    |
    v
Domain Rules
Policies / Domain Services / Models
    |
    v
Persistence & Infrastructure
Eloquent / Database / Queue / Cache / Storage / Mail
    |
    v
MySQL + File Storage
```

### 6.2 Architectural Rules

**ARCH-001** MVP tidak boleh dipecah menjadi microservices.

**ARCH-002** Controller atau Livewire component tidak boleh menjadi tempat utama business logic kompleks.

**ARCH-003** Business operation yang reusable atau transactional harus dipindahkan ke application/service/action layer.

**ARCH-004** Authorization harus diterapkan melalui policy/gate/capability boundary yang konsisten.

**ARCH-005** Data access sederhana dapat menggunakan Eloquent langsung melalui application/service layer.

**ARCH-006** Repository abstraction hanya digunakan jika ada kebutuhan nyata sebagaimana section 15.

### 6.3 Logical Module Boundaries

```text
Platform
├── Auth
├── User
├── Access Control
├── Institution
├── Settings
├── Files
├── Notifications
└── Audit

Learning
├── Course
├── Enrollment
├── Content
├── Assignment
├── Quiz
├── Grade
├── Progress
├── Announcement
├── Discussion
└── Reporting
```

Module boundary adalah logical application boundary dan tidak mensyaratkan package terpisah pada MVP.

---

## 7. Authentication Requirements

### AUTH-TECH-001
Authentication harus menggunakan mekanisme Laravel-native atau Laravel-first yang sesuai actual project version.

### AUTH-TECH-002
Password harus disimpan menggunakan secure one-way password hashing yang didukung framework.

### AUTH-TECH-003
Authentication response untuk credential invalid tidak boleh mengungkap secara eksplisit apakah akun tertentu ada.

### AUTH-TECH-004
User `inactive` harus gagal melewati authentication authorization flow.

### AUTH-TECH-005
Password reset token harus:

- unique;
- time limited;
- invalid setelah berhasil digunakan.

### AUTH-TECH-006
Successful authentication harus menghasilkan authenticated session.

### AUTH-TECH-007
Authentication event yang relevan dengan audit/security harus dapat dicatat.

### AUTH-TECH-008
MVP tidak membutuhkan OAuth, SSO, social login, passwordless authentication, atau MFA kecuali ditambahkan melalui change request.

---

## 8. Authorization Requirements

### AUTHZ-001
Setiap protected action harus melakukan server-side authorization.

### AUTHZ-002
Authorization harus mempertimbangkan:

1. authenticated user;
2. role/capability;
3. resource ownership atau assignment;
4. Course scope;
5. Enrollment status bila relevant.

### AUTHZ-003
Instructor hanya dapat mengubah resource Course yang ditugaskan, kecuali memiliki explicit permission tambahan.

### AUTHZ-004
Student hanya dapat mengakses Course privat jika active enrollment tersedia.

### AUTHZ-005
Student tidak boleh mengakses grade Student lain walaupun mengetahui identifier resource.

### AUTHZ-006
Audit Log access membutuhkan permission eksplisit.

### AUTHZ-007
Permission denied harus menghasilkan controlled response, bukan data leak.

### AUTHZ-008
Authorization test wajib mencakup direct URL/request access, bukan hanya navigation menu visibility.

---

## 9. User Role Architecture

### 9.1 Standard Roles

MVP role baseline:

- Administrator;
- Instructor;
- Student.

Optional controlled roles:

- Super Administrator;
- Manager/Viewer.

### 9.2 Capability-Oriented Design

Role harus dianggap sebagai kumpulan capability, bukan hard-coded conditional di seluruh aplikasi.

Contoh capability groups:

- `users.manage`;
- `roles.manage`;
- `settings.manage`;
- `courses.manage`;
- `courses.teach`;
- `enrollments.manage`;
- `assignments.manage`;
- `submissions.grade`;
- `quizzes.manage`;
- `grades.view`;
- `reports.view`;
- `audit.view`.

Nama capability final dapat disesuaikan pada implementation design, tetapi behavioral matrix PRD tidak boleh berubah.

### 9.3 Role Rules

**ROLE-TECH-001** Role assignment harus auditable.

**ROLE-TECH-002** Perubahan role tidak boleh menghapus historical data user.

**ROLE-TECH-003** Permission evaluation harus memiliki satu mekanisme konsisten, bukan tersebar sebagai string checks tidak terkontrol.

---

## 10. Session Management

### SESSION-001
Session harus menggunakan server-recognized authenticated session mechanism.

### SESSION-002
Logout harus invalidate authenticated session.

### SESSION-003
Session cookie harus mengikuti secure production settings, termasuk HTTPS-only behavior bila deployment menggunakan HTTPS.

### SESSION-004
CSRF protection harus aktif pada state-changing browser requests.

### SESSION-005
Idle/session lifetime harus configurable melalui environment/application configuration.

### SESSION-006
Sensitive state tidak boleh disimpan di client-side browser storage sebagai sumber kebenaran.

### SESSION-007
Session configuration produksi harus berbeda dari local development bila diperlukan dan harus terdokumentasi.

---

## 11. Database Requirements

### 11.1 Database Platform

Requested target database:

- MySQL 8.4.x.

Actual verified database version:

- **TBD — Requires Environment Verification**.

### 11.2 Data Principles

**DB-001** Database harus menjadi source of truth untuk persistent application state.

**DB-002** Primary entities harus memiliki stable unique identifiers.

**DB-003** Foreign relationships harus memiliki referential rules yang mencegah invalid orphan data.

**DB-004** Soft deletion atau archive behavior digunakan jika destructive delete dapat menghilangkan historical academic data.

**DB-005** Timestamp penting seperti submission time, quiz start/submission time, grade changes, dan audit timestamps harus authoritative dari server.

**DB-006** Schema changes harus dikelola melalui versioned migrations.

**DB-007** Migration yang destructive harus memerlukan explicit review dan backup consideration.

### 11.3 Primary Data Domains

Minimal logical entities:

```text
users
roles
permissions
role assignments
institution settings
course categories
courses
course instructors
enrollments
modules
lessons
lesson completions
assignments
submissions
submission files
quizzes
questions
answer options
quiz attempts
quiz answers
grades / grade records
announcements
discussion threads
discussion replies
notifications
files / file metadata
activity logs
```

Final table design ditentukan pada Database Design document dan tidak boleh mengubah product behavior PRD.

### 11.4 Data Integrity

**DB-INT-001** Duplicate active enrollment untuk Student-Course yang sama harus dicegah jika business model tidak membutuhkan multiple concurrent enrollments.

**DB-INT-002** Grade assignment harus terkait pada valid learner, course/activity, dan grading actor.

**DB-INT-003** Quiz attempt harus terkait kepada Quiz dan eligible Student.

**DB-INT-004** Lesson harus selalu berada di Module yang berada dalam Course yang konsisten.

---

## 12. Validation Strategy

### 12.1 Validation Layers

Validation dibagi menjadi:

1. request/input validation;
2. authorization validation;
3. business rule validation;
4. database integrity validation.

### 12.2 Rules

**VAL-001** Semua external input harus divalidasi sebelum business operation.

**VAL-002** Required field, type, range, format, file size, dan allowed values harus divalidasi server-side.

**VAL-003** Client-side validation dapat digunakan untuk UX, tetapi tidak boleh menjadi satu-satunya validation.

**VAL-004** Score harus berada dalam valid range.

**VAL-005** Attempt limit harus divalidasi sebelum Quiz attempt dibuat.

**VAL-006** Enrollment eligibility harus divalidasi sebelum protected student activity.

**VAL-007** Invalid validation harus menghasilkan field-specific error jika relevan.

**VAL-008** File validation mengikuti Section 22.

---

## 13. Business Logic Strategy

### 13.1 Business Logic Location

Business rules yang memiliki lebih dari satu consumer atau memengaruhi integrity harus berada pada domain/application logic, bukan View.

### 13.2 High-Value Business Rules

Logic khusus harus tersedia untuk:

- user activation;
- course visibility;
- enrollment eligibility;
- lesson completion;
- late assignment status;
- submission acceptance;
- assignment scoring;
- quiz attempt eligibility;
- quiz scoring;
- grade publication;
- progress calculation;
- discussion closure;
- report data visibility;
- retention/archive rules.

### 13.3 Business Rule Testability

**BL-001** Rule yang tercantum sebagai `BR-*` di PRD harus memiliki automated test atau equivalent acceptance coverage.

**BL-002** Business logic tidak boleh bergantung langsung pada rendered HTML.

**BL-003** Calculation seperti quiz score dan course progress harus deterministic untuk input state yang sama.

---

## 14. Service Layer Strategy

### 14.1 Purpose

Service/Application layer digunakan untuk operasi yang:

- melibatkan beberapa model;
- memiliki business rules;
- memerlukan transaction;
- digunakan dari lebih dari satu UI/action;
- menghasilkan side effect seperti notification atau audit.

### 14.2 Candidate Services / Actions

Logical examples:

- CreateUser;
- ChangeUserStatus;
- CreateCourse;
- AssignInstructor;
- EnrollStudent;
- PublishCourse;
- CreateLesson;
- SubmitAssignment;
- GradeSubmission;
- StartQuizAttempt;
- SubmitQuizAttempt;
- CalculateQuizScore;
- RecordLessonCompletion;
- PublishGrade;
- PublishAnnouncement;
- ExportReport.

Ini adalah **responsibility definitions**, bukan requirement nama class.

### 14.3 Rules

**SVC-001** Service harus menerima validated/authorized input.

**SVC-002** Service harus mengembalikan outcome yang dapat ditangani presentation layer.

**SVC-003** Service dengan multiple persistent writes harus mempertimbangkan transaction boundary.

**SVC-004** UI layer tidak boleh mengulang business rule yang sudah menjadi service responsibility.

---

## 15. Repository Strategy if Required

Repository pattern **tidak wajib** pada MVP.

### 15.1 Default Strategy

Gunakan Laravel/Eloquent data access melalui application/service layer selama:

- query sederhana;
- persistence tunggal;
- tidak membutuhkan multiple interchangeable data sources;
- query dapat dipahami dan diuji.

### 15.2 Repository Is Justified When

Repository atau query object dapat digunakan jika:

- report query kompleks dan reusable;
- search query memiliki banyak filter;
- data source akan diganti/diintegrasikan;
- repeated domain query menyebabkan coupling tinggi;
- testability benar-benar membutuhkannya.

### 15.3 Constraints

**REP-ARCH-001** Tidak boleh membuat repository untuk setiap model hanya demi pola arsitektur.

**REP-ARCH-002** Repository tidak boleh sekadar membungkus setiap method Eloquent tanpa memberikan abstraction value.

---

## 16. Transaction Management

### TX-001
Operasi multi-write yang harus konsisten harus dibungkus dalam satu database transaction.

Candidate operations:

- enroll user beserta state terkait;
- submit quiz attempt dan answers;
- calculate/finalize quiz score;
- grade submission plus grade record;
- role/permission change dengan audit entry bila atomic consistency diperlukan;
- archive course dengan state changes terkait.

### TX-002
Transaction tidak boleh mencakup network call eksternal jika dapat dihindari.

### TX-003
Email/notification yang tidak kritikal harus dikirim setelah persistent transaction berhasil.

### TX-004
Jika transaction gagal, partial academic state tidak boleh dianggap berhasil.

### TX-005
UI harus menerima explicit failure response jika transactional operation rollback.

---

## 17. Queue Architecture

### 17.1 Queue Requirement

MVP dapat menggunakan Laravel queue untuk operasi yang tidak harus selesai dalam request-response cycle.

Candidate queued jobs:

- email sending;
- bulk notification;
- CSV import processing bila ukuran data melewati synchronous threshold;
- large export generation;
- scheduled reminder notification;
- optional file post-processing.

### 17.2 Queue Rules

**QUEUE-001** Core write operation seperti assignment submission tidak boleh dianggap berhasil hanya karena queued job berhasil dijadwalkan; persistent core data harus tersimpan lebih dahulu.

**QUEUE-002** Queue job harus safe terhadap retry.

**QUEUE-003** Failed job harus dapat dilacak.

**QUEUE-004** Duplicate retry tidak boleh menyebabkan duplicate notification, grade, enrollment, atau import row bila idempotency relevan.

**QUEUE-005** MVP deployment harus dapat berjalan dengan satu queue worker process; horizontal queue scaling adalah future capability.

### 17.3 Queue Backend

Actual queue backend:

**TBD — Requires Environment Verification and deployment decision.**

Laravel-native supported option harus diprioritaskan sebelum menambah dependency khusus.

---

## 18. Scheduled Jobs

Scheduled tasks hanya digunakan jika ada kebutuhan periodik.

Candidate schedules:

- publish scheduled announcement;
- send upcoming deadline reminders;
- cleanup expired temporary files/tokens;
- retention cleanup sesuai policy;
- backup trigger jika diputuskan pada deployment;
- stale job/operational housekeeping.

### Requirements

**SCH-001** Scheduler harus dapat dijalankan melalui single VPS cron/scheduler entry.

**SCH-002** Scheduled job harus idempotent jika dapat berjalan ulang.

**SCH-003** Job failure harus tercatat dalam logging.

**SCH-004** Time-sensitive job harus menggunakan configured application timezone secara konsisten.

---

## 19. Cache Strategy

### 19.1 Principles

Cache digunakan untuk performance optimization, bukan source of truth.

### 19.2 Candidate Cache Data

- system settings;
- institution branding configuration;
- role/permission lookup;
- frequently reused reference data;
- dashboard aggregate yang mahal jika terbukti perlu.

### 19.3 Rules

**CACHE-001** Application harus tetap benar saat cache kosong.

**CACHE-002** Cache invalidation harus terjadi ketika authoritative data yang dicache berubah.

**CACHE-003** Grade, submission state, quiz attempt eligibility, dan authorization-sensitive state tidak boleh menggunakan stale cache yang dapat menghasilkan akses atau nilai salah.

**CACHE-004** Cache backend actual adalah **TBD — Requires Environment Verification**.

**CACHE-005** Redis tidak wajib untuk MVP kecuali kebutuhan deployment/performance membuktikannya.

---

## 20. Notification Architecture

### 20.1 Channels

MVP wajib:

- in-app notification.

Email notification dapat digunakan untuk event yang disetujui bila email infrastructure dikonfigurasi.

Out of MVP:

- SMS;
- WhatsApp;
- push notification native mobile.

### 20.2 Events

Minimum candidate events:

- assignment published;
- grade published;
- announcement published;
- new assignment submission for Instructor if enabled;
- upcoming deadline if reminder feature enabled.

### 20.3 Requirements

**NOTIF-ARCH-001** Notification harus memiliki recipient, event/type, message payload/reference, created time, dan read/unread state.

**NOTIF-ARCH-002** Recipient harus ditentukan berdasarkan course/enrollment scope.

**NOTIF-ARCH-003** Notification tidak boleh dikirim kepada user yang tidak lagi eligible jika eligibility dievaluasi sebelum dispatch.

**NOTIF-ARCH-004** Non-critical delivery failure tidak boleh rollback academic transaction yang sudah valid.

---

## 21. Email Architecture

### 21.1 Email Use Cases

MVP email dapat mencakup:

- password reset;
- account-related communication jika diaktifkan;
- optional assignment/announcement/grade notifications.

### 21.2 Requirements

**MAIL-001** Mail transport harus configurable melalui environment.

**MAIL-002** Credential mail service tidak boleh disimpan dalam version control.

**MAIL-003** Password reset email adalah transactional email prioritas.

**MAIL-004** Email body tidak boleh memuat secret atau password plaintext.

**MAIL-005** Bulk academic email harus dapat dipindahkan ke queue.

**MAIL-006** Failure pengiriman email non-critical harus tercatat tanpa membatalkan academic write yang sudah sukses.

### 21.3 Provider

SMTP/provider actual:

**TBD — Requires Environment Verification / deployment configuration.**

---

## 22. File Storage

### 22.1 Storage Model

MVP harus mendukung local/private server storage, dengan desain yang dapat berkembang ke S3-compatible storage tanpa mengubah product behavior.

### 22.2 File Categories

- institution logo/favicon;
- course resources;
- lesson attachments/resources;
- assignment attachments;
- student submission files;
- optional user profile image;
- generated exports.

### 22.3 Requirements

**FILE-ARCH-001** Private course/submission file tidak boleh bergantung pada public predictable URL untuk authorization.

**FILE-ARCH-002** Download protected file harus melalui access control yang memastikan user eligible.

**FILE-ARCH-003** Metadata minimal: original name, stored identifier/path, MIME/type, size, uploader, upload timestamp, related resource.

**FILE-ARCH-004** Allowed file type dan maximum size harus configurable per upload context.

**FILE-ARCH-005** File gagal validasi tidak boleh menjadi active resource.

**FILE-ARCH-006** Executable/untrusted content tidak boleh dieksekusi oleh web server sebagai application code.

**FILE-ARCH-007** Export temporary file harus memiliki cleanup policy.

**FILE-ARCH-008** Storage driver actual adalah **TBD — Requires Environment Verification**.

---

## 23. Logging

### 23.1 Application Logging

Logging harus mencakup:

- application errors;
- unexpected exceptions;
- failed integrations;
- queue failures;
- scheduled job failures;
- import/export failures;
- security-relevant operational anomalies.

### 23.2 Requirements

**LOG-001** Production log tidak boleh menampilkan secret credential.

**LOG-002** Sensitive content seperti password dan reset token tidak boleh dicatat.

**LOG-003** Log harus mempunyai timestamp dan severity.

**LOG-004** Log retention dan rotation harus ditentukan pada deployment operations.

**LOG-005** User-facing error message tidak harus sama dengan internal technical log message.

---

## 24. Activity Logging

Activity Logging memenuhi PRD Audit Trail Requirements.

### 24.1 Mandatory Audit Events

- user create/update/deactivate;
- role changes;
- permission changes;
- course create/update/archive;
- enrollment changes;
- grade create/change;
- relevant security/auth events.

### 24.2 Audit Record

Minimal audit record harus menyediakan:

- actor;
- action;
- target type;
- target identifier;
- timestamp;
- readable summary;
- before/after values untuk field kritikal jika layak dan aman.

### 24.3 Requirements

**AUD-ARCH-001** Normal product user tidak boleh mengedit audit record.

**AUD-ARCH-002** Audit view membutuhkan dedicated permission.

**AUD-ARCH-003** Audit record harus tetap dapat diinterpretasi jika actor kemudian dinonaktifkan.

**AUD-ARCH-004** Audit logging failure untuk operasi sangat kritikal harus diperlakukan sesuai documented policy; sistem tidak boleh diam-diam mengklaim audit tersedia jika pencatatan gagal.

---

## 25. Error Handling

### 25.1 Error Categories

- validation errors;
- authentication errors;
- authorization errors;
- not found;
- business rule violations;
- conflict/duplicate operation;
- file upload failure;
- queue/integration failure;
- unexpected server error.

### 25.2 Requirements

**ERR-ARCH-001** Validation errors harus ditampilkan dekat field atau context yang relevan.

**ERR-ARCH-002** Authorization error tidak boleh membocorkan protected data.

**ERR-ARCH-003** Production response tidak boleh menampilkan stack trace kepada end user.

**ERR-ARCH-004** Unexpected server error harus memiliki correlation/log context yang membantu diagnosis.

**ERR-ARCH-005** Duplicate request yang berisiko duplicate data harus dicegah atau safely handled.

**ERR-ARCH-006** Failed assignment submit tidak boleh menghasilkan successful submission state.

**ERR-ARCH-007** Failed quiz finalization tidak boleh menghasilkan partial final grade.

---

## 26. API Requirements

### 26.1 MVP Position

Public REST API **tidak termasuk MVP** berdasarkan PRD Future Development.

### 26.2 Internal Readiness

**API-001** Business logic tidak boleh bergantung secara eksklusif pada Blade HTML sehingga future API dapat menggunakan application services yang sama.

**API-002** Resource identifiers dan permission rules harus konsisten sehingga dapat diekspos melalui API pada future version.

**API-003** Jika internal JSON endpoint dibutuhkan oleh Livewire/frontend, endpoint tersebut tetap harus melalui authentication, authorization, dan validation.

### 26.3 Future API

Future API dapat meliputi:

- users;
- courses;
- enrollments;
- lessons;
- assignments;
- submissions;
- grades;
- reports.

Authentication mechanism future API ditentukan pada roadmap dan tidak diasumsikan pada MVP.

---

## 27. Webhook Requirements if Applicable

Webhook **tidak termasuk MVP**.

### Future requirements

Jika webhook ditambahkan:

**WH-001** Webhook subscription harus configurable dan permission-protected.

**WH-002** Webhook payload tidak boleh membocorkan data di luar event scope.

**WH-003** Delivery harus menggunakan signature atau verification mechanism.

**WH-004** Delivery failure harus retry dengan batas yang terkontrol.

**WH-005** Repeated delivery harus memiliki event identifier untuk idempotent consumer handling.

Candidate future events:

- user.created;
- enrollment.created;
- course.published;
- assignment.submitted;
- grade.published;
- course.completed.

---

## 28. Search Architecture

### 28.1 MVP Search Approach

Gunakan database-backed search/filter sebelum menambah search engine terpisah.

### 28.2 Searchable Resources

- users: name, email/identifier;
- courses: title, code;
- enrollment: course, student, status;
- submissions: status;
- reports: date range dan relevant dimensions.

### 28.3 Requirements

**SEARCH-ARCH-001** Search input harus divalidasi/normalized.

**SEARCH-ARCH-002** Search result harus tetap dibatasi authorization scope.

**SEARCH-ARCH-003** Filter dan search harus dapat digunakan bersama untuk resource yang ditentukan PRD.

**SEARCH-ARCH-004** List besar harus menggunakan pagination.

**SEARCH-ARCH-005** Empty result harus menghasilkan empty state, bukan application error.

**SEARCH-ARCH-006** External search engine seperti Elasticsearch/Meilisearch tidak boleh ditambahkan pada MVP kecuali database search terbukti tidak memenuhi performance requirement.

**SEARCH-ARCH-007** Query yang sering digunakan dan mahal harus dievaluasi dengan index/database optimization sebelum menambah infrastructure baru.

---

## 29. Import/Export

### 29.1 CSV Import

MVP wajib mendukung user import CSV.

### Requirements

**IMP-ARCH-001** System harus menyediakan expected CSV template/schema.

**IMP-ARCH-002** Header file harus divalidasi sebelum row processing.

**IMP-ARCH-003** Setiap row harus divalidasi independen.

**IMP-ARCH-004** Result harus memuat jumlah success, skipped, dan failed.

**IMP-ARCH-005** Failed row harus memberikan reason.

**IMP-ARCH-006** Import besar dapat dipindahkan ke queue berdasarkan configurable threshold.

**IMP-ARCH-007** Re-processing file yang sama tidak boleh menciptakan duplicate user yang melanggar uniqueness rules.

### 29.2 Export

**EXP-ARCH-001** User list dapat diekspor CSV oleh authorized Admin.

**EXP-ARCH-002** Authorized grade/report data dapat diekspor CSV.

**EXP-ARCH-003** Export harus menerapkan filter dan permission scope.

**EXP-ARCH-004** Large export dapat dijalankan asynchronously.

**EXP-ARCH-005** Temporary export file harus mempunyai expiry/cleanup policy.

---

## 30. Reporting Architecture

### 30.1 MVP Reports

1. User Report
2. Enrollment Report
3. Course Activity Report
4. Assignment Submission Report
5. Grade Report
6. Progress Report

### 30.2 Reporting Principles

**REPORT-001** Report query tidak boleh mengubah operational data.

**REPORT-002** Report result harus dibatasi role dan Course scope.

**REPORT-003** Report harus mendukung filter sesuai PRD.

**REPORT-004** Export harus merefleksikan filter yang aktif.

**REPORT-005** Aggregate report harus memiliki definisi metric yang konsisten.

### 30.3 Metric Definitions

- **Active User:** user dengan status active.
- **Active Course:** course yang status/availability-nya dikategorikan aktif sesuai product setting.
- **Submitted:** submission persisted dengan successful submit timestamp.
- **Late:** valid submission timestamp lebih lambat dari due date dan late submission diizinkan.
- **Progress %:** completed completion-enabled lessons / total completion-enabled lessons × 100.
- **Pending Grading:** submission yang valid dan belum memiliki finalized grade.

### 30.4 Reporting Implementation Constraint

Dedicated data warehouse, BI platform, OLAP system, dan event streaming **tidak diperlukan MVP**.

---

## 31. Security Architecture

### 31.1 Security Principles

- least privilege;
- defense in depth;
- secure defaults;
- server-side authorization;
- protected file access;
- safe output rendering;
- secret separation;
- auditability.

### 31.2 Requirements

**SEC-ARCH-001** Authentication-required routes/actions harus protected.

**SEC-ARCH-002** State-changing browser actions harus menggunakan CSRF protection.

**SEC-ARCH-003** Output yang berasal dari untrusted user content harus dirender secara aman.

**SEC-ARCH-004** Query/data access harus menggunakan framework/database mechanisms yang mencegah raw untrusted query concatenation.

**SEC-ARCH-005** File upload harus divalidasi dan disimpan dengan safe generated storage identity.

**SEC-ARCH-006** Protected files harus authorization checked pada access time.

**SEC-ARCH-007** Production harus menggunakan HTTPS.

**SEC-ARCH-008** Secret seperti application key, database password, SMTP password, dan storage credential harus berada di environment/secret configuration, bukan source control.

**SEC-ARCH-009** Password tidak pernah disimpan plaintext.

**SEC-ARCH-010** Reset token tidak boleh dicatat pada log.

**SEC-ARCH-011** Role, permission, enrollment, grade, dan audit actions harus mempunyai explicit authorization coverage.

**SEC-ARCH-012** Rate limiting harus diterapkan pada endpoint authentication/reset atau area lain yang berisiko abuse sesuai capability Laravel actual version.

### 31.3 Security Testing

Security test minimum:

- unauthenticated access;
- role escalation attempt;
- ID/resource enumeration attempt;
- cross-course access;
- cross-student grade access;
- private file access;
- invalid upload;
- CSRF protection;
- reset token invalid/expired/reuse.

---

## 32. Backup Requirements

### 32.1 Scope

Backup minimum harus mempertimbangkan:

- MySQL database;
- private uploaded files;
- institution branding assets;
- deployment configuration yang diperlukan untuk restore, tanpa memasukkan secrets ke backup yang tidak aman.

### 32.2 Requirements

**BKP-001** Production deployment harus memiliki documented backup policy sebelum go-live.

**BKP-002** Database dan uploaded files harus memiliki compatible restore point strategy.

**BKP-003** Backup schedule, retention, encryption, dan off-server destination ditentukan berdasarkan deployment risk.

**BKP-004** Restore procedure harus diuji sebelum production acceptance.

**BKP-005** Backup tidak boleh dianggap berhasil hanya karena job berjalan; outcome harus dapat diverifikasi.

### 32.3 MVP Default

Exact backup tooling:

**TBD — Requires VPS environment verification.**

Laravel-native/shell/database-native capability harus dipertimbangkan sebelum menambah third-party application dependency.

---

## 33. Testing Requirements

### 33.1 Testing Levels

Minimum:

1. unit/business rule tests;
2. feature/application tests;
3. authorization tests;
4. database integration tests;
5. browser/end-to-end test untuk critical journey bila tooling tersedia;
6. UAT terhadap PRD acceptance criteria.

### 33.2 Mandatory Automated Coverage Areas

**TEST-001** Active/inactive login.

**TEST-002** Password reset token rules.

**TEST-003** Role and permission boundaries.

**TEST-004** Course draft/private visibility.

**TEST-005** Enrollment access rules.

**TEST-006** Assignment submission eligibility.

**TEST-007** Late submission behavior.

**TEST-008** Score maximum constraint.

**TEST-009** Quiz availability and attempt limit.

**TEST-010** Automatic quiz scoring.

**TEST-011** Grade ownership/visibility.

**TEST-012** Progress calculation 0–100%.

**TEST-013** Closed discussion behavior.

**TEST-014** Audit events for critical changes.

**TEST-015** CSV import validation.

**TEST-016** Private file authorization.

### 33.3 UAT Critical Journeys

- Admin → create user → create course → assign instructor → enroll student → publish.
- Instructor → create module → lesson → publish.
- Student → access lesson → complete lesson.
- Instructor → assignment → Student submit → Instructor grade → Student view grade.
- Instructor → quiz → Student attempt → auto-score.
- Admin/Instructor → report → filter → export.

### 33.4 Test Data

Test environment harus mempunyai reproducible fixture/demo data untuk:

- Admin;
- Instructor;
- multiple Students;
- active/draft Courses;
- active/suspended Enrollments;
- lessons;
- assignments;
- quizzes;
- grades.

---

## 34. Deployment Requirements

### 34.1 Target

Deployment target:

**VPS**

Actual provider, OS, web server, PHP runtime, process manager, database topology, dan storage strategy:

**TBD — Requires Environment Verification.**

### 34.2 Minimum Deployment Components

Logical requirements:

```text
HTTPS Reverse Proxy / Web Server
        |
        v
Laravel Application Runtime
        |
        +--> Queue Worker
        |
        +--> Scheduler
        |
        +--> MySQL
        |
        +--> File Storage
        |
        +--> SMTP / Mail Provider
```

MySQL dapat berada pada VPS yang sama untuk deployment kecil atau managed/separate host untuk deployment yang membutuhkan separation; pilihan final bukan bagian product behavior.

### 34.3 Requirements

**DEP-001** Production harus menggunakan HTTPS.

**DEP-002** Production environment harus menggunakan production-safe configuration.

**DEP-003** Debug detail tidak boleh ditampilkan kepada end user.

**DEP-004** Queue worker harus dikelola sebagai persistent process jika queue-enabled features aktif.

**DEP-005** Scheduler harus dijalankan secara periodik sesuai Laravel deployment pattern actual version.

**DEP-006** Writable application directories harus terbatas pada yang diperlukan.

**DEP-007** Deployment procedure harus mencakup migration, cache/config refresh yang relevan, dan health verification.

**DEP-008** Deployment harus memiliki rollback/restore procedure untuk release yang gagal.

---

## 35. Environment Configuration

### 35.1 Environment Categories

Minimum:

- local/development;
- testing;
- staging bila tersedia;
- production.

### 35.2 Configurable Values

Environment/configuration harus mencakup secara minimum:

- application environment;
- application URL;
- application secret/key;
- debug flag;
- database connection;
- session configuration;
- cache configuration;
- queue configuration;
- mail configuration;
- filesystem/storage configuration;
- application timezone;
- default locale;
- log channel/level.

### 35.3 Requirements

**ENV-001** Production secrets tidak boleh committed ke source repository.

**ENV-002** `.env` production tidak boleh didistribusikan sebagai bagian public source package.

**ENV-003** `.env.example` atau equivalent harus menjelaskan required keys tanpa real secret.

**ENV-004** Default timezone/locale behavior harus sesuai institution configuration bila product setting menimpanya.

**ENV-005** Missing critical production configuration harus menghasilkan controlled startup/deployment failure, bukan silent invalid state.

---

## 36. Performance Requirements

Requirement ini mengikuti PRD Performance Requirements.

### PERF-SYS-001
Pada production environment yang sesuai target sizing, dashboard umum harus memberikan first meaningful response dalam **≤ 3 detik** pada normal load.

### PERF-SYS-002
Search/list standar harus mengembalikan response dalam **≤ 2 detik** untuk operational dataset target.

### PERF-SYS-003
Non-upload form submit harus menghasilkan successful/error response dalam **≤ 2 detik** pada normal load, tidak termasuk external service latency.

### PERF-SYS-004
Long-running operation harus menunjukkan loading/progress state.

### PERF-SYS-005
Potentially large list harus paginated.

### PERF-SYS-006
Query untuk Dashboard dan Report harus direview untuk N+1 query dan inefficient repeated query.

### PERF-SYS-007
Database indexing harus diterapkan pada identifier, foreign key, frequently filtered field, dan common search field berdasarkan query profile.

### PERF-SYS-008
Performance optimization tidak boleh mengorbankan authorization correctness atau data freshness pada grade/submission/quiz eligibility.

### Performance Test Baseline

Dataset baseline UAT/performance test harus ditetapkan sebelum release. Jika belum tersedia:

**TBD — Requires Product/Deployment Sizing Decision.**

---

## 37. Scalability Requirements

### 37.1 MVP Scalability Principle

Scale vertically first; add infrastructure only when measured need exists.

### 37.2 Requirements

**SCALE-001** Schema tidak boleh mengasumsikan hanya satu Course, Instructor, atau Student.

**SCALE-002** Course harus dapat mempunyai multiple Instructor dan multiple Student.

**SCALE-003** User dapat mempunyai relationship ke multiple Course sesuai role.

**SCALE-004** List dan report harus menggunakan pagination/chunking untuk dataset besar.

**SCALE-005** Queue-enabled workloads harus dapat dipindahkan ke additional worker tanpa mengubah business behavior.

**SCALE-006** File storage design harus dapat berpindah dari local ke S3-compatible storage tanpa mengubah end-user workflow.

**SCALE-007** Cache backend dapat diganti tanpa menjadikan cache source of truth.

**SCALE-008** Multi-tenancy tidak diimplementasikan pada MVP; future tenant boundary harus dianalisis secara eksplisit sebelum SaaS phase.

### 37.3 Not Required for MVP

- Kubernetes;
- service mesh;
- event streaming;
- distributed database;
- read replica;
- sharding;
- multi-region;
- microservices.

---

## 38. Maintainability Requirements

### 38.1 Codebase Principles

**MAINT-001** Framework-native conventions harus diprioritaskan.

**MAINT-002** Business rule tidak boleh tersebar sebagai duplicated condition dalam banyak view/component.

**MAINT-003** Core module responsibility harus terdokumentasi.

**MAINT-004** Naming terminology harus mengikuti product terms: Course, Module, Lesson, Assignment, Submission, Quiz, Grade, Enrollment, Progress.

**MAINT-005** Configuration dan branding standar tidak boleh membutuhkan source code modification.

**MAINT-006** Dependency baru harus memiliki documented justification.

**MAINT-007** Dependency yang tidak lagi digunakan harus dihapus.

**MAINT-008** Database migration harus reversible jika practical dan destructive migration harus explicitly reviewed.

**MAINT-009** Critical business rules harus memiliki automated tests sebelum release.

### 38.2 Documentation

Minimum technical docs future project harus mencakup:

- installation;
- environment configuration;
- local development;
- deployment;
- queue worker;
- scheduler;
- storage;
- backup/restore;
- upgrade;
- module overview;
- role/permission behavior.

---

## 39. Upgrade Strategy

Upgrade strategy sangat penting karena LearnFlow direncanakan dapat dijual sebagai source code.

### 39.1 Versioning

Product releases harus mempunyai version identifier dan release notes.

### 39.2 Database Upgrade

**UPG-001** Schema upgrade harus dilakukan melalui ordered/versioned migrations.

**UPG-002** Release yang memiliki destructive data change harus menyediakan warning dan backup requirement.

**UPG-003** Upgrade tidak boleh silently menghapus academic history.

### 39.3 Source-Code Product Upgrade

**UPG-004** Core customization oleh customer harus diminimalkan melalui settings, themes, configuration, dan extension boundaries.

**UPG-005** Documentation harus membedakan supported configuration dari direct core modification.

**UPG-006** Release notes harus memuat:
- breaking changes;
- migration requirements;
- configuration changes;
- deprecated behavior;
- upgrade steps.

### 39.4 Dependency Upgrades

**UPG-007** Framework/dependency upgrades harus diuji terhadap automated test suite sebelum release.

**UPG-008** Major dependency upgrade tidak boleh dilakukan hanya karena versi terbaru tersedia; harus berdasarkan compatibility, support, security, dan product need.

### 39.5 SaaS Future

Auto-update mechanism dan centralized tenant upgrade adalah future commercial capability, bukan MVP requirement.

---

## 40. Technical Constraints

### 40.1 Product Constraints

**TC-001** `docs/PRD.md` adalah authoritative product requirement.

**TC-002** MVP harus tetap berupa web application.

**TC-003** MVP harus fokus pada asynchronous learning workflow inti.

**TC-004** Multi-tenant SaaS production tidak termasuk MVP.

**TC-005** Payment, marketplace, AI, built-in video conference, SCORM, xAPI, LTI, native mobile app, dan proctoring tidak termasuk MVP.

### 40.2 Architecture Constraints

**TC-006** Architecture harus modular monolith.

**TC-007** Microservices tidak boleh digunakan tanpa requirement baru yang membuktikan kebutuhan.

**TC-008** Laravel-native functionality harus diprioritaskan.

**TC-009** Repository pattern tidak wajib dan tidak boleh digunakan secara mekanis.

**TC-010** Redis, Elasticsearch, Meilisearch, Kafka, RabbitMQ, Kubernetes, atau infrastructure tambahan tidak boleh dianggap mandatory untuk MVP.

### 40.3 Stack Constraints

Requested target:

- Laravel 13.x;
- PHP 8.4.x;
- MySQL 8.4.x;
- Blade;
- Livewire;
- Alpine.js;
- Tailwind CSS;
- VPS deployment.

Namun actual project version status pada saat SRS dibuat:

> **TBD — Requires Environment Verification**

**TC-011** Setelah `composer.json`, runtime PHP, database server, frontend package configuration, dan VPS environment tersedia, versi aktual harus diverifikasi sebelum coding.

**TC-012** Jika target version yang diminta ternyata tidak kompatibel dengan environment/project yang ada, engineering tidak boleh diam-diam mengganti versi. Perbedaan harus dicatat dan diselesaikan sebagai technical decision.

### 40.4 Commercial Constraints

**TC-013** Product harus dapat di-branding tanpa fork source code untuk kebutuhan standar.

**TC-014** Product harus menjaga domain boundaries untuk mengurangi konflik upgrade pada produk source-code.

**TC-015** Custom customer requirement tidak boleh otomatis dimasukkan ke core product tanpa product review.

---

# Appendix A — PRD to SRS Traceability

| PRD Area | SRS Coverage |
|---|---|
| Authentication | Sections 4, 7, 10, 31 |
| Users | Sections 4, 9, 11 |
| Roles/Permissions | Sections 8, 9, 31 |
| Institution/Branding | Sections 1, 6, 11, 38 |
| Course | Sections 4, 11, 13 |
| Enrollment | Sections 4, 11, 13, 16 |
| Modules/Lessons | Sections 4, 11, 13 |
| Assignment/Submission | Sections 4, 13, 16, 22 |
| Quiz | Sections 4, 13, 16 |
| Gradebook | Sections 4, 13, 24 |
| Progress | Sections 4, 13, 30 |
| Announcements | Sections 4, 18, 20 |
| Discussions | Sections 4, 13 |
| Dashboard | Sections 4, 19, 30, 36 |
| Reporting | Section 30 |
| Notification | Sections 20–21 |
| Search/Filter | Section 28 |
| Import/Export | Sections 17, 29 |
| File Upload | Section 22 |
| Audit Trail | Sections 23–24 |
| Security | Sections 7–10, 22, 25, 31 |
| Localization | Section 35 + PRD behavior |
| Performance | Sections 19, 28, 30, 36 |
| Data Retention | Sections 11, 18, 22, 24, 32 |
| Error Handling | Section 25 |
| Acceptance/DoD | Section 33 + PRD acceptance criteria |
| Future API/Webhooks/SaaS | Sections 26–27, 37, 39–40 |

---

# Appendix B — MVP Technical Flow

```text
AUTHENTICATED USER
       |
       v
Role + Permission Check
       |
       +------------------------------------------+
       |                                          |
       v                                          v
ADMIN / INSTRUCTOR                            STUDENT
       |                                          |
       v                                          v
Course Management                           Active Enrollment
       |                                          |
       v                                          v
Content / Assignment / Quiz                 Lesson / Assignment / Quiz
       |                                          |
       +--------------------+---------------------+
                            |
                            v
                    Persistent Domain State
                            |
              +-------------+-------------+
              |                           |
              v                           v
          Audit Log                  Notification
              |                           |
              v                           v
          Reporting                  In-App / Email
```

---

# Appendix C — Pre-Implementation Environment Verification Checklist

Sebelum Cursor atau developer mulai membuat application architecture final, periksa:

- [ ] `composer.json`
- [ ] `composer.lock`
- [ ] `php -v`
- [ ] `php artisan --version` jika project sudah tersedia
- [ ] `package.json`
- [ ] frontend lock file
- [ ] Livewire package version
- [ ] Tailwind package version
- [ ] Alpine.js version/source
- [ ] `mysql --version` atau server version
- [ ] `.env.example`
- [ ] filesystem driver
- [ ] session driver
- [ ] cache driver
- [ ] queue driver
- [ ] mail driver
- [ ] deployment OS
- [ ] web server / reverse proxy
- [ ] PHP process manager
- [ ] cron/scheduler configuration
- [ ] queue process manager
- [ ] HTTPS/TLS configuration
- [ ] backup destination and retention

Setelah pemeriksaan selesai, bagian stack dengan status:

**TBD — Requires Environment Verification**

harus diperbarui menjadi versi dan configuration aktual yang benar.

---

# Final Technical Direction

LearnFlow LMS MVP harus dikembangkan sebagai **Laravel modular monolith** yang mengutamakan Laravel-native functionality, MySQL sebagai persistent source of truth, Blade/Livewire untuk web UI, minimal JavaScript enhancement melalui Alpine.js, dan Tailwind CSS untuk presentation layer setelah seluruh versi aktual diverifikasi.

Arsitektur tidak boleh dibebani microservices, distributed infrastructure, multi-tenancy, advanced integration, atau abstraction layer yang belum dibutuhkan.

Prioritas teknis:

```text
Correctness
    ↓
Security
    ↓
Data Integrity
    ↓
Clear Domain Boundaries
    ↓
Testability
    ↓
Maintainability
    ↓
Performance
    ↓
Scalability
```

Target utamanya adalah menghasilkan satu codebase LearnFlow yang sederhana dioperasikan pada VPS, aman untuk workflow akademik inti, mudah diuji, mudah dikembangkan, dan cukup terstruktur untuk dijual serta di-upgrade berulang kali.
