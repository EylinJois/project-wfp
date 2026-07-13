@extends('layouts.adminlte4')

@section('menu-consultation', 'active')


@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
        </div>
    @endif

    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Book Consultation</h1>
                </div>
            </div>

        </div>
    </section>



    <section class="content">
        <div class="container-fluid">
            @if (!empty($activeConsultation))
                <div class="alert alert-info">

                    <h4>

                        Upcoming Consultation

                    </h4>

                    Doctor :

                    {{ $activeConsultation->doctor->fullname }}

                    <br>

                    Time :

                    {{ $activeConsultation->time }}

                    <br>

                    Status :

                    {{ ucfirst($activeConsultation->status) }}

                    <br><br>

                    <a href="{{ route('consultation.show', $activeConsultation->id) }}" class="btn btn-success">

                        Join Consultation

                    </a>

                </div>
            @endif
            <div class="row">

                <!-- LEFT SIDE : DOCTOR LIST -->
                <div class="col-md-4">

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                Doctors
                            </h3>
                        </div>

                        <div class="card-body">

                            @foreach ($doctors as $doctorItem)
                                <div class="card mb-3 shadow-sm">

                                    <div class="card-body">

                                        <div class="d-flex align-items-center">

                                            <img src="{{ asset('storage/photos/' . $doctorItem->photo) }}"
                                                class="rounded-circle shadow"
                                                style="width:70px;height:70px;object-fit:cover;">

                                            <div class="ms-3">

                                                <h5 class="mb-1">
                                                    {{ $doctorItem->fullname }}
                                                </h5>

                                                <p class="text-muted mb-2">
                                                    {{ $doctorItem->specialty->name ?? 'N/A' }}
                                                </p>

                                                <a href="{{ route('booking.showSchedule', $doctorItem->id) }}"
                                                    class="btn btn-primary btn-sm">

                                                    Select

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE : SCHEDULE + BOOKING -->
                <div class="col-md-8">

                    <div class="card card-success">

                        <div class="card-header">
                            <h3 class="card-title">
                                Schedule & Booking
                            </h3>
                        </div>

                        <div class="card-body">

                            @if (isset($doctor))
                                @if ($activeConsultation)

                                    <div class="alert alert-warning">

                                        You already have an active consultation.

                                        Please finish it before booking another consultation.

                                    </div>
                                @else
                                    <!-- DOCTOR INFO -->
                                    <div class="d-flex align-items-center mb-4">

                                        <img src="{{ asset('storage/photos/' . $doctor->photo) }}"
                                            class="rounded-circle shadow" style="width:90px;height:90px;object-fit:cover;">

                                        <div class="ms-3">

                                            <h3 class="mb-1">
                                                {{ $doctor->fullname }}
                                            </h3>

                                            <p class="text-muted mb-1">
                                                {{ $doctor->specialty->name ?? 'N/A' }}
                                            </p>

                                            <span class="badge bg-info">
                                                {{ $doctor->start_time }}
                                                -
                                                {{ $doctor->end_time }}
                                            </span>

                                        </div>

                                    </div>



                                    <!-- BOOKING FORM -->
                                    <!-- BOOKING FORM -->
                                    <form action="{{ route('booking.store') }}" method="POST">
                                    
                                        @csrf
                                    
                                        <!-- doctor -->
                                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                    
                                        <!-- member -->
                                        <input type="hidden" name="member_id" value="{{ Auth::user()->member_id }}">
                                    
                                        <!-- status -->
                                        <input type="hidden" name="status" value="pending">
                                    
                                        <!-- consultation type -->
                                        <input type="hidden" name="consultation_type" value="general consultation">
                                    
                                        <!-- DATE -->
                                        <div class="form-group mb-4">
                                    
                                            <label>
                                                Consultation Date
                                            </label>
                                    
                                            <input type="date" id="consultation_date" name="consultation_date"
                                                class="form-control" value="{{ $selectedDate }}"
                                                onchange="
                                    window.location='{{ route('booking.showSchedule', $doctor->id) }}?date='+this.value
                                    ">
                                    
                                        </div>
                                    
                                        <!-- AVAILABLE SCHEDULE -->
                                        <div class="mb-4">
                                    
                                            <label class="mb-3">
                                                Available Schedule
                                            </label>
                                    
                                            <div class="d-flex flex-wrap gap-2">
                                    
                                                @forelse($availableSchedules as $schedule)
                                                    <div class="form-check">
                                    
                                                        <input class="btn-check consultation-radio" type="radio"
                                                            value="{{ $schedule }}" name="schedule_radio"
                                                            id="schedule_{{ $schedule }}" required>
                                    
                                                        <label class="btn btn-outline-success"
                                                            for="schedule_{{ $schedule }}">
                                    
                                                            {{ $schedule }}
                                    
                                                        </label>
                                    
                                                    </div>
                                    
                                                @empty
                                    
                                                    <div class="alert alert-danger w-100">
                                    
                                                        No available schedule.
                                    
                                                    </div>
                                                @endforelse
                                    
                                            </div>
                                    
                                        </div>
                                    
                                        <!-- SUBMIT -->
                                        @if ($activeConsultation)
                                            <button class="btn btn-secondary" disabled>
                                    
                                                You already have an active consultation
                                    
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success">
                                    
                                                Confirm Booking
                                    
                                            </button>
                                        @endif
                                    
                                    </form>

                                        </div>

                                        <!-- AVAILABLE SCHEDULE -->
                                        <div class="mb-4">

                                            <label class="mb-3">
                                                Available Schedule
                                            </label>

                                            <div class="d-flex flex-wrap gap-2">

                                                @forelse($availableSchedules as $schedule)
                                                    <div class="form-check">

                                                        <input class="btn-check consultation-radio" type="radio"
                                                            value="{{ $schedule }}" name="schedule_radio"
                                                            id="schedule_{{ $schedule }}" required>

                                                        <label class="btn btn-outline-success"
                                                            for="schedule_{{ $schedule }}">

                                                            {{ $schedule }}

                                                        </label>

                                                    </div>

                                                @empty

                                                    <div class="alert alert-danger w-100">

                                                        No available schedule.

                                                    </div>
                                                @endforelse

                                            </div>

                                        </div>

                                        <!-- SUBMIT -->
                                        @if ($activeConsultation)
                                            <button class="btn btn-secondary" disabled>

                                                You already have an active consultation

                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success">

                                                Confirm Booking

                                            </button>
                                        @endif

                                    </form>
                                @endif
                            @else
                                <div class="alert alert-info">

                                    Please select a doctor from the left panel.

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
