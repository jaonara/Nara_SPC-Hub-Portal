<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    SPC Hub - Buy & Sell
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Student Marketplace
                </p>
            </div>

            <a href="{{ route('products.create') }}" class="spc-button-primary">
                Post an item
            </a>
        </div>
    </x-slot>

    <div class="spc-page py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="spc-alert-success">{{ session('success') }}</div>
            @endif

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Student Buy & Sell
                </h1>

                <p class="text-gray-600 mt-2">
                    Buy and sell items within the St. Peter's College community.
                </p>
            </div>

            {{-- Products --}}
            @if ($products->count() > 0)

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($products as $product)

                        <div class="spc-card overflow-hidden">

                            {{-- Product Image --}}
                            <div class="flex h-52 items-center justify-center bg-gray-100 p-3">

                                @if ($product->image)

                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->title }}"
                                         class="h-full w-full object-contain">

                                @else

                                    <div class="text-center">
                                        <div class="text-5xl">
                                            🛒
                                        </div>

                                        <p class="text-gray-400 mt-2">
                                            No Image
                                        </p>
                                    </div>

                                @endif

                            </div>

                            {{-- Product Details --}}
                            <div class="p-6">

                                {{-- Title --}}
                                <h2 class="text-xl font-bold text-gray-800">
                                    {{ $product->title }}
                                </h2>

                                {{-- Price --}}
                                <p class="text-2xl font-bold text-blue-600 mt-2">
                                    ₱{{ number_format($product->price, 2) }}
                                </p>

                                {{-- Category --}}
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">
                                        Category
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $product->category }}
                                    </p>
                                </div>

                                {{-- Condition --}}
                                <div class="mt-3">
                                    <p class="text-sm text-gray-500">
                                        Condition
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $product->condition }}
                                    </p>
                                </div>

                                {{-- Location --}}
                                <div class="mt-3">
                                    <p class="text-sm text-gray-500">
                                        Pickup / Meet-up Location
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $product->location ?? 'Not specified' }}
                                    </p>
                                </div>

                                {{-- Seller --}}
                                <div class="mt-3">
                                    <p class="text-sm text-gray-500">
                                        Posted By
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $product->user->name }}
                                    </p>
                                </div>

                                {{-- Description --}}
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                </div>

                                {{-- View Details --}}
                                <a href="{{ route('products.show', $product) }}" class="spc-button-primary mt-6 block text-center">View details</a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- Empty State --}}
                <div class="spc-panel p-12 text-center">

                    <div class="text-6xl mb-4">
                        🛒
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        No Items Available
                    </h2>

                    <p class="text-gray-600 mt-2">
                        There are no items posted yet.
                    </p>

                    <a href="{{ route('products.create') }}" class="spc-button-primary mt-6 inline-block">
                        Post the first item
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>