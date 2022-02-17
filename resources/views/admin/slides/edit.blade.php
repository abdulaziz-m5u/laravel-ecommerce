@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Edit slide')}}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">{{ __('Back to slides') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">title</label>
                                <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $slide->title) }}">
                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="url">url</label>
                                <input class="form-control" id="url" type="text" name="url" value="{{ old('url', $slide->url) }}">
                                @error('url')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label for="body" class="text-small text-uppercase">{{ __('body') }}</label>
                            <textarea name="body" rows="3" class="form-control summernote">{!! old('body', $slide->body) !!}</textarea>
                                @error('body')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12">
                            <label for="cover">Cover image</label><br>
                            @if($slide->cover)
                                <img
                                    class="mb-2"
                                    src="{{ Storage::url('images/slides/' . $slide->cover) }}"
                                    alt="{{ $slide->name }}" width="100" height="100">
                            @else
                               <span class="badge badge-info">No image</span>
                            @endif
                            <br>
                            <div class="file-loading">
                                <input type="file" name="cover" id="slide-img" class="file-input-overview">
                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
                            </div>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group pt-4">
                        <button class="btn btn-primary" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-alt')
    <script>
        $(function () {
            // summernote
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            })

            // file input
            $("#slide-img").fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });
            
        });
    </script>
@endpush