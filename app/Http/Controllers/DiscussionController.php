<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\TrainingTrack;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    /**
     * Display listing of discussions.
     */
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Discussion::with(['user', 'track', 'replies'])
            ->withCount('replies');

        if ($category && $category !== 'Semua') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $discussions = $query->latest()->paginate(10)->withQueryString();
        $tracks = TrainingTrack::where('is_active', true)->get();

        return view('pages.discussions.index', compact('discussions', 'tracks', 'category', 'search'));
    }

    /**
     * Display a specific discussion thread.
     */
    public function show(int $id): View
    {
        $discussion = Discussion::with(['user', 'track', 'replies.user'])
            ->findOrFail($id);

        $discussion->increment('views_count');

        return view('pages.discussions.show', compact('discussion'));
    }

    /**
     * Store new discussion question.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengajukan pertanyaan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'training_track_id' => 'nullable|exists:training_tracks,id',
            'content' => 'required|string|min:15',
        ]);

        $discussion = Discussion::create([
            'user_id' => Auth::id(),
            'training_track_id' => $validated['training_track_id'] ?? null,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'content' => $validated['content'],
            'is_resolved' => false,
            'views_count' => 0,
        ]);

        return redirect()->route('discussions.show', $discussion->id)->with('success', 'Topik diskusi berhasil dipublikasikan.');
    }

    /**
     * Post a reply to a discussion.
     */
    public function reply(Request $request, int $id): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menjawab diskusi.');
        }

        $discussion = Discussion::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string|min:5',
        ]);

        $user = Auth::user();
        $isInstructorAnswer = $user->isInstructor() || $user->isAdmin();

        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
            'is_instructor_answer' => $isInstructorAnswer,
        ]);

        return back()->with('success', 'Tanggapan diskusi berhasil dikirim.');
    }
}
