<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public static function index(string $status, string $text, int|null $userId): Collection;
}