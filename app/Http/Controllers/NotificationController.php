<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notification\NotificationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationController
{
    public function showNotifications(): ResourceCollection
    {
        return NotificationResource::collection(auth()->user()->unreadNotifications);
    }

    public function markAsRead(): int
    {
        auth()->user()->unreadNotifications->markAsRead();

        return auth()->user()->unreadNotifications->count();
    }
}