<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('post.create') }}" class="mb-6 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-white">
                        {{ __('Buat Postingan') }}
                    </a>
                @endif
            @endauth

            <div class="space-y-4">
                @forelse ($posts as $post)
                    <article class="rounded-lg bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ditulis oleh :name', ['name' => $post->user->name]) }}
                        </p>
                        <p class="mt-4 whitespace-pre-line text-gray-700">{{ \Illuminate\Support\Str::limit($post->body, 240) }}</p>
                    </article>
                @empty
                    <p class="rounded-lg bg-white p-6 text-gray-700">{{ __('Belum ada postingan.') }}</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $posts->links() }}</div>
        </div>
    </div>
</x-app-layout>
