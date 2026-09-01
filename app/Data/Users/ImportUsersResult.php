<?php

namespace App\Data\Users;

readonly class ImportUsersResult
{
    /**
     * @param  list<array{line: int, email: string}>  $created
     * @param  list<array{line: int, email: string, reason: string}>  $skipped
     * @param  list<array{line: int, email: string, reason: string}>  $failed
     */
    public function __construct(
        public array $created,
        public array $skipped,
        public array $failed,
    ) {}

    public function createdCount(): int
    {
        return count($this->created);
    }

    public function skippedCount(): int
    {
        return count($this->skipped);
    }

    public function failedCount(): int
    {
        return count($this->failed);
    }
}
