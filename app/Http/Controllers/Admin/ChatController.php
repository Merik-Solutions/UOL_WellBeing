<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Repositories\interfaces\ChatRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(ChatRepository $repo)
    {
        return view('admin.chats.index', [
            'chats' => $repo->with('doctor', 'user','patient')->get(),
        ]);
    }

    public function show(Chat $chat)
    {
         $cm = $chat->media()->get();
        $m = $chat->messages()->get();

        $final = collect($cm->concat($m)); 
        $final = $final->sortByDesc('created_at');
        
        return view('admin.chats.show', [
            'chat' => $chat,
            'messages' => $final,
            'files' => $chat->getMedia('files'),
        ]);
    }
}
