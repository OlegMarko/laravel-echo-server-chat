<?php

namespace App\Http\Controllers\Chat;

use App\Events\PrivateChat;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    /**
     * Get Chat template.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('chat.index');
    }

    /**
     * Send message.
     *
     * @param Request $request
     */
    public function sendMessage(Request $request)
    {
        if ($request->get('body', null)) {

            PrivateChat::dispatch($request->all());
        }
    }

    /**
     * Get room.
     *
     * @param Room $room
     *
     * @return bool
     */
    public function getRoom(Room $room)
    {
        return view('chat.room', [
            'room' => $room,
            'user' => auth()->user()
        ]);
    }
}
