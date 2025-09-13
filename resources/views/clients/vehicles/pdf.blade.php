<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Specification Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 0; 
            padding: 0; 
            color: #333; 
        }
        .header { 
            text-align: center; 
            padding: 20px; 
            border-bottom: 2px solid #d6b900; 
        }
        .header img { 
            max-height: 60px; 
            margin-bottom: 8px; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 22px; 
            font-weight: bold; 
        }
        .table-container {
            width: 100%;
            padding: 20px;
            padding-right: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 6px 8px;
            border: 1px solid #e7cb30;
        }
        th {
            background-color: #fff09c;
            font-weight: bold;
            width: 25%; /* Label column width */
        }
        td {
            width: 25%; /* Value column width */
        }
        h2 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 16px;
            color: #222;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('logo.png') }}" alt="Company Logo">
        <h1>Vehicle Specification Report</h1>
    </div>

    <div class="table-container">

        <!-- Basic Information -->
        <h2>Basic Information</h2>
        <table>
            <tr>
                <th>License Plate</th>
                <td>{{ $vehicle->license_plate }}</td>
                <th>VIN</th>
                <td>{{ $vehicle->vin }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($vehicle->status) }}</td>
                <th>Make</th>
                <td>{{ $vehicle->make->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $vehicle->makeModel->name ?? 'N/A' }}</td>
                <th>Year</th>
                <td>{{ $vehicle->year }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $vehicle->makeType->name ?? 'N/A' }}</td>
                <th>Owner</th>
                <td>{{ $vehicle->makeOwner->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Color</th>
                <td>{{ $vehicle->color ?? 'N/A' }}</td>
                <th></th>
                <td></td>
            </tr>
        </table>

        <!-- Technical Information -->
        <h2>Technical Information</h2>
        <table>
            <tr>
                <th>Engine Type</th>
                <td>{{ $vehicle->engine_type ?? 'N/A' }}</td>
                <th>Transmission</th>
                <td>{{ $vehicle->transmission_type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fuel Type</th>
                <td>{{ $vehicle->fuel_type ?? 'N/A' }}</td>
                <th>Mileage</th>
                <td>{{ $vehicle->mileage ?? 'N/A' }} km</td>
            </tr>
            <tr>
                <th>Seating Capacity</th>
                <td>{{ $vehicle->seating_capacity ?? 'N/A' }}</td>
                <th>Condition</th>
                <td>{{ $vehicle->vehicle_condition ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Engine Power</th>
                <td>{{ $vehicle->engine_power ? $vehicle->engine_power.' hp' : 'N/A' }}</td>
                <th>Torque</th>
                <td>{{ $vehicle->torque ? $vehicle->torque.' Nm' : 'N/A' }}</td>
            </tr>
        </table>

        <!-- Heavy Vehicle Specifications -->
        @if ($vehicle->gross_vehicle_weight || $vehicle->payload_capacity || $vehicle->number_of_axles)
        <h2>Heavy Vehicle Specifications</h2>
        <table>
            <tr>
                <th>Gross Vehicle Weight</th>
                <td>{{ $vehicle->gross_vehicle_weight ? $vehicle->gross_vehicle_weight.' kg' : 'N/A' }}</td>
                <th>Gross Trailer Weight</th>
                <td>{{ $vehicle->gross_trailer_weight ? $vehicle->gross_trailer_weight.' kg' : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Payload Capacity</th>
                <td>{{ $vehicle->payload_capacity ? $vehicle->payload_capacity.' kg' : 'N/A' }}</td>
                <th>Tire Capacity</th>
                <td>{{ $vehicle->tire_capacity ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Axle Configuration</th>
                <td>{{ $vehicle->axle_configuration ?? 'N/A' }}</td>
                <th>Number of Axles</th>
                <td>{{ $vehicle->number_of_axles ?? 'N/A' }}</td>
            </tr>
        </table>
        @endif

        <!-- Additional Information -->
        <h2>Additional Information</h2>
        <table>
            <tr>
                <th>Registration Date</th>
                <td>N/A</td>
                <th>Insurance Status</th>
                <td>{{ $vehicle->insurance_status ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Last Service Date</th>
                <td>N/A</td>
                <th>Additional Features</th>
                <td>{{ $vehicle->additional_features ?? 'N/A' }}</td>
            </tr>
        </table>

    </div>
    
    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} Your Company Name | Confidential Vehicle Report
    </div>

</body>
</html>
