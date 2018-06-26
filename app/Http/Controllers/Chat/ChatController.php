<?php

namespace App\Http\Controllers\Chat;

use App\Events\Message;
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

    public function sendMessage(Request $request)
    {
        if ($request->get('body', null)) {

            Message::dispatch($request->all());
        }
    }
}
