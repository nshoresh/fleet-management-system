<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiclesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        return Vehicle::all();
    }*/
        public function collection()
    {
        return Vehicle::with(['make', 'makeModel', 'makeType'])
            ->get()
            ->map(function ($vehicle) {
                return [
                    'License Plate'    => $vehicle->license_plate,
                    'VIN'             => $vehicle->vin,
                    'Make'            => $vehicle->make->name ?? 'N/A',
                    'Model'           => $vehicle->makeModel->name ?? 'N/A',
                    'Type'            => $vehicle->makeType->name ?? 'N/A',
                    'Payload Capacity'=> $vehicle->payload_capacity,
                    'Year'            => $vehicle->year,
                    'Status'          => ucfirst($vehicle->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'License Plate',
            'VIN',
            'Make',
            'Model',
            'Type',
            'Payload Capacity',
            'Year',
            'Status',
        ];
    }
}
