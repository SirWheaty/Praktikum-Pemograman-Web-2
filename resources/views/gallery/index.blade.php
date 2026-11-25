<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Gallery</h2>
            @if (auth()->user()?->role === 'admin')
                <a href="{{ route('gallery.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Tambah Gambar
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @forelse ($galleries as $gallery)
                    @php
                        $imageUrl = \Illuminate\Support\Str::startsWith($gallery->picture, ['http://', 'https://'])
                            ? $gallery->picture
                            : asset('storage/posts_image/'.$gallery->picture);
                    @endphp
                    <article class="group overflow-hidden rounded-lg bg-white shadow-sm">
                        <button type="button"
                            class="gallery-open block aspect-square w-full overflow-hidden bg-gray-100"
                            data-image="{{ $imageUrl }}"
                            data-title="{{ $gallery->title }}"
                            data-description="{{ $gallery->description ?? $gallery->body }}">
                            <img src="{{ $imageUrl }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </button>
                        @if (auth()->user()?->role === 'admin')
                            <div class="flex items-center gap-2 border-t p-3">
                                <a href="{{ route('gallery.edit', $gallery) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Edit</a>
                                <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        @endif
                    </article>
                @empty
                    <p class="col-span-full rounded-lg bg-white p-6 text-gray-700">Tidak ada data.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $galleries->links() }}</div>
        </div>
    </div>

    <dialog id="gallery-modal" class="w-[min(900px,92vw)] rounded-xl p-0 backdrop:bg-black/80">
        <div class="relative bg-white">
            <button type="button" id="gallery-close" class="absolute right-3 top-3 z-10 rounded-full bg-black/60 px-3 py-1 text-xl text-white" aria-label="Close">&times;</button>
            <img id="gallery-modal-image" src="" alt="" class="max-h-[70vh] w-full object-contain">
            <div class="p-5">
                <h3 id="gallery-modal-title" class="text-xl font-semibold text-gray-900"></h3>
                <p id="gallery-modal-description" class="mt-2 text-gray-600"></p>
            </div>
        </div>
    </dialog>

    @push('scripts')
        <script>
            const modal = document.getElementById('gallery-modal');
            document.querySelectorAll('.gallery-open').forEach((button) => {
                button.addEventListener('click', () => {
                    document.getElementById('gallery-modal-image').src = button.dataset.image;
                    document.getElementById('gallery-modal-image').alt = button.dataset.title;
                    document.getElementById('gallery-modal-title').textContent = button.dataset.title;
                    document.getElementById('gallery-modal-description').textContent = button.dataset.description;
                    modal.showModal();
                });
            });
            document.getElementById('gallery-close').addEventListener('click', () => modal.close());
            modal.addEventListener('click', (event) => {
                if (event.target === modal) modal.close();
            });
        </script>
    @endpush
</x-app-layout>
