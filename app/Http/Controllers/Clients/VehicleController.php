<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\VehicleExport;
use App\Exports\VehiclesExport;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.vehicles.index');
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
    public function show(string $uuid)
    {
        //
        $vehicle = Vehicle::where('uuid', $uuid)->firstOrFail();
        return view('clients.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Download single vehicle details as PDF.
     */
    public function downloadPdf(string $uuid)
    {
        $vehicle = Vehicle::where('uuid', $uuid)->firstOrFail();

        // Render the PDF view
        $pdf = Pdf::loadView('clients.vehicles.pdf', compact('vehicle'));

        // Return as download
        return $pdf->download("vehicle-{$vehicle->uuid}.pdf");
        //return $pdf->steam("vehicle-{$vehicle->uuid}.pdf");
    }

    /**
     * Download single vehicle details as Excel/CSV.
     */
    public function downloadExcel(string $id)
    {
        // find by uuid or id — match how your show() works
        $vehicle = Vehicle::where('uuid', $id)->firstOrFail();

        // XLSX:
        return Excel::download(new VehicleExport($vehicle), "vehicle-{$vehicle->uuid}.xlsx");
    }

    public function downloadCsv(string $id)
    {
        $vehicle = Vehicle::where('uuid', $id)->firstOrFail();

        // CSV:
        return Excel::download(new VehicleExport($vehicle), "vehicle-{$vehicle->uuid}.csv", \Maatwebsite\Excel\Excel::CSV);
    }

    public function downloadAllPdf()
    {
        $vehicles = Vehicle::all();

        $pdf = PDF::loadView('exports.vehicles_pdf', compact('vehicles'));
        return $pdf->download('vehicles-listing.pdf');
    }

    public function downloadAllExcel()
    {
        return Excel::download(new VehiclesExport, 'vehicles-listing.xlsx');
    }

    public function downloadAllCsv()
    {
        return Excel::download(new VehiclesExport, 'vehicles-listing.csv', \Maatwebsite\Excel\Excel::CSV);
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
