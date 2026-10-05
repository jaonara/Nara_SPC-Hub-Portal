<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Product details</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-600 transition hover:text-gray-900">Back to marketplace</a>
        </div>
    </x-slot>

    <div class="post-page">
        <div class="post-content">
            @if (session('success'))
                <div class="spc-alert-success">{{ session('success') }}</div>
            @endif

            <article class="post-shell">
                <div class="post-grid">
                    <div class="post-media">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="post-image">
                        @else
                            <div class="post-empty-image">
                                <div class="post-empty-image-title">No image</div>
                                <p class="post-empty-image-text">This product has no image.</p>
                            </div>
                        @endif
                    </div>

                    <div class="post-details">
                        <div class="post-status-row">
                            <span class="post-status {{ $product->status === 'available' ? 'text-emerald-600' : 'text-gray-500' }}">{{ $product->status === 'available' ? 'Available' : 'Sold' }}</span>
                            <span class="post-category">{{ $product->category }}</span>
                        </div>
                        <h1 class="post-title">{{ $product->title }}</h1>
                        <p class="post-price">₱{{ number_format($product->price, 2) }}</p>

                        <dl class="post-meta">
                            <div>
                                <dt>Condition</dt>
                                <dd>{{ $product->condition }}</dd>
                            </div>
                            <div>
                                <dt>Meet-up location</dt>
                                <dd>{{ $product->location ?? 'Not specified' }}</dd>
                            </div>
                            <div class="post-meta-wide">
                                <dt>Seller</dt>
                                <dd>{{ optional($product->user)->name ?? 'Unknown seller' }}</dd>
                            </div>
                        </dl>

                        @if ($product->user && ($product->user->student_id || $product->user->contact_number))
                            <div class="post-contact">
                                @if ($product->user->student_id)
                                    <p><span class="post-contact-label">Student ID:</span> {{ $product->user->student_id }}</p>
                                @endif
                                @if ($product->user->contact_number)
                                    <p><span class="post-contact-label">Contact:</span> {{ $product->user->contact_number }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="post-description">
                    <h2 class="post-section-title">Description</h2>
                    <p class="post-description-text">{{ $product->description }}</p>
                </div>

                @include('partials.post-interactions', ['post' => $product, 'type' => 'product'])

                @if ($product->user_id === Auth::id())
                    <div class="post-management">
                        <span class="post-management-label">Manage your post</span>
                        <a href="{{ route('products.edit', $product) }}" class="post-button-edit">Edit</a>
                        @if ($product->status === 'available')
                            <form action="{{ route('products.sold', $product) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="post-button-dark">Mark as sold</button>
                            </form>
                        @endif
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
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
