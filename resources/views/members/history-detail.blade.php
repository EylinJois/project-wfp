@extends('layouts.adminlte4')

@section('title', 'Consultation Detail')

@section('content')

    <div class="container">

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">

                    Consultation Detail

                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">Doctor</label>

                        <p>{{ $consultation->doctor->fullname }}</p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">Date</label>

                        <p>{{ date('d F Y H:i', strtotime($consultation->time)) }}</p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">Status</label>

                        <span class="badge bg-success">

                            Finished

                        </span>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">

                            Consultation Type

                        </label>

                        <p>

                            {{ ucfirst($consultation->consultation_type) }}

                        </p>

                    </div>

                    <div class="col-12">

                        <label class="fw-bold">

                            Summary

                        </label>

                        <div class="border rounded p-3 bg-light">

                            {{ $consultation->notes ?: 'No summary available.' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card mt-3">

            <div class="card-header">

                <h4>Conversation History</h4>

            </div>

            <div class="card-body">

                @forelse($consultation->chats as $chat)
                    @if ($chat->sender_role == 'member')
                        <div class="text-end mb-3">

                            <small class="text-muted">
                                You
                            </small>

                            <div class="d-flex justify-content-end mb-3">

                                <div class="bg-primary text-white rounded p-3" style="max-width:70%;">

                                    {{ $chat->chat }}

                                </div>

                            </div>

                        </div>
                    @else
                        <div class="text-start mb-3">

                            <small class="text-muted">
                                {{ $consultation->doctor->fullname }}
                            </small>

                            <div class="d-flex justify-content-start mb-3">

                                <div class="bg-light border rounded p-3" style="max-width:70%;">

                                    {{ $chat->chat }}

                                </div>

                            </div>

                        </div>
                    @endif

                @empty

                    <p class="text-center">

                        No conversation history.

                    </p>
                @endforelse

            </div>

        </div>

        <a href="{{ route('member.history') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

@endsection
