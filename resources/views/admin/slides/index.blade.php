@extends('layouts.admin')

@section('content')
   <div class="container">
    <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Slides') }}
                </h6>
                <div class="ml-auto">
                    @can('slide_create')
                    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">{{ __('New slide') }}</span>
                    </a>
                    @endcan
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Position</th>
                        <th>Set Position</th>
                        <th class="text-center" style="width: 30px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($slides as $slide)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.slides.show', $slide) }}">
                                    {{ $slide->title }}
                                </a>
                            </td>
                            <td>
                                <img width="60" src="{{ Storage::url('images/slides/'. $slide->cover) }}" alt="">
                            </td>
                            <td>{{ $slide->position }}</td>
                            <td>
                                @if ($slide->prevSlide())
                                    <a href="{{ url('admin/slides/'. $slide->id .'/up') }}">up</a>
                                @else
                                    up
                                @endif
                                    | 
                                @if ($slide->nextSlide())
                                    <a href="{{ url('admin/slides/'. $slide->id .'/down') }}">down</a>
                                @else
                                    down
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form onclick="return confirm('are you sure !')" action="{{ route('admin.slides.destroy', $slide) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">No tags found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="float-right">
                                    {!! $slides->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
   </div>
@endsection
