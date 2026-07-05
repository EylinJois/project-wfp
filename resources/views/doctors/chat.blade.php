@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h3>
                    Consultation with
                    {{ $consultation->member->fullname }}
                </h3>

            </div>

            <div class="card-body">

                <p>

                    Status :
                    {{ ucfirst($consultation->status) }}

                </p>

                <hr>

                @foreach ($consultation->chats as $chat)
                    @if ($chat->sender_role == 'doctor')
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <div class="bg-primary text-white rounded p-2">
                                    {{ $chat->chat }}
                                </div>

                                <small class="text-muted">
                                    {{ $chat->delivered_at->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-start mb-3">
                            <div>
                                <div class="bg-light border rounded p-2">
                                    {{ $chat->chat }}
                                </div>

                                <small class="text-muted">
                                    {{ $chat->delivered_at->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    @endif
                @endforeach

                <hr>
                @if ($consultation->status == 'ongoing')
                    <form action="{{ route('chat.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">

                        <div class="input-group">

                            <input class="form-control" name="chat" placeholder="Type message...">

                            <button class="btn btn-success">

                                Send

                            </button>

                        </div>

                    </form>
                @else
                    <div class="alert alert-warning">
                        The consultation is not ongoing. You cannot send messages.
                    </div>
                @endif
            </div>

        </div>

    </div>
    <script>
        window.onload = function() {
            window.scrollTo(0, document.body.scrollHeight);
        }
    </script>
@endsection
