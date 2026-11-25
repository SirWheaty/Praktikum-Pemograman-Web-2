<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-blue-600 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm opacity-80">Total Messages</div>
                    <div class="text-3xl font-bold">{{ $messageCount }}</div>
                </div>
                <div class="bg-amber-500 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm opacity-80">Unread Messages</div>
                    <div class="text-3xl font-bold">{{ $unreadMessageCount }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
