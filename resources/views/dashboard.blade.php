<x-app-layout>
    <x-slot name="sidebar">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center py-1">
            {{ __('Dashboard') }}
        </h2>
        <div class="mt-3">
            <nav class="flex flex-col text-2xl font-light text-gray-700 space-y-3">
                <a href="#">Home</a>
                <a href="#">Transactions</a>
                <a href="#">Customers</a>
                <a href="#">Settings</a>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
