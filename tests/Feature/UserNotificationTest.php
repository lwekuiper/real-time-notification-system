<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Event;

class UserNotificationTest extends TestCase
{
    public function test_user_notification_event_is_dispatched(): void
    {
        Event::fake();

        UserNotificationEvent::dispatch(1, 'Hello, User 1!');

        Event::assertDispatched(UserNotificationEvent::class);
    }

    public function test_user_notification_event_is_dispatched_on_private_channel(): void
    {
        Event::fake();

        $userId = 1;

        UserNotificationEvent::dispatch($userId, "Hello, User $userId!");

        Event::assertDispatched(UserNotificationEvent::class, function ($e) use ($userId) {
            return $e->broadcastOn()->name === "private-notifications.$userId";
        });
    }

    public function test_user_notification_event_is_broadcasted_with_data(): void
    {
        Event::fake();

        $userId = 1;
        $message = "Hello, User $userId!";

        UserNotificationEvent::dispatch($userId, $message);

        Event::assertDispatched(UserNotificationEvent::class, function ($e) use ($message) {
            return $e->broadcastWith()['message'] === $message &&
                $e->broadcastWith()['timestamp'] === now()->toDateTimeString();
        });
    }

}
