# UI/UX DESIGN — LearnFlow LMS

## Document Information

| Field | Value |
|---|---|
| Product | LearnFlow LMS |
| Document | UI/UX Architecture |
| Version | 1.0 |
| Product Type | Commercial SaaS / Self-Hosted LMS |
| Frontend Direction | Blade + Livewire + Alpine.js + Tailwind CSS |
| Primary Roles | Administrator, Instructor, Student |
| Secondary Roles | Program Manager, Management Viewer |
| Design Goal | Professional, simple, responsive, scalable, reusable |

---

# 1. UX Principles

LearnFlow LMS harus terasa seperti produk SaaS profesional: cepat dipahami, konsisten, minim distraksi, dan berorientasi pada task.

## 1.1 Simplicity First

Setiap halaman harus membantu user menyelesaikan satu tujuan utama.

Contoh:

```text
Course List
→ Find Course
→ Open Course
→ Perform Course Task
```

Hindari:

- terlalu banyak card;
- terlalu banyak warna;
- menu bertingkat terlalu dalam;
- informasi dekoratif yang tidak membantu keputusan;
- komponen unik tanpa alasan.

## 1.2 Role-Focused Experience

Navigation dan dashboard harus menyesuaikan role.

Administrator melihat:

- users;
- courses;
- enrollment;
- reports;
- settings.

Instructor melihat:

- assigned courses;
- content;
- assignments;
- quizzes;
- grading;
- progress.

Student melihat:

- enrolled courses;
- lessons;
- assignments;
- quizzes;
- grades;
- progress.

## 1.3 Progressive Disclosure

Tampilkan hal yang paling penting terlebih dahulu.

Contoh Course:

```text
Course Overview

Overview
Content
Assignments
Quizzes
Students
Grades
Discussions
Settings
```

Detail lanjutan tidak perlu tampil pada semua halaman.

## 1.4 Predictability

User harus mengetahui:

- di mana mereka berada;
- apa yang dapat dilakukan;
- apa akibat suatu tindakan;
- bagaimana kembali;
- status data saat ini.

## 1.5 Consistency Over Novelty

Gunakan pola yang sama untuk:

- page header;
- forms;
- tables;
- filters;
- status badges;
- action menus;
- modals;
- notifications;
- empty states.

## 1.6 Fast Feedback

Setiap tindakan harus menghasilkan feedback:

```text
Saving...
Saved
Validation error
Upload progress
Action completed
Action failed
```

## 1.7 Safe Actions

Tindakan destructive atau berisiko harus dibedakan dari tindakan rutin.

Contoh yang membutuhkan confirmation:

- deactivate user;
- suspend enrollment;
- remove enrollment;
- archive course;
- close assignment;
- unpublish grade;
- delete file;
- close discussion.

## 1.8 Responsive by Default

Desktop merupakan primary administration environment.

Student learning flow harus nyaman digunakan di:

- desktop;
- tablet;
- mobile browser.

---

# 2. Application Layout

## 2.1 Desktop Shell

Layout utama:

```text
┌────────────────────────────────────────────────────────────┐
│ Top Bar                                                    │
├────────────────┬───────────────────────────────────────────┤
│                │                                           │
│ Sidebar        │ Page Header                               │
│                │ Breadcrumb / Actions                      │
│                ├───────────────────────────────────────────┤
│                │                                           │
│                │ Main Content                              │
│                │                                           │
│                │                                           │
│                │                                           │
└────────────────┴───────────────────────────────────────────┘
```

### Main Regions

1. Sidebar
2. Top navigation
3. Page header
4. Breadcrumb
5. Main content
6. Context actions
7. Toast layer

## 2.2 Width Behavior

Desktop:

```text
Sidebar: fixed/collapsible
Content: fluid
Maximum readable text width on article/lesson pages
```

Data-heavy pages may use wider content.

Lesson reading pages should use narrower readable width.

## 2.3 Page Header Standard

Every authenticated page should contain:

```text
Breadcrumb
Page Title
Short Description optional

Primary Action
Secondary Actions
```

Example:

