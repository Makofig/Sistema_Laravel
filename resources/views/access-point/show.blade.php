<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Access Point Show') }}
        </h2>
    </x-slot>
    <!-- @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Exito!',
            text: `{{ session('success') }}`,
            timer: 2000,
            showConfirmButton: false
        })
    </script>
    @endif -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container max-w-6xl">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Table Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Access Point Details</h2>
                                <p class="text-gray-500 mt-1">View and manage access point information here.</p>
                            </div>
                            <x-button-previous></x-button-previous>
                        </div>
                    </div>
                    <div class="flex flex-wrap py-10 px-2">
                        
                        <div class="flex flex-col justify-center ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $access_point->ssid }}</h3>
                            <p class="text-gray-500">Frecuencia: {{ $access_point->frecuencia }}</p>
                            <p class="text-gray-500">IP: {{ $access_point->ip_ap }}</p>
                            <p class="text-gray-500">Clientes: {{ $access_point->clientes->count() }}</p>
                            <p class="text-gray-500">Localidad: {{ $access_point->localidad }}</p>

                        </div>
                    </div>
                    <div>
                       @livewire('access-clients-table', ['access_point_id' => $access_point->id])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>