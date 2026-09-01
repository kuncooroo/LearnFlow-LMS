# TASK-006: File Storage Foundation

**Roadmap phase:** Phase 3 — Core Master Data (Files)
**Estimated focus:** One focused feature

## Task ID

TASK-006

## Title

File Storage Foundation

## Objective

Implement centralized file metadata, validated upload/storage, and authorized private/public file access.

## Background

SYSTEM_DESIGN file flow and DATABASE `files` table. Protected academic files are private-by-default. Never trust original filenames as storage keys.

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
- TASK-002
- TASK-004 (FilePolicy)

## Files likely affected

```text
database/migrations/*_files*
app/Models/File.php
app/Services/Files/FileStorageService.php
app/Http/Controllers/Shared/FileDownloadController.php
app/Policies/FilePolicy.php
app/Actions/Files/*
tests/Feature/Files/*
```

## Database changes

- `files` metadata table (disk, path/key, original name, mime, size, visibility, uploader, timestamps).
- No binary blobs in MySQL.

## Backend requirements

- Upload API/service: validate MIME/size/context, store generated key, persist metadata.
- Authorized download/stream for private files.
- Soft-delete/purge hooks later; foundation supports relation from lessons/submissions.

## Frontend requirements

- Reusable upload input component (Blade/Livewire)
- Safe error messages for invalid files
- Download links that go through authorized route (not raw public URLs for private files)

## Validation rules

- Max size
- Allowed MIME/extensions per context
- Reject executable/script uploads
- Context required (e.g. lesson resource vs submission)

## Authorization rules

- Upload only if user can modify parent resource
- Download only if policy allows parent resource access
- Guests denied private files

## Business rules

- Private academic files not permanently publicly URL-addressable
- Metadata is source for access checks

## Edge cases

- Missing file on disk after DB row
- Oversized upload
- MIME spoof attempts

## Security considerations

- Generated storage filenames
- Private disk default for academic
- No PHP execution in storage
- Authorize before stream

## Testing requirements

- Valid upload
- Invalid MIME/size
- Unauthorized download denied
- Authorized download succeeds
- Private file not exposed publicly

## Acceptance criteria

- [ ] File metadata persisted
- [ ] Private download authorized
- [ ] Validation rejects dangerous uploads
- [ ] Service reusable by later modules

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
