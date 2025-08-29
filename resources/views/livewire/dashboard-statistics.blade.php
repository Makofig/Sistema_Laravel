<div>
    <div class="p-6" wire:poll.30s>
        <h2 class="text-2xl font-bold mb-6">📊 Dashboard</h2>

        <!-- Métricas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-4 shadow rounded-lg">
                <p class="text-gray-600">Clientes</p>
                <h3 class="text-2xl font-bold">{{ $totalClients }}</h3>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <p class="text-gray-600">Total Cuotas Emitidas</p>
                <h3 class="text-2xl font-bold">{{ $totalPayments }}</h3>
            </div>
            <div class="bg-green-100 p-4 shadow rounded-lg">
                <p class="text-gray-600">Pagado</p>
                <h3 class="text-2xl font-bold text-green-700">${{ number_format($totalPaid, 2) }}</h3>
            </div>
            <div class="bg-red-100 p-4 shadow rounded-lg">
                <p class="text-gray-600">Deuda</p>
                <h3 class="text-2xl font-bold text-red-700">${{ number_format($totalDebt, 2) }}</h3>
            </div>
        </div>

        <!-- Graficos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Pagos por mes -->
            <div class="bg-white p-4 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Pagos por Mes</h3>
                <canvas id="paymentsPerMonthChart"></canvas>
            </div>

            <!-- Estados -->
            <div class="bg-white p-4 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Estados de Pagos</h3>
                <canvas id="paymentStatusesChart"></canvas>
            </div>
        </div>

        <!-- Top deudores -->
        <div class="bg-white p-4 shadow rounded-lg">
            <h3 class="text-lg font-semibold mb-4">🔝 Top 5 Deudores</h3>
            <table class="min-w-full border border-gray-200 table-fixed">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left w-[700px]">Cliente</th>
                        <th class="px-4 py-2 text-left">Deuda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topDebtors as $debtor)
                    <tr class="border-t">
                        <td class="px-4 py-2 truncate w-[700px]">{{ $debtor['apellido'] . ' ' . $debtor['nombre'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-red-600 font-bold">
                            ${{ number_format($debtor['deuda'] ?? 0, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-4 shadow rounded-lg">
            <h3 class="text-lg font-semibold mb-4">🔝 Top 5 Pagos</h3>
            <table class="min-w-full border border-gray-200 table-fixed">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left w-[700px]">Cliente</th>
                        <th class="px-4 py-2 text-left">Total Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topPayers as $payer)
                    <tr class="border-t">
                        <td class="px-4 py-2 truncate w-[700px]">{{ $payer['apellido'] . ' ' . $payer['nombre'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-green-600 font-bold">
                            ${{ number_format($payer['total_paid'] ?? 0, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Para evitar que se dupliquen los gráficos cada vez que Livewire refresca,
        // primero destruimos los gráficos previos antes de redibujar.

        document.addEventListener("livewire:navigated", renderCharts);
        document.addEventListener("livewire:load", renderCharts);
        document.addEventListener("livewire:update", renderCharts);

        let paymentsChart = null;
        let statusesChart = null;

        function renderCharts() {
            const paymentsPerMonth = @json($paymentsPerMonth);
            const months = Object.keys(paymentsPerMonth);
            const cuotas = months.map(m => paymentsPerMonth[m].totalCuotas);
            const pagados = months.map(m => paymentsPerMonth[m].totalPagado);
            const deudas = months.map(m => paymentsPerMonth[m].deuda);

            // 🔄 Destruir instancia anterior si existe
            if (paymentsChart) paymentsChart.destroy();

            paymentsChart = new Chart(document.getElementById('paymentsPerMonthChart'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Cuotas Emitidas',
                            data: cuotas,
                            backgroundColor: '#3b82f6'
                        },
                        {
                            label: 'Pagado',
                            data: pagados,
                            backgroundColor: '#10b981'
                        },
                        {
                            label: 'Deuda',
                            data: deudas,
                            backgroundColor: '#ef4444'
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // 🥧 Pie chart
            const statuses = @json($paymentStatuses);
            const statusLabels = Object.keys(statuses).map(s => s == 1 ? 'Pagado' : 'Pendiente');
            const statusData = Object.values(statuses);

            // Definir colores correctos por estado
            const backgroundColors = Object.keys(statuses).map(s => {
                if (s == 1) return '#10b981'; // Verde para Pagado
                return '#ef4444'; // Rojo para Pendiente
            });

            if (statusesChart) statusesChart.destroy();

            statusesChart = new Chart(document.getElementById('paymentStatusesChart'), {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: backgroundColors
                    }]
                },
                options: {
                    responsive: true
                }
            });
        }
    </script>
    @endpush
</div>