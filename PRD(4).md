# Product Requirements Document (PRD)
# LearnFlow LMS

---

## 1. Document Information

| Field | Value |
|---|---|
| Document Title | Product Requirements Document — LearnFlow LMS |
| Product Name | LearnFlow LMS |
| Document Type | Product Requirements Document |
| Version | 1.0 |
| Status | Draft for Product Development |
| Business Domain | Education Technology / Learning Management System / E-Learning |
| Target Platform | Web Application |
| Primary Technology Direction | Laravel + MySQL |
| Product Model | Self-Hosted Source Code, SaaS-ready, White-label-ready |
| Primary Target Market | Perguruan tinggi, sekolah, lembaga kursus/pelatihan, lembaga sertifikasi, organisasi pendidikan, dan perusahaan dengan kebutuhan pembelajaran internal |

### 1.1 Document Purpose

Dokumen ini mendefinisikan kebutuhan produk LearnFlow LMS dari sisi perilaku produk, pengguna, ruang lingkup, aturan bisnis, keamanan, kualitas, serta kriteria penerimaan. Dokumen ini menjadi acuan bersama bagi Product, UI/UX, Engineering, QA, dan stakeholder bisnis.

### 1.2 Product Principles

LearnFlow LMS harus:

1. sederhana digunakan oleh administrator, pengajar, dan peserta;
2. mendukung workflow pembelajaran inti tanpa ketergantungan pada banyak aplikasi terpisah;
3. dapat dijual berulang sebagai produk yang dapat dikonfigurasi;
4. mudah di-branding untuk institusi;
5. memiliki struktur role dan permission yang jelas;
6. mendukung perkembangan menuju SaaS tanpa memaksakan kompleksitas multi-tenant pada MVP;
7. memprioritaskan reliability, maintainability, security, dan usability.

---

## 2. Product Overview

LearnFlow LMS adalah platform Learning Management System berbasis web untuk mengelola pembelajaran secara terpusat. Sistem memungkinkan institusi membuat course atau kelas, menunjuk instructor, mendaftarkan peserta, menyusun materi, memberikan tugas dan kuis, menerima submission, melakukan penilaian, berdiskusi, memantau progres, mengirim pengumuman, dan melihat laporan aktivitas pembelajaran.

Produk harus dapat digunakan sebagai:

- LMS institusi pendidikan;
- LMS sekolah;
- LMS kursus dan training center;
- LMS lembaga sertifikasi;
- LMS corporate learning;
- produk source code yang dapat dijual ulang;
- fondasi SaaS LMS pada fase selanjutnya.

---

## 3. Background

Aktivitas pembelajaran digital sering tersebar pada berbagai alat yang tidak terintegrasi, seperti aplikasi pesan, penyimpanan cloud, spreadsheet, formulir online, email, aplikasi video conference, dan dokumen manual.

Dampaknya:

- pengajar harus melakukan pekerjaan administratif berulang;
- peserta harus memantau banyak kanal;
- nilai dan submission tersebar;
- institusi sulit melihat progress pembelajaran secara menyeluruh;
- laporan membutuhkan konsolidasi manual;
- data aktivitas pembelajaran sulit diaudit;
- perubahan course sulit dilacak;
- branding institusi tidak konsisten.

LearnFlow LMS dirancang sebagai pusat aktivitas pembelajaran yang sederhana dan terstruktur.

---

## 4. Problem Statement

Institusi membutuhkan satu platform yang dapat mengelola user, course, materi, tugas, kuis, nilai, diskusi, progres belajar, notifikasi, dan laporan dalam satu workflow.

Tanpa platform terpusat:

1. data pembelajaran tersebar;
2. pengajar menggunakan banyak alat;
3. peserta kehilangan visibilitas terhadap tugas dan deadline;
4. penilaian tidak terdokumentasi konsisten;
5. manajemen kesulitan memperoleh data operasional;
6. administrator sulit mengelola role, enrollment, dan akses;
7. institusi memiliki ketergantungan tinggi terhadap solusi eksternal yang tidak selalu sesuai kebutuhan.

---

## 5. Product Vision

> Menjadi LMS modern, sederhana, modular, dan mudah diadopsi yang memungkinkan institusi memiliki platform pembelajaran terpusat dengan kontrol penuh atas data, branding, workflow, dan pengembangan produk.

---

## 6. Product Objectives

### OBJ-001 — Centralized Learning Operations
Sistem harus memungkinkan aktivitas pembelajaran inti dikelola dalam satu platform.

**Target penerimaan:** course, content, assignment, quiz, submission, grading, progress, announcement, dan basic discussion dapat digunakan tanpa memerlukan aplikasi tambahan untuk workflow asynchronous learning inti.

### OBJ-002 — Reduce Administrative Work
Sistem harus mengurangi pekerjaan administratif manual instructor dan administrator.

**Target penerimaan:** enrollment, submission tracking, quiz scoring otomatis, gradebook, dan progress tracking tersedia dalam sistem.

### OBJ-003 — Improve Learner Visibility
Peserta harus dapat melihat course, lesson, assignment, quiz, deadline, nilai, dan progres dari dashboard.

### OBJ-004 — Improve Institutional Monitoring
Administrator dan pengelola harus dapat melihat aktivitas utama melalui dashboard dan laporan.

### OBJ-005 — Commercial Product Readiness
Produk harus mempunyai konfigurasi branding, role/permission, audit trail, dan pengaturan institusi yang memungkinkan produk dipakai oleh lebih dari satu tipe organisasi tanpa mengubah core product.

