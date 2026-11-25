<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Postingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('post.store') }}" class="space-y-6 rounded-lg bg-white p-6 shadow-sm">
                @csrf

                <div>
                    <x-input-label for="title" :value="__('Judul')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="body" :value="__('Isi postingan')" />
                    <textarea id="body" name="body" rows="12" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>

                <x-primary-button>{{ __('Terbitkan') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
