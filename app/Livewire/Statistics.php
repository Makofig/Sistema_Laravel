<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Statistics extends Component
{
    public $mes;
    public $anio;

    public function mount()
    {
        $this->mes = Carbon::now()->month;
        $this->anio = Carbon::now()->year;
    }

    public function render()
    {
        // Total de clientes
        $totalClientes = Client::count();

        // 💰 Recaudado y esperado (evitamos NULLs en fecha_pago)
        $recaudado = Payments::whereNotNull('fecha_pago')
            ->whereMonth('fecha_pago', $this->mes)
            ->whereYear('fecha_pago', $this->anio)
            ->sum('abonado');

        $totalEsperado = Payments::whereNotNull('created_at')
            ->whereMonth('created_at', $this->mes)
            ->whereYear('created_at', $this->anio)
            ->sum('costo');

        $pendiente = $totalEsperado - $recaudado;

        // ✅ Clientes con pago (estado=1 y abonado>0)
        $clientesConPago = Payments::whereNotNull('fecha_pago')
            ->whereMonth('fecha_pago', $this->mes)
            ->whereYear('fecha_pago', $this->anio)
            ->where('estado', 1)
            ->where('abonado', '>', 0)
            ->distinct('id_cliente')
            ->count('id_cliente');

        // % morosidad
        $morosidad = $totalClientes > 0 
            ? round((($totalClientes - $clientesConPago) / $totalClientes) * 100, 2) 
            : 0;

        // 📊 Rangos de puntualidad
        $rangos = [
            '1-10' => Payments::whereNotNull('fecha_pago')
                ->whereMonth('fecha_pago', $this->mes)
                ->whereYear('fecha_pago', $this->anio)
                ->whereBetween(DB::raw('DAY(fecha_pago)'), [1, 10])
                ->count() ?? 0,

            '11-20' => Payments::whereNotNull('fecha_pago')
                ->whereMonth('fecha_pago', $this->mes)
                ->whereYear('fecha_pago', $this->anio)
                ->whereBetween(DB::raw('DAY(fecha_pago)'), [11, 20])
                ->count() ?? 0,


            '>21' => Payments::whereNotNull('fecha_pago')
                ->whereMonth('fecha_pago', $this->mes)
                ->whereYear('fecha_pago', $this->anio)
                ->where(DB::raw('DAY(fecha_pago)'), '>', 21)
                ->count() ?? 0,
        ];

        // 📊 Deudores
        $deudores = $totalClientes - $clientesConPago;

        // 🚨 Clientes que NO pagaron hasta el 15
        $morosos = Client::whereNotIn('id', function ($q) {
            $q->select('id_cliente')
                ->from('pagos')
                ->whereNotNull('fecha_pago')
                ->whereMonth('fecha_pago', $this->mes)
                ->whereYear('fecha_pago', $this->anio)
                ->whereDay('fecha_pago', '<=', 15);
        })->get();

        $this->dispatch('updateCharts', [
            'recaudado' => $recaudado,
            'pendiente' => $pendiente,
            'rangos'    => [
                '1-10' => $rangos['1-10'],
                '11-20' => $rangos['11-20'],
                '>21' => $rangos['>21'],
            ],
        ]);

        return view('livewire.statistics', [
            'totalClientes' => $totalClientes,
            'recaudado'     => $recaudado,
            'pendiente'     => $pendiente,
            'morosidad'     => $morosidad,
            'rangos'        => $rangos,
            'deudores'      => $deudores,
            'morosos'       => $morosos,
            'mes'           => $this->mes,
            'anio'          => $this->anio,
        ]);
    }
}
