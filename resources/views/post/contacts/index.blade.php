<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesan Masuk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3">Nama</th><th>Email</th><th>Subjek</th><th>Waktu</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($contacts as $contact)
                            <tr>
                                <td class="py-3"><a class="text-blue-600" href="{{ route('post.contacts.show', $contact) }}">{{ $contact->name }}</a></td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->subject ?: '-' }}</td>
                                <td>{{ $contact->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($contact->is_read)
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Sudah dibaca</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">Belum dibaca</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada pesan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $contacts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
