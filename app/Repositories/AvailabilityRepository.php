<?php

namespace App\Repositories;

use App\Interfaces\AvailabilityRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    public static function index(bool $is_available = null): Collection
    {
        return User::query()->with('roles')->role('user')
            ->when($is_available !== null, fn($query) => $query->where('is_available', $is_available))
            ->get();
    }
}