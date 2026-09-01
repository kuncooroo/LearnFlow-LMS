<?php

namespace App\Data\Users;

use App\Enums\RoleName;
use App\Enums\UserStatus;

readonly class ImportUserRow
{
    public function __construct(
        public int $lineNumber,
        public string $name,
        public string $email,
        public ?string $password,
        public UserStatus $status,
        public RoleName $role,
    ) {}
}
