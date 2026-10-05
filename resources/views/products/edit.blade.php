<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Edit item</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-panel">
            <h1 class="form-title">Edit item</h1>
            <p class="form-subtitle">Update your item information.</p>

            @if ($errors->any())
                <div class="form-error-box">
                    <ul class="form-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="form-fields">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="title" class="form-label">Item name</label>
                    <input id="title" name="title" value="{{ old('title', $product->title) }}" required class="spc-input">
                </div>

                <div class="form-field">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="5" required class="spc-input">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-field">
                    <label for="price" class="form-label">Price (₱)</label>
                    <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required class="spc-input">
                </div>

                <div class="form-field">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" required class="spc-input">
                        @foreach (['Gadgets', 'School Supplies', 'Books', 'Clothing', 'Food', 'Others'] as $category)
                            <option value="{{ $category }}" @selected(old('category', $product->category) === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="condition" class="form-label">Condition</label>
                    <select id="condition" name="condition" required class="spc-input">
                        @foreach (['New', 'Like New', 'Good', 'Fair'] as $condition)
                            <option value="{{ $condition }}" @selected(old('condition', $product->condition) === $condition)>{{ $condition }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="image" class="form-label">Product image</label>
                    <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" class="form-file">
                    <p class="form-help">JPG, JPEG, or PNG up to 2MB.</p>
                </div>

                <div class="form-field">
                    <label for="location" class="form-label">Pickup / meet-up location</label>
                    <input id="location" name="location" value="{{ old('location', $product->location) }}" class="spc-input">
                </div>

                <div class="form-actions">
                    <a href="{{ route('products.show', $product) }}" class="spc-button-secondary">Cancel</a>
                    <button type="submit" class="spc-button-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
