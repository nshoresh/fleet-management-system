<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehicleExport implements FromCollection, WithHeadings, WithMapping
{
    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Return a collection (single row) for export.
     */
    public function collection()
    {
        // Return a collection containing one model (so mapping runs once)
        return new Collection([$this->vehicle]);
    }

    /**
     * Map model to row array (order matters - match headings).
     */
    public function map($vehicle): array
    {
        return [
            $vehicle->license_plate ?? 'N/A',
            $vehicle->vin ?? 'N/A',
            ucfirst($vehicle->status ?? 'N/A'),
            $vehicle->relationLoaded('make') ? ($vehicle->make->name ?? 'N/A') : ($vehicle->make->name ?? 'N/A'),
            $vehicle->makeModel->name ?? 'N/A',
            $vehicle->year ?? 'N/A',
            $vehicle->makeType->name ?? 'N/A',
            $vehicle->makeOwner->name ?? 'N/A',
            $vehicle->color ?? 'N/A',
            $vehicle->engine_type ?? 'N/A',
            $vehicle->transmission_type ?? 'N/A',
            $vehicle->fuel_type ?? 'N/A',
            $vehicle->mileage ?? 'N/A',
            $vehicle->seating_capacity ?? 'N/A',
            $vehicle->vehicle_condition ?? 'N/A',
            $vehicle->engine_power ? $vehicle->engine_power . ' hp' : 'N/A',
            $vehicle->torque ? $vehicle->torque . ' Nm' : 'N/A',
            $vehicle->registration_date ? $vehicle->registration_date->format('Y-m-d') : 'N/A',
            $vehicle->insurance_status ?? 'N/A',
            $vehicle->last_service_date ? $vehicle->last_service_date->format('Y-m-d') : 'N/A',
            $vehicle->additional_features ?? 'N/A',
            $vehicle->gross_vehicle_weight ? $vehicle->gross_vehicle_weight . ' kg' : 'N/A',
            $vehicle->gross_trailer_weight ? $vehicle->gross_trailer_weight . ' kg' : 'N/A',
            $vehicle->payload_capacity ? $vehicle->payload_capacity . ' kg' : 'N/A',
            $vehicle->tire_capacity ?? 'N/A',
            $vehicle->axle_configuration ?? 'N/A',
            $vehicle->number_of_axles ?? 'N/A'
        ];
    }

    /**
     * Headings for the exported file (match map order).
     */
    public function headings(): array
    {
        return [
            'License Plate',
            'VIN',
            'Status',
            'Make',
            'Model',
            'Year',
            'Type',
            'Owner',
            'Color',
            'Engine Type',
            'Transmission',
            'Fuel Type',
            'Mileage',
            'Seating Capacity',
            'Condition',
            'Engine Power',
            'Torque',
            'Registration Date',
            'Insurance Status',
            'Last Service Date',
            'Additional Features',
            'Gross Vehicle Weight',
            'Gross Trailer Weight',
            'Payload Capacity',
            'Tire Capacity',
            'Axle Configuration',
            'Number of Axles',
        ];
    }
}
