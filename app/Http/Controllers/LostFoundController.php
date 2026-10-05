<?php

namespace App\Http\Controllers;

use App\Models\LostFoundPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LostFoundController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();

        $posts = LostFoundPost::with('user')
            ->where('status', 'open')
            ->when(in_array($type, ['lost', 'found'], true), fn ($query) => $query->where('type', $type))
            ->latest()
            ->get();

        return view('lost-found.index', compact('posts', 'type'));
    }

    public function create(): View
    {
        return view('lost-found.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lost-found', 'public');
        }

        $post = LostFoundPost::create($validated);

        return redirect()
            ->route('lost-found.show', $post)
            ->with('success', 'Lost & Found report posted successfully.');
    }

    public function show(LostFoundPost $lostFoundPost): View
    {
        $lostFoundPost->load([
            'user',
            'comments' => fn ($query) => $query->whereNull('parent_id')->with(['user', 'replies.user']),
        ]);

        return view('lost-found.show', ['post' => $lostFoundPost]);
    }

    public function edit(LostFoundPost $lostFoundPost): View
    {
        $this->ensureOwner($lostFoundPost);

        return view('lost-found.edit', ['post' => $lostFoundPost]);
    }

    public function update(Request $request, LostFoundPost $lostFoundPost): RedirectResponse
    {
        $this->ensureOwner($lostFoundPost);
        $validated = $this->validatePost($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lost-found', 'public');
        }

        $lostFoundPost->update($validated);

        return redirect()
            ->route('lost-found.show', $lostFoundPost)
            ->with('success', 'Lost & Found report updated.');
    }

    public function resolve(LostFoundPost $lostFoundPost): RedirectResponse
    {
        $this->ensureOwner($lostFoundPost);
        $lostFoundPost->update(['status' => 'resolved']);

        return redirect()
            ->route('lost-found.show', $lostFoundPost)
            ->with('success', 'Report marked as resolved.');
    }

    public function destroy(LostFoundPost $lostFoundPost): RedirectResponse
    {
        $this->ensureOwner($lostFoundPost);
        $lostFoundPost->delete();

        return redirect()
            ->route('lost-found.index')
            ->with('success', 'Lost & Found report deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:lost,found'],
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
    }

    private function ensureOwner(LostFoundPost $post): void
    {
        abort_unless($post->user_id === Auth::id(), 403);
    }
}
