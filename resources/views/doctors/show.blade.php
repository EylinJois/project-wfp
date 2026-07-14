@extends('layouts.adminlte4')

@section('menu-doctors', 'active')

@section('content')

    <div class="content-wrapper">

        <section class="content pt-4">
            <div class="container-fluid">

                <div class="card shadow-sm">

                    <!-- Header -->
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">
                            Doctor Detail
                        </h3>
                    </div>

                    <!-- Body -->
                    <div class="card-body">

                        <div class="row">

                            <!-- Photo -->
                            <div class="col-md-4 text-center mb-4">

                                <img src="{{ asset('storage/photos/' . $doctor->photo) }}" class="img-fluid rounded shadow"
                                    style="max-width: 250px;">

                                <h4 class="mt-3 font-weight-bold">
                                    {{ $doctor->fullname }}
                                </h4>

                                <p class="text-muted">
                                    {{ $doctor->specialty->name ?? 'N/A' }}
                                </p>

                            </div>

                            <!-- Information -->
                            <div class="col-md-8">

                                <div class="row">

                                    @if (Auth::user()->role == 'admin')
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">
                                                ID
                                            </label>

                                            <div class="border rounded p-3 bg-light pl-4">
                                                {{ $doctor->id }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Full Name
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->fullname }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            SIP
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->sip }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Experience
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->experience }}
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Specialization
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->specialty->name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Start Practice
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->start_time }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            End Practice
                                        </label>

                                        <div class="border rounded p-3 bg-light pl-4">
                                            {{ $doctor->end_time }}
                                        </div>
                                    </div>

                                    @if (Auth::user()->role == 'admin')
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">
                                                Created At
                                            </label>

                                            <div class="border rounded p-3 bg-light pl-4">
                                                {{ $doctor->created_at }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">
                                                Updated At
                                            </label>

                                            <div class="border rounded p-3 bg-light pl-4">
                                                {{ $doctor->updated_at }}
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <!-- Button -->
                                <div class="mt-4">
                                    <a href="{{ route('doctor.index') }}" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>

    </div>

@endsection
