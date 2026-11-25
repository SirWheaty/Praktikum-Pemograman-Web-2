<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Gambar</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow-sm">
                @csrf
                @include('gallery.form')
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Simpan</button>
                    <a href="{{ route('gallery.index') }}" class="rounded-md border px-4 py-2 text-gray-700">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
