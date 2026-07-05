@extends('layouts.adminlte4')

@section('content')
    <div class="container">

        <div class="card">
            <div class="mb-3">

                <a href="?status=all" class="btn btn-secondary">

                    All

                </a>

                <a href="?status=pending" class="btn btn-warning">

                    Pending

                </a>

                <a href="?status=ongoing" class="btn btn-primary">

                    Ongoing

                </a>

                <a href="?status=done" class="btn btn-success">

                    Finished

                </a>

            </div>
            <div class="card-header">
                <h3>My Consultations</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Chat</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($consultations as $consultation)
                            <tr>

                                <td>{{ $consultation->member->fullname }}</td>

                                <td>{{ $consultation->time }}</td>

                                <td>{{ ucfirst($consultation->status) }}</td>

                                <td>

                                    <a href="{{ route('doctor.consultation.show', $consultation) }}"
                                        class="btn btn-primary btn-sm">
                                        Open
                                    </a>

                                </td>

                                <td>

                                    @if ($consultation->status == 'pending')
                                        <form action="{{ route('doctor.consultation.start', $consultation) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-success btn-sm">
                                                Start
                                            </button>

                                        </form>
                                    @elseif($consultation->status == 'ongoing')
                                        <form action="{{ route('doctor.consultation.finish', $consultation) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-danger btn-sm">
                                                Finish
                                            </button>

                                        </form>
                                    @else
                                        <span class="badge bg-success">
                                            Finished
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    No consultations.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