```text
Courses / Web Programming

Web Programming
Manage course content, learners, and assessments.

[Preview] [Edit Course]
```

---

# 3. Sidebar Structure

Sidebar is role-aware.

## 3.1 Administrator Sidebar

```text
LearnFlow

Dashboard

ACADEMIC
Courses
Course Categories
Enrollments

PEOPLE
Users
Roles & Permissions

REPORTS
Reports
Activity Logs

SYSTEM
Notifications
Settings
```

Optional future modules should not appear until enabled.

## 3.2 Instructor Sidebar

```text
LearnFlow

Dashboard

TEACHING
My Courses
Assignments
Quizzes
Gradebook

LEARNERS
Students
Progress

COMMUNICATION
Announcements
Discussions

ACCOUNT
Notifications
Profile
```

Where possible, global Instructor navigation should lead to filtered cross-course views.

## 3.3 Student Sidebar

```text
LearnFlow

Dashboard

LEARNING
My Courses
Assignments
Quizzes
Grades
Progress

COMMUNICATION
Announcements
Discussions

ACCOUNT
Notifications
Profile
```

## 3.4 Manager / Viewer Sidebar

```text
Dashboard

MONITORING
Courses
Learner Progress
Reports

ACCOUNT
Notifications
Profile
```

## 3.5 Sidebar Rules

- maximum two hierarchy levels;
- current section highlighted clearly;
- icon + text;
- tooltips when collapsed;
- no hidden critical functions solely behind hover;
- sidebar state may persist per browser/user preference.

---

# 4. Top Navigation

Top navigation should remain minimal.

Recommended elements:

```text
[Sidebar Toggle]

Optional Global Search

                         Notifications
                         Help
                         User Menu
```

## 4.1 User Menu

```text
Profile
Account Settings
Language
Logout
```

Admin-only links should remain in Sidebar, not user menu.

## 4.2 Notification Control

Show:

- unread indicator;
- recent notifications;
- mark as read;
- View All.

Do not show large notification text inside the topbar dropdown.

---

# 5. Mobile Navigation

On mobile:

- desktop sidebar becomes slide-over drawer;
- topbar remains sticky where useful;
- important Student actions should remain easy to reach.

Recommended mobile header:

```text
☰   LearnFlow        🔔   Avatar
```

For Student-facing pages, optional bottom navigation:

```text
Home
Courses
Tasks
Grades
More
```

Do not create separate desktop and mobile information architecture.

The mobile navigation is a compact representation of the same hierarchy.

---

# 6. Page Hierarchy

Application page hierarchy:

```text
Authentication
│
└── Authenticated Application
    │
    ├── Dashboard
    │
    ├── Global Modules
    │
    │   ├── Courses
    │   ├── Users
    │   ├── Reports
    │   └── Settings
    │
    └── Resource Context
        │
        └── Course
            ├── Overview
            ├── Content
            ├── Assignments
            ├── Quizzes
            ├── Students
            ├── Grades
            ├── Announcements
            ├── Discussions
            └── Settings
```

Avoid page depth greater than:

```text
Module → Resource → Sub-resource
```

unless necessary.

---

# 7. Sitemap

```text
/
├── Login
├── Forgot Password
├── Reset Password
│
└── App
    ├── Dashboard
    │
    ├── Courses
    │   ├── Course List
    │   ├── Create Course
    │   └── Course Detail
    │       ├── Overview
    │       ├── Content
    │       │   ├── Modules
    │       │   └── Lessons
    │       ├── Assignments
    │       │   ├── Assignment Detail
    │       │   └── Submissions
    │       ├── Quizzes
    │       │   ├── Quiz Editor
    │       │   └── Attempts
    │       ├── Students
    │       ├── Gradebook
    │       ├── Progress
    │       ├── Announcements
    │       ├── Discussions
    │       └── Settings
    │
    ├── Users
    │   ├── User List
    │   ├── Create User
    │   └── User Detail
    │
    ├── Enrollments
    ├── Reports
    │   ├── Users
    │   ├── Enrollment
    │   ├── Course Activity
    │   ├── Submission
    │   ├── Grade
    │   └── Progress
    │
    ├── Activity Logs
    ├── Notifications
    │
    ├── Settings
    │   ├── Institution
    │   ├── Branding
    │   ├── Localization
    │   ├── Learning Defaults
    │   ├── Notifications
    │   └── File Upload
    │
    └── Profile
```

