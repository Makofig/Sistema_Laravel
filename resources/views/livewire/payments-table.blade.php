<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            @if($client)
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount Paid
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Payment Date
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
                @foreach($payments as $payment)
                <!-- Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->cuota->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">$ {{ number_format($payment->costo, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">$ {{ number_format($payment->abonado, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="px-2 text-xs inline-flex rounded-full bg-green-100 text-green-800">{{ $payment->fecha_pago }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($payment->estado == 1)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Paid
                        </span>
                        @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Must
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('payments.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        @if ($payment->estado == 1)
                        <button class="text-gray-600 cursor-not-allowed mr-3" disabled>Pay</button>
                        @else
                        <a href="{{ route('payments.edit', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Pay</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @else
            <tr>
                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                    No hay información disponible para este cliente.
                </td>
            </tr>
            @endif
        </table>
    </div>
    <!-- Pagination -->
    <x-pagination :paginator="$payments" />
</div>