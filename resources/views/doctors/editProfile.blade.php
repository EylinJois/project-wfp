@extends('layouts.adminlte4')

@section('content')

<div class="content-wrapper">

    <section class="content pt-4">
        <div class="container-fluid">

            <div class="card shadow-sm">

                <!-- Header -->
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">
                        Edit Profile
                    </h3>
                </div>

                <!-- Form -->
                <form action="{{ route('doctor.updateProfile', $doctor->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <!-- Photo -->
                            <div class="col-md-4 text-center mb-4">

                                <img src="{{ asset('storage/photos/' . $doctor->photo) }}"
                                    class="img-fluid rounded shadow mb-3"
                                    style="max-width: 250px;">

                                <div class="form-group text-start">
                                    <label>Photo</label>

                                    <input type="file"
                                        accept="image/*"
                                        name="photo"
                                        class="form-control">
                                </div>

                            </div>

                            <!-- Form Input -->
                            <div class="col-md-8">

                                <div class="row">

                                    <!-- Full Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Full Name
                                        </label>

                                        <input type="text"
                                            name="fullname"
                                            class="form-control"
                                            value="{{ old('fullname', $doctor->fullname) }}">
                                    </div>

                                    <!-- SIP -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            SIP
                                        </label>

                                        <input type="text"
                                            name="sip"
                                            class="form-control"
                                            value="{{ old('sip', $doctor->sip) }}">
                                    </div>

                                    <!-- Experience -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Experience
                                        </label>

                                        <input type="text"
                                            name="experience"
                                            class="form-control"
                                            value="{{ old('experience', $doctor->experience) }}">
                                    </div>

                                    <!-- Specialization -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Specialization
                                        </label>

                                        <select name="specialty_id"
                                            class="form-control">

                                            @foreach ($specialties as $specialty)

                                            <option value="{{ $specialty->id }}"
                                                {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>

                                                {{ $specialty->name }}

                                            </option>

                                            @endforeach

                                        </select>
                                    </div>

                                    <!-- Start Time -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            Start Practice
                                        </label>

                                        <input type="time"
                                            name="start_time"
                                            class="form-control"
                                            value="{{ old('start_time', $doctor->start_time) }}">
                                    </div>

                                    <!-- End Time -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">
                                            End Practice
                                        </label>

                                        <input type="time"
                                            name="end_time"
                                            class="form-control"
                                            value="{{ old('end_time', $doctor->end_time) }}">
                                    </div>

                                </div>

                                @session('success')
                                <div class="alert alert-success alert-dismissible">
                                    {{ session('success') }}
                                </div>
                                @endsession

                                <!-- Buttons -->
                                <div class="mt-4">

                                    <button type="submit"
                                        class="btn btn-success">
                                        Save Changes
                                    </button>

                                    <a href="{{ route('doctor.index') }}"
                                        class="btn btn-secondary">
                                        Back
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </section>

</div>

@endsection