Routes/pages must be permission-aware.

---

# 8. Dashboard Layout

Dashboard should answer:

```text
What needs my attention?
What happened recently?
What should I do next?
```

Avoid dashboards consisting only of vanity metrics.

## 8.1 Administrator Dashboard

Recommended layout:

```text
┌──────────────────────────────────────────────┐
│ Welcome / Context                   Actions  │
├───────────┬───────────┬───────────┬─────────┤
│ Users     │ Students  │ Courses   │ Active  │
├───────────┴───────────┴───────────┴─────────┤
│ Recent Activity                             │
├───────────────────────┬──────────────────────┤
│ Course Overview       │ Enrollment Overview  │
├───────────────────────┼──────────────────────┤
│ Quick Actions         │ System / Attention   │
└───────────────────────┴──────────────────────┘
```

Quick actions:

- Add User
- Create Course
- Enroll Student
- View Reports

## 8.2 Instructor Dashboard

```text
My Courses
Pending Grading
Upcoming Deadlines
Recent Submissions
Course Progress
Announcements
```

Most prominent CTA:

```text
Continue Teaching
```

or context-specific:

```text
Grade 12 submissions
```

## 8.3 Student Dashboard

```text
Continue Learning
Upcoming Tasks
My Courses
Progress
Recent Grades
Announcements
```

Priority order:

1. deadline;
2. continue learning;
3. progress;
4. latest feedback.

Student dashboard must not feel like an admin dashboard.

---

# 9. Module Navigation

Within a Course, use local navigation.

Desktop:

```text
Web Programming

Overview
Content
Assignments
Quizzes
Students
Grades
Progress
Announcements
Discussions
Settings
```

Mobile:

- horizontal scroll tabs for a small set;
- or "Course Menu" dropdown/drawer for complete set.

Role-aware visibility:

Student Course:

```text
Overview
Content
Assignments
Quizzes
Grades
Progress
Announcements
Discussions
```

Student must not see:

```text
Students
Course Settings
Instructor Management
```

---

# 10. Form Patterns

## 10.1 Form Structure

Forms should use sections.

Example Create Course:

```text
Basic Information
- Title
- Code
- Category
- Description

Access
- Visibility
- Status

Instructor
- Assigned Instructor
```

## 10.2 Label Pattern

Use:

```text
Label
Optional helper text
[Input]
Validation message
```

Never rely on placeholder as label.

## 10.3 Required Fields

Mark required fields consistently.

Recommended:

```text
Course Title *
```

## 10.4 Form Actions

Desktop:

```text
[Cancel]                  [Save Draft] [Save / Publish]
```

Primary action placed consistently on bottom right.

For simple forms:

```text
[Cancel] [Save]
```

## 10.5 Autosave

Do not use autosave for high-risk settings or grades in MVP.

Use explicit Save unless autosave provides clear product value.

## 10.6 Livewire Form Feedback

Expected behavior:

```text
Idle
→ Saving
→ Success / Validation Error
```

Disable duplicate submission while processing.

---

# 11. Table Patterns

Use tables for data management, not decorative content.

Standard structure:

```text
Page Header

Search        Filters                     [Primary Action]

┌──────────────────────────────────────────────┐
│ Name | Status | Related Info | Updated | ⋮  │
├──────────────────────────────────────────────┤
│ ...                                          │
└──────────────────────────────────────────────┘

Showing 1–20 of 154                Pagination
```

## 11.1 Table Rules

- first column usually resource identity;
- status near identity;
- actions at final column;
- row click may open detail only if it does not conflict with selection/actions;
- long text truncated;
- dates formatted consistently;
- mobile switches to stacked rows/cards only where table becomes unusable.

## 11.2 Row Actions

Recommended:

```text
View
Edit
Deactivate
```

Destructive action visually separated.

## 11.3 Bulk Selection

