@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-4">Articles</h1>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Title</th>
                            <th class="px-3 py-2">Date</th>
                            <th class="px-3 py-2">Content</th>
                            <th class="px-3 py-2">Image</th>
                            <th class="px-3 py-2">Doctor ID</th>
                            <th class="px-3 py-2">Created</th>
                            <th class="px-3 py-2">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td class="px-3 py-2">{{ $article->id }}</td>
                                <td class="px-3 py-2">{{ $article->title }}</td>
                                <td class="px-3 py-2">{{ $article->date }}</td>
                                <td class="px-3 py-2">{{ $article->content }}</td>
                                <td class="px-3 py-2">{{ $article->image }}</td>
                                <td class="px-3 py-2">{{ $article->doctor_id }}</td>
                                <td class="px-3 py-2">{{ $article->created_at }}</td>
                                <td class="px-3 py-2">{{ $article->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