---

## 7. Success Metrics

### 7.1 Product Adoption Metrics

| Metric | Target MVP |
|---|---:|
| Administrator dapat membuat course tanpa bantuan teknis | ≥ 90% successful task completion pada UAT |
| Instructor dapat membuat lesson, assignment, dan quiz | ≥ 90% successful task completion |
| Student dapat mengakses lesson dan submit assignment | ≥ 95% successful task completion |
| Waktu median membuat course dasar | ≤ 10 menit setelah user memahami produk |
| Waktu median submit assignment | ≤ 3 menit, tidak termasuk waktu upload |
| Error rate pada workflow inti | < 2% dari transaksi valid pada UAT |

### 7.2 Operational Metrics

- 100% perubahan nilai harus tercatat pada audit trail.
- 100% submission yang berhasil harus memiliki timestamp.
- 100% enrollment aktif harus dapat ditampilkan pada daftar course.
- 100% quiz yang menggunakan soal auto-gradable harus menghasilkan skor sesuai kunci.
- 100% user hanya dapat melihat data yang diizinkan role dan scope-nya.

### 7.3 Quality Metrics

- halaman umum harus memberikan feedback loading atau hasil dalam batas performance requirement;
- error tidak boleh menghilangkan data user yang sudah tersimpan;
- tidak boleh ada akses lintas role yang melanggar permission matrix.

---

## 8. Target Users

1. Administrator LMS
2. Dosen / Guru / Instructor / Trainer
3. Mahasiswa / Siswa / Learner / Peserta Pelatihan
4. Pengelola Program Akademik atau Training
5. Manajemen Institusi
6. IT Administrator atau operator teknis

Prioritas MVP:

1. Administrator
2. Instructor
3. Student

---

## 9. User Personas

### Persona A — LMS Administrator

**Goal**
- mengelola user;
- mengatur role dan permission;
- membuat struktur course;
- melakukan enrollment;
- memantau aktivitas;
- mengelola branding dan settings.

**Success condition**
Administrator dapat melakukan operasi LMS tanpa mengubah source code.

### Persona B — Instructor

**Goal**
- mengelola course yang menjadi tanggung jawabnya;
- membuat module dan lesson;
- membuat assignment;
- membuat quiz;
- menilai submission;
- memberi feedback;
- melihat progres learner.

**Success condition**
Instructor dapat menjalankan pembelajaran harian melalui LearnFlow tanpa spreadsheet tambahan untuk workflow dasar.

### Persona C — Student

**Goal**
- mengakses course;
- membaca materi;
- menyelesaikan lesson;
- mengirim assignment;
- mengerjakan quiz;
- melihat nilai;
- memantau progress;
- menerima announcement.

**Success condition**
Student memahami apa yang harus dikerjakan dan status pembelajarannya dari satu dashboard.

### Persona D — Program Manager

**Goal**
- melihat course aktif;
- mengetahui aktivitas peserta;
- memonitor submission, completion, dan performa dasar;
- memperoleh laporan.

### Persona E — Management Viewer

**Goal**
- memperoleh overview operasional tanpa mengubah data pembelajaran.

---

## 10. User Pain Points

### Administrator

- user dikelola dalam spreadsheet;
- enrollment dilakukan manual dan tidak terdokumentasi;
- role terlalu bergantung pada konfigurasi teknis;
- sulit mengetahui siapa mengubah data;
- laporan tersebar.

### Instructor

- materi tersebar di berbagai layanan;
- sulit mengetahui siswa yang belum submit;
- grading tidak terpusat;
- quiz membutuhkan tool lain;
- feedback kepada learner tidak terdokumentasi rapi.

### Student

- sulit mengetahui deadline;
- terlalu banyak kanal;
- sulit melihat progres;
- materi sulit ditemukan kembali;
- nilai berada di berbagai tempat.

### Management

- laporan lambat;
- tidak memiliki single source of truth;
- sulit melihat course activity dan learner completion.

---

## 11. User Roles

### ROLE-001 — Super Administrator
Memiliki akses penuh terhadap konfigurasi sistem dan seluruh data.

### ROLE-002 — Administrator
Mengelola user, course, enrollment, report, content visibility, dan pengaturan institusi sesuai permission.

### ROLE-003 — Instructor
Mengelola course yang ditugaskan, content, assignment, quiz, submission, grading, announcement, dan diskusi.

### ROLE-004 — Student
Mengakses course yang dienroll, lesson, assignment, quiz, discussion, progress, dan nilai sendiri.

### ROLE-005 — Manager / Viewer
Melihat dashboard dan laporan yang diberikan tanpa mengubah konten akademik.

**MVP minimum role:** Administrator, Instructor, Student.

---

## 12. Product Scope

### In Scope

- authentication;
- user management;
- role dan permission;
- institution profile;
- branding dasar;
- course category;
- course;
- instructor assignment;
- enrollment;
- module;
- lesson;
- file/resource;
- assignment;
- submission;
- feedback;
- quiz;
- auto-grading dasar;
- gradebook;
- progress tracking;
- announcement;
- basic discussion;
- notification;
- dashboard;
- reporting;
- search/filter;
- import/export dasar;
- audit trail;
- security controls;
- localization-ready content structure.

---

## 13. MVP Scope

### MVP-001 — Authentication
User dapat login, logout, reset password, dan mengelola profil dasar.

### MVP-002 — Users
Administrator dapat membuat, melihat, memperbarui, menonaktifkan, dan mencari user.

