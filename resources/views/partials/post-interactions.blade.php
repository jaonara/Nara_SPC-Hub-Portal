<section class="interactions">
    <div class="interactions-grid">
        <div>
            <h2 class="post-section-title">Comments</h2>

            @if ($post->comments->isNotEmpty())
                <div class="interaction-list">
                    @foreach ($post->comments as $comment)
                        <div class="interaction-comment">
                            <div class="interaction-comment-header">
                                <div class="flex items-center gap-2">
                                    <p class="interaction-author">{{ $comment->user->name }}</p>
                                    @if ($comment->user_id === Auth::id() || $post->user_id === Auth::id())
                                        <form action="{{ route('interactions.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="interaction-delete">Delete</button>
                                        </form>
                                    @endif
                                </div>
                                <time class="interaction-time">{{ $comment->created_at->diffForHumans() }}</time>
                            </div>
                            <p class="interaction-body">{{ $comment->body }}</p>

                            @if ($comment->replies->isNotEmpty())
                                <div class="interaction-replies">
                                    @foreach ($comment->replies as $reply)
                                        <div>
                                            <div class="interaction-comment-header">
                                                <div class="flex items-center gap-2">
                                                    <p class="interaction-author">{{ $reply->user->name }}</p>
                                                    @if ($reply->user_id === Auth::id() || $post->user_id === Auth::id())
                                                        <form action="{{ route('interactions.comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('Delete this reply?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="interaction-delete">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <time class="interaction-time">{{ $reply->created_at->diffForHumans() }}</time>
                                            </div>
                                            <p class="interaction-body">{{ $reply->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('interactions.comments.store', [$type, $post->id]) }}" method="POST" class="interaction-reply-form">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <label for="reply-body-{{ $comment->id }}" class="interaction-time">Reply to this comment</label>
                                <div class="interaction-reply-row">
                                    <input id="reply-body-{{ $comment->id }}" name="body" required maxlength="2000" class="interaction-input" placeholder="Write a reply...">
                                    <button type="submit" class="interaction-button">Reply</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500">No comments yet.</p>
            @endif

            <form action="{{ route('interactions.comments.store', [$type, $post->id]) }}" method="POST" class="interaction-composer">
                @csrf
                <label for="comment-body" class="block text-sm font-medium text-gray-700">Add a comment</label>
                <textarea id="comment-body" name="body" rows="3" required maxlength="2000" class="interaction-textarea" placeholder="Ask a helpful question or share a useful detail."></textarea>
                @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <button type="submit" class="post-button-dark mt-3">Post comment</button>
            </form>
        </div>

        @if ($post->user_id !== Auth::id())
            <div class="interaction-private">
                <h2 class="post-section-title">Private message</h2>
                <p class="interaction-private-text">Message {{ optional($post->user)->name ?: 'the author' }} privately about this post.</p>
                <form action="{{ route('interactions.messages.store', [$type, $post->id]) }}" method="POST" class="interaction-private-form">
                    @csrf
                    <label for="message-body" class="block text-sm font-medium text-gray-700">Your message</label>
                    <textarea id="message-body" name="body" rows="5" required maxlength="4000" class="interaction-textarea" placeholder="Hi, I would like to ask about this post..."></textarea>
                    @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    <button type="submit" class="interaction-private-button">Send privately</button>
                </form>
            </div>
        @else
            <div class="interaction-private">
                <h2 class="post-section-title">Private messages</h2>
                <p class="interaction-private-text">Check your Messages inbox for private questions from other students.</p>
                <a href="{{ route('messages.index') }}" class="interaction-owner-link">Open messages &rarr;</a>
            </div>
        @endif
    </div>
</section>
