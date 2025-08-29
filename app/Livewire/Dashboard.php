<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Quota;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalClients;
    public $totalPayments;
    public $totalPaid;
    public $totalDebt;
    public $paymentsPerMonth;
    public $paymentStatuses;
    public $topDebtors;
    public $topPayers;

    public function mount()
    {
        // 👥 Total de clientes
        $this->totalClients = Client::count();

        // 💰 Total de pagos registrados (en general)
        $this->totalPayments = Payments::count();

        // ✅ Total abonado (pagado)
        $this->totalPaid = Payments::where('estado', '1')->sum('abonado');

        // ❌ Total deuda (sumamos los montos de los no pagados)
        $this->totalDebt = Payments::where('estado', '0')->sum('costo');

        // 📊 Pagos por mes (según fecha de creación o período)
        $this->paymentsPerMonth = Payments::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(abonado) as totalPagado, SUM(costo) as totalCuotas')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(fn($row) => [
                $row->month => [
                    'totalCuotas' => $row->totalCuotas,
                    'totalPagado' => $row->totalPagado,
                    'deuda' => $row->totalCuotas - $row->totalPagado,
                ]
            ])
            ->toArray();

        // 🥧 Estados de pagos (cuántos están pagos vs pendientes)
        $this->paymentStatuses = Payments::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        // 🔝 Top 5 deudores
        $this->topDebtors = Client::withSum(['pagos as deuda' => function ($q) {
            $q->where('estado', '0'); // cuotas no pagadas
        }], 'costo')
            ->orderByDesc('deuda')
            ->take(5)
            ->get()
            ->toArray();

        // 🔝 top 5 clientes que más pagan
        $this->topPayers = Client::withSum(['pagos as total_paid' => function ($q) {
                $q->where('estado', 1); // Solo pagos confirmados
            }], 'abonado')
            ->orderByDesc('total_paid')
            ->take(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard-statistics');
    }
}
