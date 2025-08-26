<?php

namespace App\Http\Controllers;

use App\Models\Quota;
use App\Models\Client;
use App\Models\Payments;
use Illuminate\Http\Request;
use Carbon\Carbon;

class quotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // traer todas las cuotas y ordenar 
        // sortBy ordena en memoria 
        //$quotas = Quota::all()->sortBy('created_at');
        $quotas = Quota::orderBy('created_at', 'desc')->paginate(10);
        return view('quota.index', compact('quotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Renderizar la vista de creación de cuotas
        return view('quota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Recuperar los datos y guardar en las cuotas 
        // Obtener el mes y año actuales
        // $monthYear = Carbon::now()->format('Y-m'); // Ej: 2025-08
        $validated = $request->validate([
            'months_year' => 'required|date_format:F Y',
        ]);

        // Separar mes y año
        [$monthName, $year] = explode(' ', $validated['months_year']);
        $month = Carbon::createFromFormat('F', $monthName)->month;

        // Revisar si la cuota ya existe
        $existingQuota = Quota::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->first();

        if ($existingQuota) {
            return redirect()->back()->withErrors(['quota' => 'La cuota de este mes ya fue emitida.']);
        }

        // Crear la cuota
        $quota = Quota::create([
            'numero' => Carbon::now()->month,
            // otros campos que necesites
        ]);

        // Recuperar todos los clientes
        $clients = Client::with('contract')->get();

        foreach ($clients as $client) {
            // Generar un pago por cliente según su contrato
            Payments::create([
                'id_cliente' => $client->id,
                'id_cuota' => $quota->id,
                'num_cuotas' => $month,
                'costo' => $client->contract->costo, // monto según el contrato del cliente
                'abonado' => 0, 
                'estado' => 0,
                'fecha_pago' => null,
                'comentario' => null
            ]);
        }

        return redirect()->route('quota')->with('success', 'Cuota emitida correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
