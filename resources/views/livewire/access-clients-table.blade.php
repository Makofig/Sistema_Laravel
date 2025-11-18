<div>
    {{-- The Master doesn't talk, he acts. --}}
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
                        Updated
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
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
                        <div class="px-2 text-xs inline-flex rounded-full bg-green-100 text-green-800">{{ $client->updated_at ? $client->updated_at : 'Sin actualizar' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 ">{{ $client->created_at }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->

    <x-pagination :paginator="$clients" />
</div>
