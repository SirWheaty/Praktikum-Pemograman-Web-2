<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                <p class="mt-1 text-gray-600">{{ $user->email }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ __('Peran: :role', ['role' => $user->role]) }}</p>
            </section>

            <section>
                <h3 class="mb-4 text-lg font-medium text-gray-900">{{ __('Postingan Saya') }}</h3>
                <div class="space-y-4">
                    @forelse ($posts as $post)
                        <article class="rounded-lg bg-white p-6 shadow-sm">
                            <h4 class="font-semibold text-gray-900">
                                <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                            </h4>
                            <p class="mt-2 whitespace-pre-line text-gray-700">{{ \Illuminate\Support\Str::limit($post->body, 240) }}</p>
                        </article>
                    @empty
                        <p class="rounded-lg bg-white p-6 text-gray-700">{{ __('Anda belum memiliki postingan.') }}</p>
                    @endforelse
                </div>
                <div class="mt-6">{{ $posts->links() }}</div>
            </section>
        </div>
    </div>
</x-app-layout>
