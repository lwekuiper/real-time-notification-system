<?php

use Illuminate\Http\Request;
use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/notify', function (Request $request) {
    $request->validate([
        'message' => 'required|string'
    ]);

    UserNotificationEvent::dispatch($request->user()->id, $request->message);

    return response()->json(['message' => 'Notification sent!']);
})->middleware('auth:sanctum');