### MVP-003 — Role & Permission
Akses dibatasi berdasarkan role.

### MVP-004 — Institution Settings
Administrator dapat mengatur nama institusi, logo, favicon, alamat/kontak dasar, dan identitas platform.

### MVP-005 — Course
Administrator dapat membuat course, menetapkan category, status, instructor, dan student.

### MVP-006 — Learning Content
Instructor dapat membuat module dan lesson dalam urutan tertentu.

### MVP-007 — Assignment
Instructor dapat membuat assignment; student dapat submit; instructor dapat memberi score dan feedback.

### MVP-008 — Quiz
Instructor dapat membuat quiz dengan multiple choice dan true/false; sistem dapat menghitung skor otomatis.

### MVP-009 — Gradebook
Instructor dapat melihat nilai learner dalam course; student hanya dapat melihat nilai miliknya.

### MVP-010 — Progress
Student dapat menandai/menyelesaikan lesson sesuai aturan course dan sistem menghitung persentase progress.

### MVP-011 — Announcements
Instructor/admin dapat membuat announcement untuk audience course.

### MVP-012 — Basic Discussion
Student dan instructor dapat membuat/reply thread dalam course jika fitur discussion diaktifkan.

### MVP-013 — Dashboard
Dashboard berbeda berdasarkan role.

### MVP-014 — Reports
Administrator/instructor dapat melihat dan mengekspor report dasar sesuai scope.

### MVP-015 — Audit Trail
Sistem mencatat aktivitas administratif dan perubahan akademik penting.

---

## 14. Out of Scope

Fitur berikut tidak termasuk MVP:

- native Android;
- native iOS;
- video conference built-in;
- live streaming;
- marketplace course;
- instructor commission;
- e-commerce course;
- payment gateway;
- subscription billing;
- multi-tenant SaaS production;
- custom domain tenant;
- SCORM;
- xAPI;
- LTI;
- advanced SSO;
- AI tutor;
- AI grading;
- AI content generator;
- plagiarism detection;
- online proctoring;
- gamification kompleks;
- wallet;
- HR/payroll;
- student finance;
- school accounting;
- parent portal;
- competency framework kompleks;
- certificate automation kompleks;
- advanced attendance;
- learning path kompleks;
- mobile push notification.

---

## 15. Functional Requirements

### 15.1 Authentication

**FR-AUTH-001** Sistem harus memungkinkan user aktif login dengan credential valid.  
**Acceptance:** credential valid membuka dashboard; credential invalid menampilkan pesan generik tanpa mengungkap apakah username/email tersedia.

**FR-AUTH-002** Sistem harus menolak login user nonaktif.  
**Acceptance:** user nonaktif tidak memperoleh session autentikasi.

**FR-AUTH-003** Sistem harus menyediakan password reset melalui mekanisme verifikasi yang valid.  
**Acceptance:** token reset hanya dapat digunakan sesuai masa berlaku.

**FR-AUTH-004** User harus dapat logout dan session aktif harus berakhir.

### 15.2 User Management

**FR-USER-001** Administrator harus dapat membuat user dengan minimum nama, email/login identifier, dan role.

**FR-USER-002** Email/login identifier harus unik dalam satu deployment LearnFlow.

**FR-USER-003** Administrator harus dapat menonaktifkan user tanpa menghapus histori akademiknya.

**FR-USER-004** Sistem harus mempertahankan submission, grade, dan audit log user yang dinonaktifkan.

**FR-USER-005** Administrator harus dapat mencari user berdasarkan nama dan identifier.

### 15.3 Course Management

**FR-COURSE-001** Administrator harus dapat membuat course dengan title, code, category, status, description, dan visibility.

**FR-COURSE-002** Course code harus unik jika konfigurasi institusi mengaktifkan uniqueness.

**FR-COURSE-003** Course hanya dapat diakses student yang memiliki enrollment aktif jika visibility adalah private/enrolled-only.

**FR-COURSE-004** Course draft tidak boleh tampil pada student.

**FR-COURSE-005** Administrator dapat menetapkan satu atau lebih instructor ke course.

### 15.4 Enrollment

**FR-ENR-001** Administrator dapat enroll satu atau lebih student ke course.

**FR-ENR-002** Enrollment harus memiliki status minimal active, completed, suspended, atau removed.

**FR-ENR-003** Student tanpa enrollment aktif tidak boleh mengakses konten course privat.

**FR-ENR-004** Perubahan enrollment harus dicatat pada audit trail.

### 15.5 Module and Lesson

**FR-LESSON-001** Instructor dapat membuat module di course yang ditugaskan.

**FR-LESSON-002** Instructor dapat mengatur urutan module.

**FR-LESSON-003** Instructor dapat membuat lesson di dalam module.

**FR-LESSON-004** Lesson harus mendukung minimal text, file/resource, external URL, atau embedded content link.

**FR-LESSON-005** Lesson draft tidak boleh terlihat oleh student.

**FR-LESSON-006** Student dapat melihat status completed/not completed untuk lesson.

### 15.6 Assignment

**FR-ASG-001** Instructor dapat membuat assignment dengan title, instruction, due date optional, maximum score, status, dan attachment optional.

**FR-ASG-002** Student hanya dapat submit assignment pada course yang enrollment-nya aktif.

**FR-ASG-003** Submission harus menyimpan timestamp.

**FR-ASG-004** Submission dapat berupa text, file, atau kombinasi keduanya sesuai konfigurasi assignment.

**FR-ASG-005** Sistem harus menandai submission setelah due date sebagai late jika late submission diizinkan.

