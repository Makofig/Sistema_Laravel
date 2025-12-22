<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banned') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Clients Banned</h2>
                            <p class="text-gray-500 mt-1">Manage your clients banned and their account permissions here.</p>
                        </div>
                        <a href="{{ route('clients.export', ['type' => 'banned']) }}" class="border px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700">
                            Export PDF
                        </a>
                    </div>
                </div>

                @livewire('clients-table', ['onlyBanned' => true])
            </div>
        </div>
    </div>
</x-app-layout>