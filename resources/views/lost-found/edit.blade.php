<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Edit Lost &amp; Found report</h2>
    </x-slot>

    <div class="form-page">
        <div class="form-panel-narrow">
            <p class="messages-brand">Lost &amp; Found</p>
            <h1 class="form-title mt-2">Update your report</h1>

            @if ($errors->any())
                <div class="form-error-box">
                    <ul class="form-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('lost-found.update', $post) }}" method="POST" enctype="multipart/form-data" class="form-fields">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="type" class="form-label">Report type</label>
                    <select id="type" name="type" required class="spc-input">
                        <option value="lost" @selected(old('type', $post->type) === 'lost')>I lost an item</option>
                        <option value="found" @selected(old('type', $post->type) === 'found')>I found an item</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="item_name" class="form-label">Item name</label>
                    <input id="item_name" name="item_name" value="{{ old('item_name', $post->item_name) }}" required class="spc-input">
                </div>

                <div class="form-field">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="5" required class="spc-input">{{ old('description', $post->description) }}</textarea>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-field">
                        <label for="location" class="form-label">Location</label>
                        <input id="location" name="location" value="{{ old('location', $post->location) }}" class="spc-input">
                    </div>
                    <div class="form-field">
                        <label for="event_date" class="form-label">Date</label>
                        <input id="event_date" type="date" name="event_date" value="{{ old('event_date', optional($post->event_date)->format('Y-m-d')) }}" class="spc-input">
                    </div>
                </div>

                <div class="form-field">
                    <label for="image" class="form-label">Replace photo <span class="font-normal text-gray-500">(optional)</span></label>
                    <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" class="form-file">
                    <p class="form-help">JPG, JPEG, or PNG up to 2MB.</p>
                </div>

                <div class="form-actions">
                    <a href="{{ route('lost-found.show', $post) }}" class="spc-button-secondary">Cancel</a>
                    <button type="submit" class="spc-button-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