**FR-ASG-006** Instructor dapat memberi score dan feedback.

**FR-ASG-007** Score tidak boleh melebihi maximum score.

**FR-ASG-008** Perubahan score harus dicatat pada audit trail.

### 15.7 Quiz

**FR-QUIZ-001** Instructor dapat membuat quiz dengan title, instruction, status, duration optional, attempt limit, dan availability window optional.

**FR-QUIZ-002** Quiz MVP harus mendukung multiple choice dan true/false.

**FR-QUIZ-003** Instructor dapat menentukan jawaban benar dan bobot score.

**FR-QUIZ-004** Sistem harus menghitung score otomatis berdasarkan jawaban benar.

**FR-QUIZ-005** Student tidak boleh memulai quiz sebelum availability start atau setelah availability end, jika window ditetapkan.

**FR-QUIZ-006** Student tidak boleh melebihi attempt limit.

**FR-QUIZ-007** Sistem harus menyimpan start time, submit time, attempt number, dan final score per attempt.

### 15.8 Gradebook

**FR-GRADE-001** Instructor dapat melihat daftar student dan nilai aktivitas pada course yang ditugaskan.

**FR-GRADE-002** Student hanya dapat melihat nilai miliknya sendiri.

**FR-GRADE-003** Administrator dengan permission terkait dapat melihat seluruh gradebook.

**FR-GRADE-004** Nilai yang belum dipublish tidak boleh ditampilkan ke student jika mode publish approval diaktifkan.

### 15.9 Progress

**FR-PROG-001** Sistem harus menghitung progress course berdasarkan lesson yang completion-enabled.

**FR-PROG-002** Persentase progress harus berada pada rentang 0–100%.

**FR-PROG-003** Student dapat melihat jumlah lesson selesai dibanding total lesson yang dihitung.

### 15.10 Announcements

**FR-ANN-001** Instructor dapat membuat announcement pada course yang ditugaskan.

**FR-ANN-002** Student hanya menerima announcement untuk course yang enrollment-nya aktif.

**FR-ANN-003** Announcement dapat memiliki title, body, publish status, dan publish time.

### 15.11 Discussion

**FR-DISC-001** Discussion dapat diaktifkan/nonaktifkan per course.

**FR-DISC-002** Student yang enrollment-nya aktif dapat membuat thread dan reply jika discussion aktif.

**FR-DISC-003** Instructor/admin dapat menutup thread.

**FR-DISC-004** Thread yang ditutup tidak menerima reply baru.

---

## 16. Non-Functional Requirements

### NFR-001 — Usability
Workflow inti harus dapat diselesaikan tanpa pengetahuan teknis oleh user yang sesuai role.

### NFR-002 — Accessibility
Komponen interaktif utama harus dapat digunakan dengan keyboard dan memiliki label yang dapat dipahami.

### NFR-003 — Reliability
Operasi create/update yang berhasil harus memberikan konfirmasi dan data harus dapat dibaca kembali setelah refresh.

### NFR-004 — Consistency
Komponen dengan fungsi serupa harus mempunyai pola UI dan terminology yang konsisten.

### NFR-005 — Maintainability
Produk harus mendukung konfigurasi institusi dan branding tanpa perubahan source code untuk penggunaan standar.

### NFR-006 — Scalability Readiness
Struktur produk tidak boleh mengasumsikan hanya satu course, satu instructor, atau satu student.

### NFR-007 — Compatibility
UI harus dapat digunakan pada browser desktop modern dan layout responsif untuk tablet/mobile browser.

---

## 17. User Stories

### Administrator

**US-ADM-001** Sebagai administrator, saya ingin membuat user agar instructor dan student dapat menggunakan LMS.

**US-ADM-002** Sebagai administrator, saya ingin menetapkan role agar akses user sesuai tanggung jawab.

**US-ADM-003** Sebagai administrator, saya ingin membuat course agar pembelajaran dapat dikelola terstruktur.

**US-ADM-004** Sebagai administrator, saya ingin enroll student agar mereka dapat mengakses course.

**US-ADM-005** Sebagai administrator, saya ingin melihat laporan aktivitas agar dapat memonitor penggunaan LMS.

### Instructor

**US-INS-001** Sebagai instructor, saya ingin membuat module dan lesson agar materi tersusun berurutan.

**US-INS-002** Sebagai instructor, saya ingin membuat assignment agar student dapat mengirim pekerjaan.

**US-INS-003** Sebagai instructor, saya ingin membuat quiz agar penilaian dapat dilakukan dalam LMS.

**US-INS-004** Sebagai instructor, saya ingin memberi score dan feedback agar student mengetahui hasil pekerjaannya.

**US-INS-005** Sebagai instructor, saya ingin melihat learner progress agar dapat mengetahui peserta yang tertinggal.

### Student

**US-STU-001** Sebagai student, saya ingin melihat course aktif dari dashboard.

**US-STU-002** Sebagai student, saya ingin membuka lesson agar dapat mengikuti materi.

**US-STU-003** Sebagai student, saya ingin melihat deadline assignment agar tidak melewatkan tugas.

**US-STU-004** Sebagai student, saya ingin submit assignment agar pekerjaan saya tercatat.

**US-STU-005** Sebagai student, saya ingin mengerjakan quiz dan melihat hasil sesuai aturan quiz.

**US-STU-006** Sebagai student, saya ingin melihat progress agar mengetahui sejauh mana pembelajaran selesai.

---

## 18. User Journeys

### Journey A — Course Setup

