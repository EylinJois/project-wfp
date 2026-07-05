@extends('layouts.adminlte4')

@section('content')
    <div class="container">

        <h3>My Schedule</h3>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Date</th>

                    <th>Time</th>

                    <th>Patient</th>

                    <th>Status</th>

                    <th></th>

                </tr>

            </thead>

            <tbody>

                @foreach ($consultations as $consultation)
                    <tr>

                        <td>{{ \Carbon\Carbon::parse($consultation->time)->format('d M Y') }}</td>

                        <td>{{ \Carbon\Carbon::parse($consultation->time)->format('H:i') }}</td>

                        <td>{{ $consultation->member->fullname }}</td>

                        <td>

                            @if ($consultation->status == 'pending')
                                <span class="badge bg-warning">

                                    Pending

                                </span>
                            @elseif($consultation->status == 'ongoing')
                                <span class="badge bg-primary">

                                    Ongoing

                                </span>
                            @else
                                <span class="badge bg-success">

                                    Done

                                </span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('doctor.consultation.show', $consultation) }}" class="btn btn-success btn-sm">

                                Open

                            </a>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>
@endsection
