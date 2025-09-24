<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface AvailabilityRepositoryInterface
{
    public static function index(bool|null $is_available): Collection;
}