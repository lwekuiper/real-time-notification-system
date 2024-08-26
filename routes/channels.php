<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{userId}', function (User $user, int $userId) {
    return $user->id === $userId;
});
