@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/filepond/filepond.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/auth/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
@endsection

@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>File Uploader</h3>
                    {{-- <p class="text-subtitle text-muted">Javascript enhanced uploaders for easier file handling.</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">File Uploader</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">

                <div class="col-12 col-md-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h5 class="card-title">Multiple Files</h5>
                        </div> --}}
                        <div class="card-content">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show px-4 py-3 mb-4"
                                        role="alert">
                                        <strong>Oops! Something went wrong:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <fieldset class="form-group">
                                        <label for="degreeSelect" class="mb-2">Select Degree Programme</label>
                                        <select class="form-select @error('degree_programme_id') is-invalid @enderror"
                                            id="degreeSelect" name="degree_programme_id">
                                            <option value="" disabled selected>Select Degree</option>
                                            @foreach ($degrees as $degree)
                                                <option value="{{ $degree->id }}"
                                                    {{ old('degree_programme_id') == $degree->id ? 'selected' : '' }}>
                                                    {{ $degree->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('degree_programme_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="subjectSelect" class="mb-2">Select Subject</label>
                                        <select class="form-select @error('subject_id') is-invalid @enderror"
                                            id="subjectSelect" name="subject_id" disabled>
                                            <option value="" disabled selected>Select Subject</option>
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </fieldset>

                                    <div class="form-group">
                                        <label for="helperText">Title</label>
                                        <input type="text" id="helperText" name="title"
                                            class="form-control @error('title') is-invalid @enderror" placeholder="Name">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group with-title mt-2 mb-3">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                            id="exampleFormControlTextarea1" rows="3"></textarea>
                                        <label>Enter a Description</label>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="block mb-2">Select Category</label>
                                        <div class="flex">
                                            @foreach ($categories as $category)
                                                <label class="inline-flex items-center mb-2 sm:mb-0">
                                                    <input type="radio" name="category" value="{{ $category->id }}"
                                                        class="form-radio @error('category') is-invalid @enderror text-blue-600">
                                                    <span class="ml-2">{{ $category->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('category')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="file" class="">File Upload</label>
                                        <div name="files[]" class="filepond--root multiple-files-filepond filepond--hopper"
                                            data-style-button-remove-item-position="left"
                                            data-style-button-process-item-position="right"
                                            data-style-load-indicator-position="right"
                                            data-style-progress-indicator-position="right"
                                            data-style-button-remove-item-align="false" style="height: 76px;">
                                            <input class="filepond--browser" type="file" id="filepond--browser-52d8cf0i6"
                                                name="files[]" aria-controls="filepond--assistant-52d8cf0i6"
                                                aria-labelledby="filepond--drop-label-52d8cf0i6" accept=""
                                                multiple="">
                                            <div class="filepond--drop-label"
                                                style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
                                                <label for="filepond--browser-52d8cf0i6" id="filepond--drop-label-52d8cf0i6"
                                                    aria-hidden="true">Drag &amp; Drop your files or <span
                                                        class="filepond--label-action" tabindex="0">Browse</span></label>
                                            </div>
                                            <div class="filepond--list-scroller"
                                                style="transform: translate3d(0px, 60px, 0px);">
                                                <ul class="filepond--list" role="list"></ul>
                                            </div>
                                            <div class="filepond--panel filepond--panel-root" data-scalable="true">
                                                <div class="filepond--panel-top filepond--panel-root"></div>
                                                <div class="filepond--panel-center filepond--panel-root"
                                                    style="transform: translate3d(0px, 8px, 0px) scale3d(1, 0.6, 1);">
                                                </div>
                                                <div class="filepond--panel-bottom filepond--panel-root"
                                                    style="transform: translate3d(0px, 68px, 0px);"></div>
                                            </div>
                                            <span class="filepond--assistant" id="filepond--assistant-52d8cf0i6"
                                                role="status" aria-live="polite" aria-relevant="additions"></span>
                                            <fieldset class="filepond--data"></fieldset>
                                            <div class="filepond--drip"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-start">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                @if (session('status'))
                                    <script>
                                        Swal.fire({
                                            icon: "success",
                                            title: "Added Successfully",
                                        });
                                    </script>
                                @endif



                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <script src="{{ asset('assets/auth/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#degreeSelect').on('change', function() {
                var degreeId = $(this).val();
                if (degreeId) {
                    $.ajax({
                        url: '/api/degree-programmes/' + degreeId + '/subjects',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#subjectSelect').empty().append(
                                '<option value="" disabled selected>Select Subject</option>'
                            );
                            $.each(data, function(key, subject) {
                                $('#subjectSelect').append('<option value="' + subject
                                    .id + '">' + subject.subject_code + " - " +
                                    subject.name + '</option>');
                            });
                            $('#subjectSelect').prop('disabled', false);
                        }
                    });
                } else {
                    $('#subjectSelect').empty().append(
                        '<option value="" disabled selected>Select Subject</option>').prop('disabled',
                        true);
                }
            });
        });
    </script>
@endsection

@section('scripts')
    <script
        src="{{ asset('assets/auth/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/auth/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/auth/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/auth/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/auth/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script src="{{ asset('assets/auth/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/auth/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script src="{{ asset('assets/auth/extensions/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/auth/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/filepond.js') }}"></script>

    <script src="{{ asset('assets/auth/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/form-element-select.js') }}"></script>
@endsection
