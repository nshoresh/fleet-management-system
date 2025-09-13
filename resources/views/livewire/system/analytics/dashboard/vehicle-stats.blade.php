<div class="card">
    <div class="card-body">
        <h5 class="card-title">Vehicle Statistics</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-4 text-white card bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Vehicles</h5>
                        <h6 class="mb-2 text-white card-subtitle">{{ $totalVehicles }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4 text-white card bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Active Vehicles</h5>
                        <h6 class="mb-2 text-white card-subtitle">{{ $activeVehicles }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4 text-white card bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Inactive Vehicles</h5>
                        <h6 class="mb-2 text-white card-subtitle">{{ $inactiveVehicles }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
