<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PlayerMoved;

class GameController extends Controller
{
    /**
     * Broadcast the player's movement.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testBroadcast(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'position' => 'required|array',
            'position.x' => 'required|integer',
            'position.y' => 'required|integer'
        ]);

        $playerId = $validatedData['id'];
        $position = $validatedData['position'];

        // Broadcast the PlayerMoved event
        broadcast(new PlayerMoved($playerId, $position));

        return response()->json(['message' => 'Broadcast test triggered']);
    }
}