Only add bulk selection when actual workflow needs it.

Good uses:

- user bulk status;
- enrollment bulk action;
- bulk import-related management.

Do not add bulk action to every table.

---

# 12. Filter Patterns

Filters should appear only when they materially reduce data.

Example Course filters:

```text
Status
Category
Instructor
```

Example Submission filters:

```text
Status
Submitted
Late
Graded
```

## 12.1 Desktop

Use toolbar or filter drawer depending on count.

```text
Search | Status ▼ | Category ▼ | More Filters
```

## 12.2 Mobile

Use:

```text
[Search]
[Filters (2)]
```

Opening a bottom sheet/drawer.

## 12.3 Active Filters

Show removable chips:

```text
Status: Published ×
Category: Programming ×
Clear All
```

---

# 13. Search Patterns

Search must be predictable and scoped.

Examples:

```text
Search users...
Search courses...
Search students...
```

Do not use one global search to pretend all modules are searchable unless global search is actually implemented.

## 13.1 Search Behavior

- debounce where Livewire use is appropriate;
- show loading indicator;
- preserve filter state;
- empty state on no results;
- allow clear button.

## 13.2 Global Search

Optional, not required for MVP.

If implemented later:

```text
Courses
Users
Lessons
Assignments
```

must respect permissions.

---

# 14. Modal Usage

Use modal only for focused, short interactions.

Good modal use:

- confirmation;
- assign instructor;
- enroll student;
- change status;
- quick preview;
- simple metadata edit.

Avoid modal for:

- large Course forms;
- Quiz editor;
- full Lesson editor;
- long settings pages;
- grading detailed Submission.

Large workflows should use dedicated pages or drawers.

---

# 15. Toast / Notification Behavior

Toast is for short action feedback.

Examples:

```text
Course saved.
User created.
Enrollment updated.
Grade published.
```

Error example:

```text
Unable to save changes. Please review the form.
```

## Rules

- success toast disappears automatically;
- critical error remains long enough to read;
- toast should not be the only location for field validation errors;
- no more than a small stack visible at once;
- repeated Livewire events must not produce duplicate toast spam.

---

# 16. Empty States

Every major list needs an intentional empty state.

## Good Empty State

```text
No courses yet

Create your first course to start organizing
lessons, assignments, and learners.

[Create Course]
```

## Search Empty State

```text
No courses match your filters.

Try changing the search term or filters.

[Clear Filters]
```

## Student Empty State

```text
No active courses

You are not enrolled in an active course yet.
```

Do not show irrelevant CTA to users without permission.

---

# 17. Loading States

Loading patterns:

## Page Loading

Use content skeletons for meaningful page regions.

## Table Refresh

Retain table dimensions and show subtle loading state.

## Button Processing

```text
Save
→ Saving...
```

Button becomes disabled.

## File Upload

Show:

- filename;
- progress;
- upload status;
- remove/cancel where supported.

## Report Generation

Small report:

```text
Loading report...
```

Large export:

```text
Preparing export...
```

with eventual completion notification if asynchronous.

Avoid full-screen spinners for minor Livewire operations.

---

# 18. Error States

## Validation Error

Inline field error.

```text
Maximum score must be greater than or equal to 0.
```

## Authorization Error

```text
You don't have permission to access this page.
```

Do not expose resource details.

## Not Found

```text
This resource could not be found.
```

## Server Error

```text
Something went wrong.
Please try again.
```

Provide retry/navigation options where reasonable.

## Network / Livewire Error

Provide visible indication and safe retry behavior.

Never silently discard user-entered data.

---

# 19. Confirmation Dialogs

Confirmation dialog required for actions such as:

- deactivate user;
- remove/suspend enrollment;
- archive Course;
- close Assignment;
- unpublish Course;
- close Discussion;
- withdraw Grade publication;
- remove attachment.

Standard:

```text
Archive course?

Students will no longer use this course as an
active learning course. Historical records will remain.

[Cancel] [Archive Course]
```

Danger actions should name the resource/action explicitly.

Avoid generic:

```text
Are you sure?
```

without context.

---

# 20. Responsive Behavior

