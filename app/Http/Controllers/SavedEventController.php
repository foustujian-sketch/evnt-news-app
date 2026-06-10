<?php

namespace App\Http\Controllers;

use App\Models\EventNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedEventController extends Controller
{
    /**
     * Toggle the saved status of an event for the authenticated user.
     */
    public function toggle(Request $request, EventNews $event)
    {
        $user = Auth::user();
        
        $isSaved = $user->savedEvents()->where('event_news_id', $event->id)->exists();

        if ($isSaved) {
            $user->savedEvents()->detach($event->id);
            $isSaved = false;
        } else {
            $user->savedEvents()->attach($event->id);
            $isSaved = true;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_saved' => $isSaved,
            ]);
        }

        return back()->with('success', $isSaved ? 'EVENT_SAVED' : 'EVENT_REMOVED');
    }
}
