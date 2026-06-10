<?php

namespace App\Http\Controllers;

use App\Models\EventNews;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, EventNews $event)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->body = $request->content;
        $comment->user_id = Auth::id();
        $comment->event_news_id = $event->id;
        $comment->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'id' => $comment->id,
                'content' => $comment->body,
                'user_id' => strtoupper(substr(md5($comment->user_id), 0, 4)),
                'avatar_url' => Auth::user()->avatar_url,
                'created_at' => $comment->created_at->toIso8601String(),
            ]);
        }

        return back()->with('success', 'Comment added.');
    }
}
