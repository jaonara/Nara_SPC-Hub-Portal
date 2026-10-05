<?php

namespace App\Http\Controllers;

use App\Models\LostFoundPost;
use App\Models\PostComment;
use App\Models\PrivateMessage;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InteractionController extends Controller
{
    public function comment(Request $request, string $type, int $id): RedirectResponse
    {
        $post = $this->resolvePost($type, $id);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        $parentId = null;
        if (! empty($validated['parent_id'])) {
            $parent = $post->comments()->findOrFail($validated['parent_id']);
            $parentId = $parent->id;
        }

        $post->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'body' => $validated['body'],
        ]);

        return back()->with('success', $parentId ? 'Reply posted.' : 'Comment posted.');
    }

    public function message(Request $request, string $type, int $id): RedirectResponse
    {
        $post = $this->resolvePost($type, $id);
        abort_if($post->user_id === Auth::id(), 422, 'You cannot message yourself.');

        $validated = $request->validate(['body' => ['required', 'string', 'max:4000']]);
        $post->privateMessages()->create([
            'sender_id' => Auth::id(),
            'recipient_id' => $post->user_id,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Private message sent to the author.');
    }

    public function inbox(): View
    {
        $messages = PrivateMessage::with(['sender', 'recipient', 'messageable'])
            ->where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('recipient_id', Auth::id());
            })
            ->latest()
            ->get();

        PrivateMessage::where('recipient_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversations = $messages
            ->groupBy(fn (PrivateMessage $message) => $this->conversationKey($message))
            ->map(function ($thread, string $key) {
                $thread = $thread->sortBy('created_at')->values();
                $latest = $thread->last();
                $post = $latest->messageable;
                $other = $latest->sender_id === Auth::id() ? $latest->recipient : $latest->sender;

                return [
                    'key' => $key,
                    'messages' => $thread,
                    'latest' => $latest,
                    'other' => $other,
                    'post' => $post,
                    'title' => $post?->title ?? $post?->item_name ?? 'Post unavailable',
                ];
            })
            ->sortByDesc(fn (array $conversation) => $conversation['latest']->created_at)
            ->values();

        $selectedKey = request('conversation', $conversations->first()['key'] ?? null);
        $activeConversation = $conversations->firstWhere('key', $selectedKey) ?? $conversations->first();

        return view('messages.index', compact('conversations', 'activeConversation'));
    }

    private function conversationKey(PrivateMessage $message): string
    {
        $participants = collect([$message->sender_id, $message->recipient_id])->sort()->implode('-');

        return $message->messageable_type . '|' . $message->messageable_id . '|' . $participants;
    }

    public function replyToMessage(Request $request, PrivateMessage $privateMessage): RedirectResponse
    {
        abort_unless(
            in_array(Auth::id(), [$privateMessage->sender_id, $privateMessage->recipient_id], true),
            403
        );

        $privateMessage->load('messageable');
        abort_unless($privateMessage->messageable, 404);

        $validated = $request->validate(['body' => ['required', 'string', 'max:4000']]);
        $privateMessage->messageable->privateMessages()->create([
            'sender_id' => Auth::id(),
            'recipient_id' => $privateMessage->sender_id === Auth::id()
                ? $privateMessage->recipient_id
                : $privateMessage->sender_id,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function destroyComment(PostComment $postComment): RedirectResponse
    {
        $postComment->load('commentable');
        abort_unless(
            $postComment->user_id === Auth::id()
                || $postComment->commentable?->user_id === Auth::id(),
            403
        );

        $postComment->delete();

        return back()->with('success', 'Comment deleted.');
    }

    public function destroyMessage(PrivateMessage $privateMessage): RedirectResponse
    {
        abort_unless(
            in_array(Auth::id(), [$privateMessage->sender_id, $privateMessage->recipient_id], true),
            403
        );

        $privateMessage->delete();

        return back()->with('success', 'Message deleted.');
    }

    private function resolvePost(string $type, int $id): Product|LostFoundPost
    {
        return match ($type) {
            'product' => Product::findOrFail($id),
            'lost-found' => LostFoundPost::findOrFail($id),
            default => abort(404),
        };
    }
}
