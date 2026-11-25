<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <article class="max-w-4xl mx-auto rounded-lg bg-white p-6 shadow-sm sm:px-8">
            <p class="text-sm text-gray-600">
                {{ __('Ditulis oleh :name', ['name' => $post->user->name]) }}
            </p>
            @if (session('success'))
                <p class="mt-4 text-sm text-green-700">{{ session('success') }}</p>
            @endif
            <div class="mt-6 whitespace-pre-line text-gray-800">{{ $post->body }}</div>
        </article>
    </div>
</x-app-layout>