## Breakpoint Philosophy

Use Tailwind responsive system, but UX decisions must not depend on arbitrary device names.

### Large screens

- persistent sidebar;
- wide tables;
- 2–4 column dashboard grids.

### Medium screens

- collapsible sidebar;
- 2-column dashboard;
- tables may scroll horizontally.

### Small screens

- drawer navigation;
- 1-column dashboard;
- filters in drawer;
- forms full-width;
- tables converted selectively to stacked rows;
- sticky primary action only where beneficial.

## Student Lesson Reading

Mobile lesson view should prioritize:

```text
Title
Progress
Content
Previous / Next Lesson
```

Administrative metadata should not dominate.

---

# 21. Accessibility Requirements

Target baseline:

**WCAG 2.1 AA-oriented design behavior** where practical for MVP.

Requirements:

- sufficient text/background contrast;
- visible focus states;
- accessible form labels;
- keyboard-operable menus;
- modal focus trapping;
- meaningful button text;
- icon-only buttons require accessible names;
- validation associated with fields;
- semantic headings;
- table header semantics;
- no information conveyed only by color;
- status badges include text;
- interactive elements have reasonable hit area.

Do not remove browser focus outline without replacing it with an accessible visible focus style.

---

# 22. Keyboard Navigation

Keyboard flow must support major tasks.

Expected:

```text
Tab
Shift + Tab
Enter
Space
Escape
Arrow keys where component convention requires
```

## Rules

- sidebar links focusable;
- dropdown menus keyboard accessible;
- modal opens with focus inside;
- Escape closes dismissible modal/dropdown;
- focus returns to triggering element after modal closes;
- table action menus navigable;
- file upload can be triggered using keyboard.

Global keyboard shortcuts are not required for MVP.

---

# 23. Design Consistency Rules

## 23.1 Typography

Recommended hierarchy:

```text
Page Title
Section Title
Card Title
Body
Secondary Text
Caption
```

Do not create many arbitrary font sizes.

## 23.2 Spacing

Use Tailwind spacing scale consistently.

Prefer:

```text
4 / 6 / 8 spacing rhythm
```

for major components.

## 23.3 Cards

Use cards only to visually group related content.

Do not wrap every page element in nested cards.

## 23.4 Border and Shadow

Professional SaaS default:

- subtle borders;
- minimal shadow;
- stronger elevation only for modal/dropdown.

## 23.5 Status Badges

Consistent badge vocabulary:

```text
Active
Inactive
Draft
Published
Archived
Completed
Suspended
Removed
Open
Closed
Late
Graded
```

Color is secondary to text.

## 23.6 Icons

Use one icon family consistently.

Icons support labels; they should not replace unclear labels.

## 23.7 Primary Action

Each page should normally have one visually dominant primary action.

---

# 24. CRUD Page Standards

CRUD modules should share predictable structures.

## 24.1 Index Page

```text
Breadcrumb
Title + description
Primary Action

Search / Filters

Table/List

Pagination
```

## 24.2 Create Page

```text
Breadcrumb
Create [Resource]

Form Sections

Cancel
Create / Save
```

## 24.3 Edit Page

```text
Breadcrumb
Edit [Resource]

Current Status
Form

Cancel
Save Changes
```

## 24.4 Delete / Archive

Prefer:

- deactivate;
- archive;
- close;
- remove relationship;

over hard Delete when history matters.

## 24.5 Examples

User:

```text
Users
→ Add User
→ User Detail
→ Edit User
→ Deactivate
```

Course:

```text
Courses
→ Create Course
→ Course Detail
→ Edit Course
→ Publish
→ Archive
```

---

# 25. Detail Page Standards

Detail pages should answer:

```text
What is this?
What is its current state?
What can I do?
What related information matters?
```

Standard:

```text
Breadcrumb

Resource Name
Status badge
Metadata
Primary Actions

Tabs / Local Navigation

Main Content
```

## 25.1 User Detail

Recommended tabs:

```text
Overview
Courses
Activity
Access
```

depending on permission.

## 25.2 Course Detail