```text
Admin Login
→ Create Course
→ Set Category and Visibility
→ Assign Instructor
→ Enroll Students
→ Publish Course
→ Course Available to Eligible Users
```

**Expected outcome:** course published hanya dapat diakses user yang berhak.

### Journey B — Content Delivery

```text
Instructor Login
→ Open Assigned Course
→ Create Module
→ Create Lesson
→ Add Content
→ Publish Lesson
→ Student Opens Course
→ Student Reads Lesson
→ Student Marks/Completes Lesson
→ Progress Updated
```

### Journey C — Assignment

```text
Instructor Creates Assignment
→ Student Receives Visibility/Notification
→ Student Opens Assignment
→ Student Submits Work
→ System Records Timestamp
→ Instructor Reviews
→ Instructor Scores
→ Instructor Adds Feedback
→ Student Sees Published Result
```

### Journey D — Quiz

```text
Instructor Creates Quiz
→ Add Questions
→ Configure Attempt Rules
→ Publish Quiz
→ Student Starts Attempt
→ Student Answers
→ Student Submits
→ System Auto-Scores
→ Attempt Stored
→ Result Displayed According to Quiz Rule
```

---

## 19. Business Rules

**BR-001** User nonaktif tidak dapat login.

**BR-002** Course draft tidak terlihat oleh student.

**BR-003** Student harus memiliki enrollment aktif untuk course privat.

**BR-004** Instructor hanya dapat mengelola course yang ditugaskan kecuali memiliki permission tambahan.

**BR-005** Student tidak dapat melihat grade user lain.

**BR-006** Score assignment tidak boleh melebihi maximum score.

**BR-007** Quiz attempt tidak boleh melebihi attempt limit.

**BR-008** Submission timestamp tidak boleh diedit oleh student.

**BR-009** Audit log tidak boleh dapat diubah oleh user biasa.

**BR-010** Deaktivasi user tidak boleh menghapus histori akademik.

**BR-011** Penghapusan course yang memiliki activity data harus menggunakan mekanisme archive/controlled deletion sesuai policy.

**BR-012** Student yang enrollment-nya suspended tidak dapat mengakses aktivitas course baru.

---

## 20. Permissions Matrix

| Capability | Admin | Instructor | Student | Manager/Viewer |
|---|:---:|:---:|:---:|:---:|
| Manage system settings | ✓ | — | — | — |
| Manage branding | ✓ | — | — | — |
| Manage users | ✓ | — | — | — |
| Manage roles/permissions | ✓ | — | — | — |
| Create course | ✓ | Optional | — | — |
| Manage assigned course | ✓ | ✓ | — | — |
| Assign instructor | ✓ | — | — | — |
| Enroll student | ✓ | Optional | — | — |
| Create module/lesson | ✓ | ✓ | — | — |
| View published lesson | ✓ | ✓ | ✓ if enrolled | Optional read |
| Create assignment | ✓ | ✓ | — | — |
| Submit assignment | — | — | ✓ | — |
| Grade assignment | ✓ | ✓ | — | — |
| Create quiz | ✓ | ✓ | — | — |
| Attempt quiz | — | — | ✓ | — |
| View own grade | ✓ | ✓ | ✓ | — |
| View course gradebook | ✓ | ✓ assigned | — | Optional read |
| Create announcement | ✓ | ✓ | — | — |
| Participate discussion | ✓ | ✓ | ✓ enrolled | Optional |
| View reports | ✓ | Assigned scope | Own scope | ✓ granted scope |
| View audit log | ✓ | Optional limited | — | Optional read |

---

## 21. Main Modules

### Core Platform Modules

1. Authentication
2. Users
3. Roles
4. Permissions
5. Institution Settings
6. Branding
7. Files
8. Notifications
9. Activity Logs
10. Dashboard Foundation

### LMS Domain Modules

1. Course Categories
2. Courses
3. Enrollment
4. Modules
5. Lessons
6. Assignments
7. Submissions
8. Quizzes
9. Quiz Attempts
10. Gradebook
11. Learning Progress
12. Announcements
13. Discussions
14. Reports

---

## 22. Dashboard Requirements

### Admin Dashboard

**DASH-ADM-001** Menampilkan total user aktif.  
**DASH-ADM-002** Menampilkan jumlah student, instructor, dan course.  
**DASH-ADM-003** Menampilkan jumlah course aktif.  
**DASH-ADM-004** Menampilkan recent administrative/activity events yang diizinkan.  
**DASH-ADM-005** Menampilkan shortcut menuju user, course, enrollment, dan report.

### Instructor Dashboard

**DASH-INS-001** Menampilkan assigned courses.  
**DASH-INS-002** Menampilkan assignment yang memiliki submission belum dinilai.  
**DASH-INS-003** Menampilkan upcoming deadlines dari course yang ditugaskan.  
**DASH-INS-004** Menampilkan recent course activity.

### Student Dashboard

**DASH-STU-001** Menampilkan enrolled active courses.  
**DASH-STU-002** Menampilkan upcoming assignment/quiz deadlines.  
**DASH-STU-003** Menampilkan progress tiap course.  
**DASH-STU-004** Menampilkan recent grades yang sudah dipublish.  
**DASH-STU-005** Menampilkan recent announcements.

---

## 23. Reporting Requirements

### REP-001 — User Report
Admin dapat melihat user berdasarkan role dan status.

### REP-002 — Enrollment Report
Admin dapat melihat enrollment berdasarkan course, student, dan status.

### REP-003 — Course Activity Report
Instructor/admin dapat melihat activity summary course.

