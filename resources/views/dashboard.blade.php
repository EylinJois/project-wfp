@extends('layouts.adminlte4')

@section('menu-consultation', 'active')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Dashboard</h1>

    <!-- STAT CARDS -->
    <div class="row g-3 mb-4">

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Doctors</div>
                            <div class="fs-3 fw-bold">{{ $totalDoctors }}</div>
                        </div>
                        <i class="fas fa-user-md fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Members</div>
                            <div class="fs-3 fw-bold">{{ $totalMembers }}</div>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Articles</div>
                            <div class="fs-3 fw-bold">{{ $totalArticles }}</div>
                        </div>
                        <i class="fas fa-newspaper fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-secondary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Bookings</div>
                            <div class="fs-3 fw-bold">{{ $totalBookings }}</div>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Ongoing</div>
                            <div class="fs-3 fw-bold">{{ $totalOngoing }}</div>
                        </div>
                        <i class="fas fa-spinner fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="card text-white bg-dark shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-uppercase">Done</div>
                            <div class="fs-3 fw-bold">{{ $totalDone }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>

// Status breakdown - Pie Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Ongoing', 'Done'],
        datasets: [{
            data: [
                {{ $statusBreakdown['pending'] }},
                {{ $statusBreakdown['ongoing'] }},
                {{ $statusBreakdown['done'] }}
            ],
            backgroundColor: ['#ffc107', '#0d6efd', '#198754']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Consultation type breakdown - Bar Chart
new Chart(document.getElementById('typeChart'), {
    type: 'bar',
    data: {
        labels: ['General Consultation', 'Specialist Consultation'],
        datasets: [{
            label: 'Total Consultations',
            data: [
                {{ $typeBreakdown['general consultation'] }},
                {{ $typeBreakdown['specialist consultation'] }}
            ],
            backgroundColor: ['#0dcaf0', '#6f42c1']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});

// Booking trend - Line Chart
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: @json($bookingTrendLabels),
        datasets: [{
            label: 'Bookings',
            data: @json($bookingTrendData),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.15)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});

</script>
@endpush