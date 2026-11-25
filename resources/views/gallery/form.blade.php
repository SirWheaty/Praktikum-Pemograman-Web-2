<div class="space-y-5">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $gallery->title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description', $gallery->description ?? $gallery->body ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @isset($gallery)
        @php
            $imageUrl = \Illuminate\Support\Str::startsWith($gallery->picture, ['http://', 'https://'])
                ? $gallery->picture
                : asset('storage/posts_image/'.$gallery->picture);
        @endphp
        <div>
            <p class="text-sm font-medium text-gray-700">Gambar saat ini</p>
            <img src="{{ $imageUrl }}" alt="{{ $gallery->title }}" class="mt-2 h-48 w-full rounded object-cover">
        </div>
    @endisset

    <div>
        <label for="picture" class="block text-sm font-medium text-gray-700">
            {{ isset($gallery) ? 'Ganti Gambar' : 'File input' }}
        </label>
        <input type="file" id="picture" name="picture" accept="image/*" class="mt-1 block w-full text-sm text-gray-700" {{ isset($gallery) ? '' : 'required' }}>
        @error('picture')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
