<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contracts;
use App\Models\Access_Point;
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
        // Pasar los cliente a la vista 
        # $contracts = Contracts::all();
        return view('clients.index');
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
        // Retornar la vista para crear el usuario
        $contracts = Contracts::all();
        $points = Access_Point::all();
        return view('clients.create', compact('contracts', 'points'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // guardar el cliente
        /*
        $client = new Client();
        $client->first_name = $request->input('first-name');
        $client->last_name = $request->input('last-name');
        $client->email = $request->input('email');
        $client->ip_address = $request->input('ip-address');
        */
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
            'phone' => 'required|string|max:20',
            'contracts_id' => 'required',
            'access_point_id' => 'required',
            'street_address' => 'required|string|max:255',
            'file_upload' => 'nullable|image|max:2048',
        ]);
        // Guardar imagen si viene en la petición
        if ($request->hasFile('file_upload')) {
            $nombreImagen = time() . '.' . $request->file_upload->extension();
            $request->file_upload->storeAs('clients', $nombreImagen, 'public'); // carpeta storage/app/public/clients
            $validated['imagen'] = $nombreImagen; // Guardamos solo el nombre en DB
        }

        Client::create([
            'id_plan' => $validated['contracts_id'],
            'id_point' => $validated['access_point_id'],
            'nombre' => $validated['first_name'],
            'apellido' => $validated['last_name'],
            'direccion' => $validated['street_address'],
            'telefono' => $validated['phone'],
            'ip' => $validated['ip_address'],
            'imagen' => $validated['imagen'] ?? null
        ]);
        // $client->save();

        return redirect()->route('clients.create')->with('success', 'Cliente creado correctamente');
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
