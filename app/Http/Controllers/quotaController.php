<?php

namespace App\Http\Controllers;

use App\Models\Quota;
use Illuminate\Http\Request;

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
        $quotas = Quota::orderBy('created_at', 'desc')->get();
        return view('quota.index', compact('quotas'));
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
