<?php

namespace App\Services;

class AvailabilityService
{
    public function update(): void
    {
        auth()->user()->update(['is_available' => !auth()->user()->is_available]);
    }
}