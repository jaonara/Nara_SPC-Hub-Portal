<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Post an item</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-panel">
            <h1 class="form-title">Post an item</h1>
            <p class="form-subtitle">Sell your item to other St. Peter's College students.</p>

            @if ($errors->any())
                <div class="form-error-box">
                    <ul class="form-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-fields">
                @csrf

                <div class="form-field">
                    <label for="title" class="form-label">Item name</label>
                    <input id="title" name="title" value="{{ old('title') }}" required class="spc-input" placeholder="Example: Casio Calculator">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" required class="spc-input" placeholder="Describe your item...">{{ old('description') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="price" class="form-label">Price (₱)</label>
                    <input id="price" type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required class="spc-input" placeholder="0.00">
                    @error('price')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" required class="spc-input">
                        <option value="">Select category</option>
                        @foreach (['Gadgets', 'School Supplies', 'Books', 'Clothing', 'Food', 'Others'] as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="condition" class="form-label">Condition</label>
                    <select id="condition" name="condition" required class="spc-input">
                        <option value="">Select condition</option>
                        @foreach (['New', 'Like New', 'Good', 'Fair'] as $condition)
                            <option value="{{ $condition }}" @selected(old('condition') === $condition)>{{ $condition }}</option>
                        @endforeach
                    </select>
                    @error('condition')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="image" class="form-label">Product image</label>
                    <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" class="form-file">
                    <p class="form-help">JPG, JPEG, or PNG up to 2MB.</p>
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="location" class="form-label">Pickup / meet-up location</label>
                    <input id="location" name="location" value="{{ old('location') }}" class="spc-input" placeholder="Example: SPC Campus">
                    @error('location')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('products.index') }}" class="spc-button-secondary">Cancel</a>
                    <button type="submit" class="spc-button-primary">Post item</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