### REP-004 — Assignment Submission Report
Instructor dapat melihat student yang submitted, late, atau belum submit.

### REP-005 — Grade Report
Instructor/admin dapat melihat score berdasarkan course dan activity.

### REP-006 — Progress Report
Instructor/admin dapat melihat percentage progress learner dalam course.

### REP-007 — Export
Report yang ditetapkan sebagai exportable harus dapat diekspor ke format CSV pada MVP.

---

## 24. Notification Requirements

### NOTIF-001
Sistem harus memiliki in-app notification minimum.

### NOTIF-002
Notification harus memiliki status read/unread.

### NOTIF-003
Student harus dapat menerima notification untuk assignment yang dipublish jika notification event diaktifkan.

### NOTIF-004
Student harus dapat menerima notification ketika grade dipublish.

### NOTIF-005
Student harus dapat menerima notification untuk announcement course.

### NOTIF-006
Instructor harus dapat menerima notification ketika terdapat submission baru jika event tersebut diaktifkan.

### NOTIF-007
User tidak boleh menerima notification course yang tidak berhubungan dengan enrollment/assignment scope-nya.

---

## 25. Search and Filtering Requirements

### SEARCH-001
User list harus dapat dicari minimal berdasarkan nama dan email/identifier.

### SEARCH-002
Course list harus dapat dicari berdasarkan title atau code.

### SEARCH-003
Course list harus dapat difilter berdasarkan category dan status.

### SEARCH-004
Enrollment list harus dapat difilter berdasarkan course dan status.

### SEARCH-005
Submission list harus dapat difilter berdasarkan submitted/not submitted/late/graded.

### SEARCH-006
Report yang memiliki lebih dari satu periode harus menyediakan date range filter.

### SEARCH-007
Filter yang tidak menghasilkan data harus menampilkan empty state, bukan error.

---

## 26. Import/Export Requirements

### IMP-001
Administrator harus dapat mengimpor user dari file CSV sesuai template resmi.

### IMP-002
Sistem harus memvalidasi header dan data wajib sebelum memproses import.

### IMP-003
Import harus menghasilkan ringkasan successful, skipped, dan failed rows.

### IMP-004
Row gagal harus memberikan alasan yang dapat dipahami.

### EXP-001
Administrator harus dapat mengekspor user list ke CSV.

### EXP-002
Instructor/admin harus dapat mengekspor grade/report yang diizinkan ke CSV.

### EXP-003
Export hanya boleh berisi data yang berada dalam permission scope user.

---

## 27. File Upload Requirements

### FILE-001
File upload hanya dapat dilakukan user yang memiliki permission pada resource terkait.

### FILE-002
Sistem harus memvalidasi ukuran file sebelum file diterima sebagai submission/resource.

### FILE-003
Sistem harus membatasi tipe file berdasarkan konfigurasi upload context.

### FILE-004
File yang gagal divalidasi tidak boleh dianggap sebagai submission berhasil.

### FILE-005
Nama file yang ditampilkan harus aman dan tidak menghasilkan eksekusi script di browser.

### FILE-006
File resource course privat tidak boleh dapat diakses user tanpa otorisasi.

### FILE-007
Sistem harus menyimpan metadata minimum: original filename, size, type, uploader, upload time, dan related resource.

---

## 28. Audit Trail Requirements

### AUDIT-001
Sistem harus mencatat login-related security event yang relevan.

### AUDIT-002
Sistem harus mencatat create/update/deactivate user.

### AUDIT-003
Sistem harus mencatat role/permission changes.

### AUDIT-004
Sistem harus mencatat create/update/archive course.

### AUDIT-005
Sistem harus mencatat enrollment changes.

### AUDIT-006
Sistem harus mencatat grade creation dan grade change.

### AUDIT-007
Audit log harus memiliki actor, action, target, timestamp, dan summary perubahan.

### AUDIT-008
Audit log tidak dapat diedit oleh user melalui fungsi produk normal.

### AUDIT-009
Akses audit log hanya diberikan kepada role dengan permission khusus.

---

## 29. Security Requirements

### SEC-001
Semua halaman yang membutuhkan autentikasi harus menolak anonymous user.

### SEC-002
Semua operasi protected harus melakukan authorization sesuai permission.

### SEC-003
Student tidak boleh dapat mengubah identifier user, score, enrollment, atau audit log melalui UI.

### SEC-004
Password tidak boleh ditampilkan kembali dalam bentuk plaintext.

### SEC-005
Reset password token harus expired dan tidak dapat digunakan kembali setelah sukses.

### SEC-006
Session harus berakhir setelah logout.

### SEC-007
File privat tidak boleh dapat diakses hanya dengan menebak URL.

### SEC-008
Input user harus divalidasi sebelum diproses.

### SEC-009
Rich-text/content output yang berasal dari user harus ditampilkan secara aman.

### SEC-010
Permission denial harus menghasilkan response yang jelas tanpa membocorkan data sensitif.

### SEC-011
Aktivitas perubahan role, permission, user status, enrollment, dan grade harus auditable.

---

## 30. Localization Requirements

### LOC-001
Produk harus mendukung minimal Bahasa Indonesia dan English pada level antarmuka pada roadmap awal.

### LOC-002
Semua label UI yang ditujukan untuk user harus dapat diterjemahkan.

### LOC-003
Format tanggal dan waktu harus dapat mengikuti locale atau konfigurasi institusi.

### LOC-004
Timezone default harus dapat dikonfigurasi.

