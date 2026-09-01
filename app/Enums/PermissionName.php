<?php

namespace App\Enums;

enum PermissionName: string
{
    case UsersManage = 'users.manage';
    case RolesManage = 'roles.manage';
    case SettingsManage = 'settings.manage';
    case CoursesManage = 'courses.manage';
    case CoursesTeach = 'courses.teach';
    case EnrollmentsManage = 'enrollments.manage';
    case ReportsView = 'reports.view';
    case AuditView = 'audit.view';
}
