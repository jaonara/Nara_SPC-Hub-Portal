<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Lost &amp; Found details</h2>
            <a href="{{ route('lost-found.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-950">Back to reports</a>
        </div>
    </x-slot>

    <div class="post-page">
        <div class="post-content">
            @if (session('success'))
                <div class="spc-alert-success">{{ session('success') }}</div>
            @endif

            <article class="post-shell">
                <div class="post-grid post-grid-lost-found">
                    <div class="post-media post-media-small">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->item_name }}" class="post-image">
                        @else
                            <span class="post-category">No image</span>
                        @endif
                    </div>

                    <div class="post-details">
                        <span class="post-status {{ $post->type === 'lost' ? 'text-[#6B141A]' : 'text-[#2F5D3A]' }}">{{ $post->type }} item</span>
                        <h1 class="post-title">{{ $post->item_name }}</h1>
                        <p class="post-description-text">{{ $post->description }}</p>

                        <dl class="post-meta post-meta-stack">
                            <div>
                                <dt>Location</dt>
                                <dd>{{ $post->location ?: 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt>Date</dt>
                                <dd>{{ optional($post->event_date)->format('F j, Y') ?: 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt>Posted by</dt>
                                <dd>{{ optional($post->user)->name ?: 'Unknown student' }}</dd>
                            </div>
                            @if ($post->user && $post->user->contact_number)
                                <div>
                                    <dt>Contact</dt>
                                    <dd>{{ $post->user->contact_number }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                @include('partials.post-interactions', ['post' => $post, 'type' => 'lost-found'])

                @if ($post->user_id === Auth::id())
                    <div class="post-management">
                        <span class="post-management-label">Manage your report</span>
                        <a href="{{ route('lost-found.edit', $post) }}" class="post-button-edit">Edit</a>
                        @if ($post->status === 'open')
                            <form action="{{ route('lost-found.resolve', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="post-button-dark">Mark resolved</button>
                            </form>
                        @endif
                        <form action="{{ route('lost-found.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this report?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="post-button-danger">Delete</button>
                        </form>
                    </div>
                @endif
            </article>
        </div>
    </div>
</x-app-layout>