```text
Overview
Content
Assignments
Quizzes
Students
Grades
Progress
Announcements
Discussions
Settings
```

## 25.3 Assignment Detail

Instructor:

```text
Overview
Submissions
Grades
Settings
```

Student:

```text
Instructions
Submission
Feedback / Grade
```

Do not expose Instructor-oriented tabs to Student.

---

# 26. Settings Pages

Settings should be divided by domain.

Recommended:

```text
Settings
├── Institution
├── Branding
├── Localization
├── Learning Defaults
├── Notifications
└── File Upload
```

## 26.1 Settings Layout

Desktop:

```text
Settings Navigation | Settings Content
```

Mobile:

```text
Settings List
→ Settings Detail
```

## 26.2 Save Behavior

Each settings section should save independently where reasonable.

Avoid one enormous Settings form.

## 26.3 Sensitive Settings

Infrastructure secrets are not normal product settings.

Do not expose:

- database password;
- application key;
- SMTP secret;

inside ordinary institution UI unless a future secure deployment-management feature explicitly requires it.

---

# 27. Profile Pages

User profile should remain focused.

## Profile Sections

```text
Personal Information
Account
Language / Locale
Password
```

Optional:

- profile photo.

Student profile should not expose internal role-management controls.

## Account Rules

User may edit:

- display name if allowed;
- locale;
- password;
- profile image.

User may not edit:

- role;
- Enrollment;
- Grade;
- system permissions.

---

# 28. Authentication Pages

Authentication pages should be visually clean and branded.

## 28.1 Login Layout

```text
┌───────────────────────────────────────────┐
│                                           │
│              Institution Logo             │
│                                           │
│              Welcome back                 │
│                                           │
│  Email                                    │
│  [____________________________]           │
│                                           │
│  Password                                 │
│  [____________________________]           │
│                                           │
│  [ Sign In ]                              │
│                                           │
│  Forgot password?                         │
│                                           │
└───────────────────────────────────────────┘
```

## 28.2 Forgot Password

Single purpose:

```text
Email
[Send Reset Link]
```

## 28.3 Reset Password

```text
New Password
Confirm Password
[Reset Password]
```

## 28.4 Authentication UX Rules

- no unnecessary marketing carousel;
- show institution branding;
- clear credential errors;
- preserve email after validation error where safe;
- password show/hide control;
- keyboard accessible;
- responsive.

Public self-registration is not required for MVP.

---

# 29. Public Pages

LearnFlow MVP is primarily an authenticated application.

Recommended minimal public surfaces:

```text
Login
Forgot Password
Reset Password
Optional Maintenance Page
Optional Access Denied / Error Pages
```

A public Course catalog, marketing site, marketplace, and public registration are outside MVP unless separately approved.

If the commercial package includes a marketing website later, it should remain visually aligned but logically separate from LMS application navigation.

---

# 30. Demo Mode Considerations

Commercial source-code products benefit from a safe public demo.

Demo mode should be designed as a controlled product mode, not a random collection of disabled buttons.

## 30.1 Demo Roles

Provide demo accounts such as:

```text
Administrator Demo
Instructor Demo
Student Demo
```

## 30.2 Demo Data

Seed realistic but fictional data:

- institution;
- instructors;
- students;
- courses;
- modules;
- lessons;
- assignments;
- submissions;
- quizzes;
- grades;
- progress;
- announcements.

## 30.3 Protected Demo Actions

In public demo environment, block or neutralize actions that could break the shared demo:

- changing critical admin credentials;
- changing system secrets;
- deleting core demo users;
- destructive Course removal;
- changing permanent product configuration;
- uploading unsafe/unbounded files.

## 30.4 Demo Feedback

When blocked:

```text
This action is disabled in demo mode.
```

Do not pretend the action succeeded.

## 30.5 Demo Reset

Public demo environment may reset data periodically.

The UI should communicate this:

```text
Demo data is periodically restored.
```

## 30.6 Source-Code Customer Installation

Demo mode must be disableable.

Customer production installation must not carry:

- public demo restrictions;
- demo credentials;
- sample passwords;
- public test users.

---

# Appendix A — Role-Based Navigation Matrix

