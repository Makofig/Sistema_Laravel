<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // obtener todos los clientes 
        # $clientes = Client::all(); 
        $clientes = Client::withCount([
            'pagos as debtors_count' => function ($query) {
                $query->where('estado', '0');
            },
            'pagos as paid_count' => function ($query) {
                $query->where('estado', '1');
            }
        ])->paginate(10);
        // Pasar los cliente a la vista 
        return view('clients.index', compact('clientes'));
    }

    public function debtors(){
        $debtors = Client::whereHas('pagos', function($query) {
            $query->where('estado', '0');
        })->paginate(10);
        return view('clients.debtors', compact('debtors'));
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
