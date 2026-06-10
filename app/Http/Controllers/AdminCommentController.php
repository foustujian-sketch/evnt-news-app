<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Comment::with(['user', 'eventNews']);

        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $totalComments = \App\Models\Comment::count();
        $comments = $query->orderBy('created_at', 'desc')->paginate(8)->onEachSide(1)->withQueryString();

        return view('admin.comments', compact('comments', 'totalComments'));
    }

    public function destroy(\App\Models\Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'COMMENT_RECORD_NUKED');
    }
}
