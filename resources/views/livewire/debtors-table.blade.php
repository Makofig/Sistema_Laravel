<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
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
        <div>
            <select wire:model.live="anio" class="border rounded p-2 w-20">
                @foreach(range(2023, now()->year) as $y)
                <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model.live="mes" class="border rounded p-2 w-32">
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contracts
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
                <!-- Row 5 -->
                @foreach($debtors as $client)
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
                                <div class="text-sm font-medium text-gray-900">{{ $client->nombre }} - {{ $client->apellido }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">$ {{ number_format($client->contract->costo, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $client->contract->megabytes }} Mb</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Must
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('payments.show', $client->pago_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Show</a>
                        @if ($client->pago_estado == 1)
                        <button class="text-gray-600 cursor-not-allowed mr-3" disabled>Pay</button>
                        @else
                        <a href="{{ route('payments.edit', $client->pago_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Pay</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <x-pagination :paginator="$debtors" />
</div>