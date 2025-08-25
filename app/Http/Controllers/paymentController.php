<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // mostrar detalles del pago
        $payment = Payments::findOrFail($id);

        //return view('payments.show', ['payment' => $payment]);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // editar los detalles del pago
        $payment = Payments::findOrFail($id);

        //return view('payments.edit', ['payment' => $payment]);
        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos 
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'coment' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'voucher' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]); 

        // Encontrar el pago
        $payment = Payments::findOrFail($id);

       // Armamos el array de actualización
        $data = [
            'abonado'    => $validated['amount'],
            'estado'     => '1',
            'comentario' => $validated['coment'],
            'fecha_pago' => $validated['payment_date'],
        ];

        // Si subió un comprobante, lo guardamos
        if ($request->hasFile('voucher')) {
            // Usamos el ID del cliente para la carpeta
            $clientId = $payment->id_cliente; // suponiendo que Payments tiene relación con Client
            $path = $request->file('voucher')->store("vouchers/client_$clientId", 'public');
            $data['image'] = $path;
        }

        // Actualizar
        $payment->update($data);

        return redirect()->route('clients.show', $payment->id_cliente)->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
