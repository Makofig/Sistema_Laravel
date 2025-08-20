<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contracts;
use App\Models\Access_Point;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'contracts_id' => 'required|exists:plan,id',
            'access_point_id' => 'required|exists:accespoint,id',
            'street_address' => 'required|string|max:255',
            'file_upload' => 'nullable|image|max:2048',
        ], [
            // Mensajes personalizados
            'first_name.required'      => 'El nombre no puede estar vacío.',
            'last_name.required'       => 'El apellido no puede estar vacío.',
            'phone.required'           => 'El número de teléfono es obligatorio.',
            'contracts_id.required'    => 'Debe seleccionar un plan.',
            'contracts_id.exists'      => 'El plan seleccionado no es válido.',
            'access_point_id.required' => 'Debe seleccionar un punto de acceso.',
            'access_point_id.exists'   => 'El punto de acceso seleccionado no es válido.',
            'street_address.required'  => 'La dirección es obligatoria.',
            'file_upload.image'        => 'El archivo debe ser una imagen válida.',
            'file_upload.max'          => 'La imagen no puede superar los 2 MB.',
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
        // mostrar la información de un cliente
        $client = Client::findOrFail($id);

        // Obtener los pagos asociados al cliente
        $payments = Payments::where('id_cliente', $client->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('clients.show', compact('client', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mostramos la pagina para editar el cliente
        $client = Client::findOrFail($id);
        $contracts = Contracts::all();
        $points = Access_Point::all();
        return view('clients.edit', compact('client', 'contracts', 'points'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Recibir los datos para actualizar el cliente
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
            'phone' => 'required|string|max:20',
            'contracts_id' => 'required|exists:plan,id',
            'access_point_id' => 'required|exists:accespoint,id',
            'street_address' => 'required|string|max:255',
            'file_upload' => 'nullable|image|max:2048',
        ], [
            // Mensajes personalizados
            'first_name.required'      => 'El nombre no puede estar vacío.',
            'last_name.required'       => 'El apellido no puede estar vacío.',
            'phone.required'           => 'El número de teléfono es obligatorio.',
            'contracts_id.required'    => 'Debe seleccionar un plan.',
            'contracts_id.exists'      => 'El plan seleccionado no es válido.',
            'access_point_id.required' => 'Debe seleccionar un punto de acceso.',
            'access_point_id.exists'   => 'El punto de acceso seleccionado no es válido.',
            'street_address.required'  => 'La dirección es obligatoria.',
            'file_upload.image'        => 'El archivo debe ser una imagen válida.',
            'file_upload.max'          => 'La imagen no puede superar los 2 MB.',
        ]);

        $client = Client::findOrFail($id);

        // Si viene nueva imagen
        if ($request->hasFile('file_upload')) {
            // Borrar la anterior si existe
            if ($client->imagen && Storage::disk('public')->exists('clients/' . $client->imagen)) {
                Storage::disk('public')->delete('clients/' . $client->imagen);
            }

            // Guardar nueva
            $nombreImagen = time() . '.' . $request->file_upload->extension();
            $request->file_upload->storeAs('clients', $nombreImagen, 'public');
            $validated['imagen'] = $nombreImagen;
        } else {
            // Mantener la actual si no se subió nueva
            $validated['imagen'] = $client->imagen;
        }

        $client->update([
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

        return redirect()->route('clients.edit', $client->id)->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Eliminar un cliente seleccionado
        $client = Client::findOrFail($id);

        // Si tiene imagen, borrarla
        if ($client->imagen && Storage::disk('public')->exists("clients/{$client->imagen}")) {
            Storage::disk('public')->delete("clients/{$client->imagen}");
        }

        $client->delete();

        return redirect()->route('clients')->with('success', 'Cliente eliminado correctamente');
    }
}
