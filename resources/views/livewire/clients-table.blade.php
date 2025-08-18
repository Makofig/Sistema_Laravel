<div>
    @if (session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: '¡Hecho!',
        text: `{{ session('success') }}`,
        timer: 2000,
        showConfirmButton: false
    })
    </script>
    @endif
    <!-- Search and Filter -->
    <div class="m-6 flex flex-col sm:flex-row gap-4">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.500ms="search" type="text" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full " placeholder="Search clients...">
        </div>
        <select wire:model.lazy="id_plan" class="border border-gray-300 rounded-lg px-4 py-2  w-full sm:w-auto">
            <option value="">All Contracts</option>
            @foreach ($contracts as $contract)
            <option value="{{ $contract->id }}">{{ $contract->megabytes }}</option>
            @endforeach
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        IP Address
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contracts
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Paid
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Owed
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($clients as $client)
                <!-- Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    src="{{ $client->imagen 
                                        ? asset('storage/clients/' . $client->imagen) 
                                        : asset('images/default-avatar.png') }}"
                                    alt="{{ $client->nombre }} {{ $client->apellido }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $client->nombre}} - {{ $client->apellido }}</div>
                                <div class="text-sm text-gray-500">{{ $client->direccion }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->ip }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->contract->megabytes }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="px-2 text-xs inline-flex rounded-full bg-green-100 text-green-800">{{ $client->paid_count }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 ">{{ $client->debtors_count }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        <a href="{{ route('clients.edit', $client->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form id="delete-client-{{ $client->id }}" 
                            action="{{ route('clients.destroy', $client->id) }}" 
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" 
                                class="text-red-600 hover:text-red-900" 
                                onclick="confirmDelete(`{{ $client->id }}`)">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->

    <x-pagination :paginator="$clients" />

</div>
<script>
function confirmDelete(clientId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-client-${clientId}`).submit();
        }
    })
}
</script>