<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Messages</h2>
            <span class="text-sm text-gray-500">Private conversations</span>
        </div>
    </x-slot>

    <div class="messages-page">
        <div class="messages-shell">
            <aside class="messages-sidebar">
                <div class="messages-sidebar-header">
                    <p class="messages-brand">SPC Hub</p>
                    <h1 class="messages-title">Chats</h1>
                </div>

                <div class="messages-list">
                    @forelse ($conversations as $conversation)
                        <a href="{{ route('messages.index', ['conversation' => $conversation['key']]) }}" class="message-conversation {{ $activeConversation && $activeConversation['key'] === $conversation['key'] ? 'message-conversation-active' : '' }}">
                            <div class="message-avatar">{{ strtoupper(substr($conversation['other']->name ?? '?', 0, 1)) }}</div>
                            <div class="message-preview">
                                <div class="message-preview-header">
                                    <p class="message-preview-name">{{ $conversation['other']->name ?? 'Unknown student' }}</p>
                                    <time class="message-preview-time">{{ $conversation['latest']->created_at->format('g:i A') }}</time>
                                </div>
                                <p class="message-preview-post">{{ $conversation['title'] }}</p>
                                <p class="message-preview-body">{{ $conversation['latest']->body }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="message-empty-sidebar">No conversations yet. Message a post author to start a chat.</p>
                    @endforelse
                </div>
            </aside>

            <main class="messages-main">
                @if ($activeConversation)
                    @php($activePost = $activeConversation['post'])
                    <header class="messages-header">
                        <div class="message-avatar md:hidden">{{ strtoupper(substr($activeConversation['other']->name ?? '?', 0, 1)) }}</div>
                        <div class="messages-header-content">
                            <h1 class="messages-header-name">{{ $activeConversation['other']->name ?? 'Unknown student' }}</h1>
                            <p class="messages-header-post">About: {{ $activeConversation['title'] }}</p>
                        </div>
                        @if ($activePost)
                            <a href="{{ $activePost instanceof \App\Models\Product ? route('products.show', $activePost) : route('lost-found.show', $activePost) }}" class="messages-post-link">View post</a>
                        @endif
                    </header>

                    <div class="messages-thread">
                        @foreach ($activeConversation['messages'] as $message)
                            @php($isMine = $message->sender_id === Auth::id())
                            <div class="message-row {{ $isMine ? 'message-row-mine' : 'message-row-theirs' }}">
                                <div class="message-bubble-wrap">
                                    <div class="message-bubble {{ $isMine ? 'message-bubble-mine' : 'message-bubble-theirs' }}">{{ $message->body }}</div>
                                    <div class="message-meta {{ $isMine ? 'message-meta-mine' : '' }}">
                                        <p class="message-time">{{ $message->created_at->format('M j, g:i A') }}</p>
                                        <form action="{{ route('messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="interaction-delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('messages.reply', $activeConversation['latest']) }}" method="POST" class="messages-composer">
                        @csrf
                        <div class="messages-composer-row">
                            <textarea name="body" rows="1" required maxlength="4000" class="messages-composer-input" placeholder="Type a message..."></textarea>
                            <button type="submit" class="messages-send">Send</button>
                        </div>
                    </form>
                @else
                    <div class="messages-empty">
                        <div>
                            <div class="messages-empty-icon">✦</div>
                            <h1 class="messages-empty-title">Your messages</h1>
                            <p class="messages-empty-text">Open a post and message its author to start a private conversation.</p>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-app-layout>