### LOC-005
Tanggal deadline harus ditampilkan dalam timezone yang konsisten untuk user.

### LOC-006
Konten yang dibuat instructor tidak wajib diterjemahkan otomatis.

---

## 31. Performance Requirements

### PERF-001
Halaman dashboard umum pada beban normal target harus memberikan first meaningful response dalam ≤ 3 detik pada environment produksi yang sesuai spesifikasi deployment.

### PERF-002
Pencarian list standar dengan dataset operasional target harus menampilkan hasil dalam ≤ 2 detik pada kondisi normal.

### PERF-003
Submit form non-upload harus memberikan response berhasil/gagal dalam ≤ 2 detik pada kondisi normal, tidak termasuk layanan eksternal.

### PERF-004
Upload file harus menampilkan progress/loading state jika proses membutuhkan waktu yang terasa oleh user.

### PERF-005
Report besar harus memberikan loading state dan tidak menyebabkan UI terlihat tidak responsif tanpa feedback.

### PERF-006
Pagination wajib digunakan pada data list yang berpotensi besar.

---

## 32. Data Retention Requirements

### RET-001
Deaktivasi user tidak boleh menghapus histori akademik.

### RET-002
Submission dan grade harus dipertahankan selama enrollment/course masih berada dalam periode retention institusi.

### RET-003
Audit log harus dipertahankan sesuai konfigurasi retention policy, dengan default minimum yang ditentukan deployment owner.

### RET-004
Penghapusan permanen data akademik harus memerlukan permission khusus dan confirmation.

### RET-005
Course yang telah selesai harus dapat diarsipkan tanpa menghilangkan data report.

### RET-006
Retention policy harus terdokumentasi pada system settings atau deployment policy.

---

## 33. Error Handling Requirements

### ERR-001
Setiap error validasi form harus menampilkan field yang bermasalah dan pesan yang dapat dipahami.

### ERR-002
User tidak boleh kehilangan input form yang valid hanya karena satu field gagal validasi jika secara UX memungkinkan.

### ERR-003
Error authorization harus menampilkan pesan akses ditolak tanpa membocorkan data.

### ERR-004
Error server harus menampilkan generic user-facing message dan tidak menampilkan stack trace pada production.

### ERR-005
Duplicate action yang berisiko membuat data ganda harus dicegah atau ditangani secara aman.

### ERR-006
Submit assignment yang gagal tidak boleh ditandai sebagai submitted.

### ERR-007
Quiz attempt yang belum berhasil tersimpan tidak boleh ditampilkan sebagai final submitted attempt.

### ERR-008
Import error harus menghasilkan summary per baris.

---

## 34. Acceptance Criteria

MVP diterima apabila seluruh kondisi berikut terpenuhi:

### AC-001 Authentication
Admin, instructor, dan student dapat login dan logout menggunakan account valid.

### AC-002 Authorization
Setiap role hanya dapat membuka menu dan operasi yang diizinkan.

### AC-003 User Management
Admin dapat membuat, mengedit, mencari, dan menonaktifkan user.

### AC-004 Course Setup
Admin dapat membuat course, menetapkan instructor, enroll student, dan publish course.

### AC-005 Lesson Delivery
Instructor dapat membuat module dan lesson; enrolled student dapat mengakses published lesson.

### AC-006 Assignment
Student dapat submit assignment dan instructor dapat memberi score serta feedback.

### AC-007 Quiz
Student dapat mengerjakan quiz sesuai attempt rule dan sistem menghasilkan skor untuk question type auto-gradable.

### AC-008 Gradebook
Instructor dapat melihat gradebook course; student hanya dapat melihat nilai sendiri.

### AC-009 Progress
Student dapat melihat progress 0–100% yang sesuai completion lesson.

### AC-010 Announcement
Announcement yang dipublish pada course tampil kepada audience yang eligible.

### AC-011 Discussion
Student eligible dapat membuat/reply discussion saat fitur aktif.

### AC-012 Dashboard
Dashboard admin, instructor, dan student menampilkan data sesuai role.

### AC-013 Report
Admin/instructor dapat memperoleh report sesuai permission dan mengekspor report yang diizinkan.

### AC-014 Audit
Perubahan user role, enrollment, dan grade menghasilkan audit record.

### AC-015 Security
UAT tidak menemukan unauthorized cross-role access pada flow utama.

---

## 35. Definition of Done

Suatu feature dinyatakan Done apabila:

1. functional requirement terkait telah dipenuhi;
2. acceptance criteria telah lulus;
3. role dan permission telah diuji;
4. validation dan error state telah diuji;
5. empty state telah tersedia jika relevan;
6. responsive behavior telah diperiksa;
7. audit trail tersedia jika aktivitas termasuk kategori auditable;
8. user-facing text dapat dilokalisasi jika termasuk system UI;
9. feature tidak memperkenalkan data exposure di luar scope;
10. dokumentasi penggunaan atau acceptance note telah tersedia;
11. regression test untuk workflow inti tidak gagal;
12. tidak ada blocker severity defect yang terbuka.

---

## 36. Product Risks

### RISK-001 — Feature Creep
**Risk:** LMS mudah berkembang menjadi ERP pendidikan.  
**Mitigation:** semua fitur baru harus diuji terhadap product scope dan roadmap.

### RISK-002 — Permission Complexity
**Risk:** terlalu banyak role akan meningkatkan kompleksitas.  
**Mitigation:** MVP menggunakan tiga role utama dan capability-based permissions.

