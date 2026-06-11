<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\EventNews::query();
    
    if ($request->filled('q')) {
        $search = $request->query('q');
        $query->where(function($q) use ($search) {
            $q->where('title', 'ilike', "%{$search}%");
            if (is_numeric($search)) {
                $q->orWhere('id', $search);
            }
        });
    }

    if ($request->filled('date')) {
        $date = $request->query('date');
        $query->whereDate('publish_date', $date);
    }
    
    if ($request->filled('tag')) {
        $tag = $request->query('tag');
        $query->where(function($q) use ($tag) {
            $q->where('title', 'ilike', "%{$tag}%")
              ->orWhere('content', 'ilike', "%{$tag}%")
              ->orWhere('author_name', 'ilike', "%{$tag}%");
        });
    }

    $sortOrder = $request->query('sort', 'desc');
    $orderBy = $sortOrder === 'asc' ? 'ASC' : 'DESC';

    $events = $query->orderByRaw("image_path IS NOT NULL DESC, publish_date {$orderBy}")->paginate(12)->onEachSide(1)->withQueryString();
    return view('home', compact('events'));
});

Route::get('/sitemap.xml', function () {
    $events = \App\Models\EventNews::orderBy('created_at', 'desc')->get();
    return response()->view('sitemap', compact('events'))->header('Content-Type', 'text/xml');
});

Route::get('/dashboard', function () {
    $savedEvents = \Illuminate\Support\Facades\Auth::user()->savedEvents()->orderByPivot('created_at', 'desc')->get();
    return view('user.dashboard', compact('savedEvents'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/dashboard/update', function (\Illuminate\Http\Request $request) {
    $user = $request->user();
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|string|min:8',
    ]);
    
    $user->name = $request->name;
    if ($request->filled('password')) {
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    }
    $user->save();
    
    return back()->with('success', 'PROFILE_DATA_SYNCED // GLOBAL_CLUSTER');
})->middleware('auth')->name('dashboard.update');

// Article placeholder route
Route::get('/events/{slug}', function ($slug) {
    $event = \App\Models\EventNews::with(['comments.user'])->where('slug', $slug)->firstOrFail();
    return view('events.show', compact('event'));
})->name('events.show');

Route::post('/events/{event}/comments', [App\Http\Controllers\CommentController::class, 'store'])
    ->middleware(['auth', 'throttle:5,1'])
    ->name('comments.store');

Route::post('/events/{event}/save', [App\Http\Controllers\SavedEventController::class, 'toggle'])
    ->middleware('auth')
    ->name('events.save');

// Admin placeholder routes
Route::prefix('admin')->middleware(['auth', App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        $totalEvents = \App\Models\EventNews::count();
        $activeUsers = \App\Models\User::count();
        
        $recentEvents = \App\Models\EventNews::orderBy('created_at', 'desc')->take(5)->get()->map(function($evt) {
            return (object)[
                'id' => '#EVT-'.$evt->id,
                'snippet' => '{"type":"event_news", "title":"'.\Str::limit($evt->title, 20).'"}',
                'author' => $evt->author_name ?? 'SYS_ADMIN',
                'date' => $evt->created_at
            ];
        });
        
        $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get()->map(function($usr) {
            return (object)[
                'id' => '#USR-'.$usr->id,
                'snippet' => 'AUTH_TOKEN_REGISTERED // ' . strtoupper($usr->role),
                'author' => 'SYSTEM_DAEMON',
                'date' => $usr->created_at
            ];
        });

        $recentComments = \App\Models\Comment::with('user')->orderBy('created_at', 'desc')->take(5)->get()->map(function($cmt) {
            return (object)[
                'id' => '#CMT-'.$cmt->id,
                'snippet' => 'COMMENT_PAYLOAD: "'.\Str::limit($cmt->body, 20).'"',
                'author' => '@'.$cmt->user->name,
                'date' => $cmt->created_at
            ];
        });

        $recentLogs = $recentEvents->concat($recentUsers)->concat($recentComments)->sortByDesc('date')->take(8);

        return view('admin.dashboard', compact('totalEvents', 'activeUsers', 'recentLogs'));
    })->name('admin.dashboard');
    
    // Admin Event Management
    Route::resource('events', App\Http\Controllers\AdminEventController::class)->names('admin.events')->except(['show', 'create']);
    Route::resource('users', App\Http\Controllers\AdminUserController::class)->names('admin.users')->except(['show', 'create']);
    Route::patch('/users/{user}/role', [App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::resource('comments', App\Http\Controllers\AdminCommentController::class)->names('admin.comments')->only(['index', 'destroy']);
    Route::get('/api-sync', function () { 
        $events = \App\Models\EventNews::orderBy('publish_date', 'desc')->paginate(8)->onEachSide(1);
        return view('admin.api-sync', compact('events')); 
    })->name('admin.api-sync');
    
    Route::post('/api-sync/fetch', function () {
        \Illuminate\Support\Facades\Artisan::call('events:fetch');
        return back()->with('success', 'NEWS_API_SYNC_COMPLETED');
    })->name('admin.api-sync.fetch');
    
    Route::post('/api-sync/fetch-tag', function (\Illuminate\Http\Request $request) {
        $request->validate(['tag' => 'required|string']);
        \Illuminate\Support\Facades\Artisan::call('events:fetch', ['tag' => $request->tag]);
        return back()->with('success', 'NEWS_API_SYNC_COMPLETED // TAG: ' . strtoupper($request->tag));
    })->name('admin.api-sync.fetch-tag');
});

Route::middleware('auth')->group(function () {
    Route::post('/notifications/read', function (\Illuminate\Http\Request $request) {
        $request->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
