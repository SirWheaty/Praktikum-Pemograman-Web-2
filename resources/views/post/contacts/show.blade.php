<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3">
                <p><strong>Nama:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Subjek:</strong> {{ $contact->subject ?: '-' }}</p>
                <p><strong>Waktu:</strong> {{ $contact->created_at->format('d M Y H:i') }}</p>
                <div class="border-t pt-4 whitespace-pre-line">{{ $contact->message }}</div>
                <a href="{{ route('contacts.index') }}" class="inline-block text-blue-600">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
