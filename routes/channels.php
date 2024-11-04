<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Public game channel for broadcasting player movements
Broadcast::channel('game-channel', function () {
    // This is a public channel, so return true to allow all connections
    return true;
});

// Example of a public channel (can be removed if not needed)
Broadcast::channel('public-channel', function () {
    return true;
});

// Example of a private channel (can be removed or modified as needed)
Broadcast::channel('private-channel.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Example of a presence channel (can be removed or modified as needed)
Broadcast::channel('presence-channel', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

// Player-specific move channel (if needed for future extensions)
Broadcast::channel('player-move-channel', function () {
    return true;
});
