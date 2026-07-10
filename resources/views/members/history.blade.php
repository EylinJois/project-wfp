@extends('layouts.adminlte4')

@section('title', 'Consultation History')

@section('content')

    <div class="container">

        <div class="card mb-3">

            <div class="card-body">

                <h3 class="mb-1">Consultation History</h3>

                <p class="text-muted">
                    You have completed
                    <b>{{ $consultations->count() }}</b>
                    consultation(s).
                </p>

            </div>

        </div>
        <div class="card">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Summary</th>
                            <th width="120">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($consultations as $consultation)
                            <tr>

                                <td>
                                    <strong>{{ $consultation->formatted_date }}</strong>

                                    <br>

                                    <small class="text-muted">
                                        {{ $consultation->formatted_time }}
                                    </small>
                                </td>

                                <td>

                                    <strong>

                                        {{ $consultation->doctor->fullname }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $consultation->doctor->specialty->name ?? 'N/A' }}

                                    </small>

                                </td>

                                <td>

                                    {{ Str::limit($consultation->notes ?? 'No summary', 50) }}

                                </td>
                                <td>

                                    <a href="{{ route('member.history.detail', $consultation) }}"
                                        class="btn btn-outline-primary btn-sm">

                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    No consultation history.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