### RISK-003 — Assessment Complexity
**Risk:** quiz/assessment dapat berkembang menjadi domain sangat kompleks.  
**Mitigation:** MVP dibatasi pada MCQ dan true/false.

### RISK-004 — File Storage Growth
**Risk:** course material dan submission meningkatkan storage cepat.  
**Mitigation:** file policy, quota readiness, dan storage abstraction roadmap.

### RISK-005 — Product Customization Fragmentation
**Risk:** setiap customer meminta perubahan source code unik.  
**Mitigation:** prioritaskan configuration, branding, modules, dan extension points.

### RISK-006 — Upgrade Difficulty
**Risk:** customer source-code memodifikasi core lalu sulit melakukan upgrade.  
**Mitigation:** modular boundaries, release notes, migration discipline, dan customization guidance.

### RISK-007 — Competition
**Risk:** pasar memiliki LMS gratis dan komersial.  
**Mitigation:** positioning pada simplicity, ownership, white-label, deployment, dan maintainability.

### RISK-008 — SaaS Premature Complexity
**Risk:** multi-tenancy terlalu dini meningkatkan biaya development.  
**Mitigation:** MVP single-organization deployment namun SaaS-ready pada product boundaries.

---

## 37. Future Development

### Future Learning Features

- advanced question bank;
- essay/manual quiz grading;
- random question;
- attendance;
- certificates;
- course completion rules;
- prerequisites;
- learning paths;
- badges;
- gamification;
- calendar;
- scheduled activities;
- course duplication;
- course templates;
- advanced analytics.

### Commercial Features

- installation wizard;
- license management;
- module manager;
- theme system;
- advanced white-label;
- backup/restore;
- update mechanism;
- demo data;
- import/export tools;
- documentation portal.

### Integration Features

- REST API;
- webhooks;
- Google authentication;
- Microsoft authentication;
- SSO;
- Zoom/meeting integrations;
- object storage;
- SCORM;
- xAPI;
- LTI.

### SaaS Features

- multi-tenancy;
- tenant provisioning;
- plans;
- subscriptions;
- quotas;
- custom domains;
- SaaS super-admin;
- usage metering;
- billing.

### AI Features

- AI course assistant;
- AI quiz generation;
- AI summary;
- AI feedback assistant;
- AI learning analytics;
- AI learner support assistant.

---

## 38. Version Roadmap

### Version 0.1 — Product Foundation

Scope:

- authentication;
- user management;
- role/permission;
- settings;
- institution profile;
- branding;
- basic audit;
- dashboard shell.

**Exit criteria:** user dan permission flow stabil.

### Version 0.2 — Course Foundation

Scope:

- categories;
- courses;
- instructor assignment;
- enrollment;
- modules;
- lessons;
- course visibility.

**Exit criteria:** admin dapat membuat dan publish course yang dapat diakses enrolled student.

### Version 0.3 — Learning Activities

Scope:

- assignment;
- submission;
- feedback;
- quiz;
- quiz attempt;
- automatic scoring.

**Exit criteria:** instructor dapat menjalankan assignment dan quiz end-to-end.

### Version 0.4 — Evaluation & Progress

Scope:

- gradebook;
- progress tracking;
- announcements;
- notification;
- basic discussion.

**Exit criteria:** student dapat melihat status learning dan instructor dapat menilai.

### Version 0.5 — Reporting & Product Hardening

Scope:

- dashboard refinement;
- reports;
- CSV import/export;
- audit refinement;
- security review;
- error handling;
- performance review;
- localization readiness.

**Exit criteria:** seluruh MVP acceptance criteria lulus.

### Version 1.0 — LearnFlow LMS MVP

Scope:

- complete MVP;
- product documentation;
- installation/deployment documentation;
- sample/demo data;
- UAT;
- release packaging.

**Release criterion:** seluruh Definition of Done dan acceptance criteria MVP terpenuhi.

### Version 1.x — Institution Edition

Potential scope:

- certificates;
- attendance;
- advanced quiz;
- course completion;
- calendar;
- bulk operations;
- advanced report;
- course template.

### Version 2.x — Commercial Platform

Potential scope:

- installation wizard;
- update system;
- modular add-ons;
- themes;
- advanced white-label;
- API;
- integrations.

### Version 3.x — LearnFlow Cloud

Potential scope:

- multi-tenancy;
- tenant management;
- subscriptions;
- plans;
- usage limits;
- custom domains;
- cloud administration.

### Version 4.x — Intelligent Learning Platform

Potential scope:

- optional AI services;
- AI-assisted content creation;
- AI-assisted assessment;
- AI analytics;
- personalized learner support.

---

# Final Product Scope Statement

LearnFlow LMS MVP harus menyediakan satu workflow pembelajaran asynchronous yang lengkap:

```text
Administrator
→ Creates Users
→ Creates Course
→ Assigns Instructor
→ Enrolls Students

Instructor
→ Creates Modules
→ Publishes Lessons
→ Creates Assignments
→ Creates Quizzes
→ Reviews Submissions
→ Publishes Grades

Student
→ Opens Course
→ Learns Lessons
→ Submits Assignments
→ Takes Quizzes
→ Views Grades
→ Tracks Progress

Management/Admin
→ Monitors Dashboard
→ Reviews Reports
→ Audits Important Activities
```

Produk tidak dianggap selesai hanya karena memiliki banyak fitur. Produk dianggap berhasil ketika tiga role utama dapat menjalankan workflow pembelajaran inti dengan sederhana, aman, konsisten, dan tanpa ketergantungan pada banyak aplikasi terpisah.
