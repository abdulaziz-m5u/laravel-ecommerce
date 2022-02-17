@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $slide->title }}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.slides.index') }}" class="btn btn-primary">
                        <span class="text">Back to slides</span>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Url</th>
                        <th>Body</th>
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $slide->title }}</td>
                        <td>{{ $slide->url }}</td>
                        <td>{{ $slide->body }}</td>
                        <td>{{ $slide->created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
