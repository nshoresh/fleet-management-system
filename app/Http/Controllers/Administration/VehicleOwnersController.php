<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\VehicleOwner;
use Illuminate\Http\Request;

class VehicleOwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administration.vehicle-owners.index');
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
        return view('administration.vehicle-owners.show', [
            'id' => $id
        ]);
        /*
        $vehicleOwner = VehicleOwner::where('uuid', $id)->firstOrFail();
        return view('administration.vehicle-owners.show', [
            'id' => $vehicleOwner->id
        ]); */
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(/*string $id*/)
    {/*
        $vehicleOwner = VehicleOwner::where('uuid', $id)->firstOrFail();
        return view('administration.vehicle-owners.edit', [
            'id' => $vehicleOwner->id
        ]);*/
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
