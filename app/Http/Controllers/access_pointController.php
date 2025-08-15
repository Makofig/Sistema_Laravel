<?php

namespace App\Http\Controllers;

use App\Models\Access_Point;
use Illuminate\Http\Request;

class access_pointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar todos los puntos de acceso
        $points = Access_Point::paginate(10); 
        return view('access-point.index', compact('points'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('access-point.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Recuperar los datos para guardarlos 
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'frequency' => 'required|string|max:100',
            'ip_address' => 'nullable|ip',
            'location' => 'required|string|max:255',
        ]);

        Access_Point::create([
            'ssid' => $validated['ssid'],
            'frecuencia' => $validated['frequency'],
            'ip_ap' => $validated['ip_address'],
            'localidad' => $validated['location'],
        ]);

        return redirect()->route('access-point.create')->with('success', 'Access Point created successfully.');
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
