@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Permissions') }}</h1>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
    </div>

    <!-- Content Row -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->title }}</td>
                                <td>
                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form onclick="return alert('are you sure ? ')" class="d-inline" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('Data Empty') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $permissions->links() }}
            </div>
        </div>
    <!-- Content Row -->

</div>
@endsection