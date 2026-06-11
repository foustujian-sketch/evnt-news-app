<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventNews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EventNews::query();
        
        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(8)->onEachSide(1);
        return view('admin.events', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Create is handled in the index view.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'nullable|url',
            'content' => 'required|string',
            'publish_date' => 'required|date',
            'author_name' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['user_id'] = Auth::id() ?? 1;
        $validated['author_name'] = $validated['author_name'] ?? (Auth::user()->name ?? 'SYS_ADMIN');
        
        EventNews::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'RECORD_COMMITTED');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = EventNews::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = EventNews::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'nullable|url',
            'content' => 'required|string',
            'publish_date' => 'required|date',
            'author_name' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:500',
        ]);

        if ($event->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'RECORD_UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = EventNews::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'RECORD_DELETED');
    }
}
