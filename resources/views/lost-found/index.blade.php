<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Lost &amp; Found</h2>
            <a href="{{ route('lost-found.create') }}" class="bg-gray-950 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">Report an item</a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">
            @if (session('success'))
                <div class="spc-alert-success">{{ session('success') }}</div>
            @endif

            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-gray-200 pb-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">SPC community board</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-950">Find what is missing</h1>
                    <p class="mt-2 text-gray-600">Share a lost item or help return something you found.</p>
                </div>
                <div class="flex gap-2 text-sm">
                    <a href="{{ route('lost-found.index') }}" class="border px-3 py-2 {{ $type === '' ? 'border-gray-950 bg-gray-950 text-white' : 'border-gray-300 bg-white text-gray-700' }}">All</a>
                    <a href="{{ route('lost-found.index', ['type' => 'lost']) }}" class="border px-3 py-2 {{ $type === 'lost' ? 'border-[#6B141A] bg-[#6B141A] text-white' : 'border-gray-300 bg-white text-gray-700' }}">Lost</a>
                    <a href="{{ route('lost-found.index', ['type' => 'found']) }}" class="border px-3 py-2 {{ $type === 'found' ? 'border-[#2F5D3A] bg-[#2F5D3A] text-white' : 'border-gray-300 bg-white text-gray-700' }}">Found</a>
                </div>
            </div>

            @if ($posts->isNotEmpty())
                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    @foreach ($posts as $post)
                        <a href="{{ route('lost-found.show', $post) }}" class="spc-card group flex gap-5 p-5">
                            <div class="flex h-28 w-28 shrink-0 items-center justify-center bg-gray-100">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->item_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">No image</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="text-xs font-semibold uppercase tracking-[0.18em] {{ $post->type === 'lost' ? 'text-[#6B141A]' : 'text-[#2F5D3A]' }}">{{ $post->type }}</span>
                                <h2 class="mt-2 truncate text-lg font-semibold text-gray-950 group-hover:underline">{{ $post->item_name }}</h2>
                                <p class="mt-1 line-clamp-2 text-sm leading-6 text-gray-600">{{ $post->description }}</p>
                                <p class="mt-3 text-xs text-gray-500">{{ $post->location ?: 'Location not specified' }} · {{ optional($post->event_date)->format('M j, Y') ?: 'Date not specified' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="spc-panel mt-8 border-dashed px-6 py-16 text-center">
                    <h2 class="text-xl font-semibold text-gray-950">No open reports yet</h2>
                    <p class="mt-2 text-sm text-gray-600">Be the first to report a lost or found item.</p>
                    <a href="{{ route('lost-found.create') }}" class="mt-6 inline-block bg-gray-950 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Report an item</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