| Page / Module | Admin | Instructor | Student | Manager |
|---|:---:|:---:|:---:|:---:|
| Dashboard | ✓ | ✓ | ✓ | ✓ |
| All Courses | ✓ | Scoped | Enrolled | Read scope |
| Course Categories | ✓ | — | — | Optional |
| Users | ✓ | Limited if future | — | — |
| Roles & Permissions | ✓ | — | — | — |
| Enrollment | ✓ | Optional scoped | — | Read |
| Course Content Authoring | ✓ | Assigned | — | — |
| Course Content Learning | ✓ | ✓ | Enrolled | Read optional |
| Assignments Management | ✓ | Assigned | — | Read optional |
| Assignment Submission | — | — | ✓ | — |
| Quiz Management | ✓ | Assigned | — | — |
| Quiz Attempt | — | — | ✓ | — |
| Gradebook | ✓ | Assigned | Own grades | Read scope |
| Progress | ✓ | Assigned | Own | Read scope |
| Announcements | ✓ | Assigned | Read | Read |
| Discussions | ✓ | Assigned | Participate | Read optional |
| Reports | ✓ | Scoped | — | ✓ |
| Activity Logs | ✓ | Optional | — | Optional |
| Settings | ✓ | — | — | — |
| Profile | ✓ | ✓ | ✓ | ✓ |

---

# Appendix B — Course UI Architecture

```text
COURSE PAGE
│
├── Header
│   ├── Course title
│   ├── Code
│   ├── Status
│   └── Primary actions
│
├── Local Navigation
│
├── Overview
│   ├── Course summary
│   ├── Instructor
│   ├── Enrollment count
│   ├── Progress summary
│   └── Upcoming activities
│
├── Content
│   ├── Module 1
│   │   ├── Lesson
│   │   └── Lesson
│   └── Module 2
│
├── Assignments
├── Quizzes
├── Students
├── Gradebook
├── Progress
├── Announcements
├── Discussions
└── Settings
```

---

# Appendix C — Student Learning Page

Recommended lesson view:

```text
┌────────────────────────────────────────────┐
│ Course / Module                            │
│ Lesson Title                               │
│ Progress: 6 of 10                          │
├────────────────────────────────────────────┤
│                                            │
│ Lesson Content                             │
│                                            │
│ Text / Resource / Embed                    │
│                                            │
├────────────────────────────────────────────┤
│ Previous              Mark Complete / Next │
└────────────────────────────────────────────┘
```

Desktop may display Course content outline beside content.

Mobile should prioritize content before outline.

---

# Appendix D — Instructor Grading View

```text
Assignment: Final Project

Search Student
Filter: Pending / Graded / Late

Student List                 Submission Detail
──────────────────          ─────────────────────
Alya       Pending   →      Submitted: ...
Budi       Late             Files: ...
Citra      Graded           Text: ...

                            Score
                            [ 85 / 100 ]

                            Feedback
                            [...................]

                            [Save] [Publish Grade]
```

The grading flow should minimize navigation between Student submissions.

---

# Appendix E — Visual Product Character

LearnFlow should visually communicate:

```text
Professional
Calm
Structured
Trustworthy
Modern
Academic
Commercial
```

Avoid:

```text
Overly playful gamification
Excessive gradients
Large decorative illustrations on operational pages
Dense enterprise dashboard clutter
Too many accent colors
Excessive animation
```

Motion should primarily communicate:

- state change;
- loading;
- opening/closing;
- success;
- navigation context.

---

# Final UI/UX Direction

LearnFlow LMS should feel like a professional SaaS application rather than a traditional dense academic portal.

The core visual hierarchy is:

```text
Navigation
→ Context
→ Primary Task
→ Supporting Information
→ Feedback
```

The experience should make the three primary roles immediately understand:

```text
ADMIN
What must I manage?

INSTRUCTOR
What must I teach or grade?

STUDENT
What must I learn or submit?
```

Every UI decision should preserve simplicity, predictable navigation, accessible interaction, and reusable component patterns suitable for Blade, Livewire, Alpine.js, and Tailwind CSS.
