<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;

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

    public function test_user_can_be_notified(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/notify', ['message' => 'Hello, User!']);

        $response->assertJson(['message' => 'Notification sent!']);
    }

    public function test_user_can_be_notified_with_event(): void
    {
        Event::fake();

        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/notify', ['message' => 'Hello, User!']);

        $response->assertJson(['message' => 'Notification sent!']);

        Event::assertDispatched(UserNotificationEvent::class);
    }

    public function test_user_can_be_notified_on_private_channel(): void
    {
        Event::fake();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/notify', ['message' => "Hello, User {$user->id}!"]);

        $response->assertJson(['message' => 'Notification sent!']);

        Event::assertDispatched(UserNotificationEvent::class, function ($e) use ($user) {
            return $e->broadcastOn()->name === "private-notifications.{$user->id}";
        });

        Event::assertNotDispatched(UserNotificationEvent::class, function ($e) use ($user) {
            return $e->broadcastOn()->name === "private-notifications.{$user->id}1";
        });
    }

}
