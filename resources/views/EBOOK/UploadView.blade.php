@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/filepond/filepond.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/auth/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/flatpickr/flatpickr.min.css') }}">
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
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Whoops! Something went wrong.</strong>
                                        <ul class="mt-2 mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('ebook.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror" placeholder="Name">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input type="text" id="author" name="author"
                                            class="form-control @error('author') is-invalid @enderror" placeholder="Author">
                                        @error('author')
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

                                    <div class="form-group">
                                        <label for="publication_date">Publication Date</label>
                                        <input type="text" name="publication_date"
                                            class="form-control mb-3 flatpickr-date flatpickr-input active @error('publication_date') is-invalid @enderror"
                                            placeholder="Select date.." readonly="readonly">
                                        @error('publication_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            flatpickr('.flatpickr-date', {
                                                dateFormat: 'Y-m-d',
                                                enableTime: false
                                            });
                                        });
                                    </script>

                                    <div class="form-group mb-2">
                                        <label for="isbn">ISBN</label>
                                        <input type="text" id="isbn" name="isbn"
                                            class="form-control @error('isbn') is-invalid @enderror" placeholder="ISBN">
                                        @error('isbn')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="categories">Categories</label>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($ebookCategories as $ebookCategory)
                                                <li class="d-inline-block me-2 mb-1">
                                                    <div class="form-check">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="category_{{ $ebookCategory->id }}"
                                                                class="form-check-input @error('ebookcategories') is-invalid @enderror"
                                                                name="ebookcategories[]" value="{{ $ebookCategory->id }}">
                                                            <label
                                                                for="category_{{ $ebookCategory->id }}">{{ $ebookCategory->name }}</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('ebookcategories')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="cover_image">Cover Image</label>
                                        <div name="cover_image"
                                            class="filepond--root image-preview-filepond filepond--hopper @error('cover_image') is-invalid @enderror"
                                            data-style-button-remove-item-position="left"
                                            data-style-button-process-item-position="right"
                                            data-style-load-indicator-position="right"
                                            data-style-progress-indicator-position="right"
                                            data-style-button-remove-item-align="false" style="height: 76px;">
                                            <input name="cover_image" class="filepond--browser" type="file"
                                                id="filepond--browser-j6fiedrjo"
                                                aria-controls="filepond--assistant-j6fiedrjo"
                                                aria-labelledby="filepond--drop-label-j6fiedrjo"
                                                accept="image/png,image/jpg,image/jpeg">
                                            <div class="filepond--drop-label"
                                                style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
                                                <label for="filepond--browser-j6fiedrjo"
                                                    id="filepond--drop-label-j6fiedrjo" aria-hidden="true">Drag &amp; Drop
                                                    your files or <span class="filepond--label-action"
                                                        tabindex="0">Browse</span></label>
                                            </div>
                                            <div class="filepond--list-scroller"
                                                style="transform: translate3d(0px, 0px, 0px);">
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
                                            <span class="filepond--assistant" id="filepond--assistant-j6fiedrjo"
                                                role="status" aria-live="polite" aria-relevant="additions"></span>
                                            <fieldset class="filepond--data"></fieldset>
                                            <div class="filepond--drip"></div>
                                        </div>
                                        @error('cover_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="ebook_file">File Upload</label>
                                        <div name="ebook_file"
                                            class="filepond--root multiple-files-filepond filepond--hopper @error('ebook_file') is-invalid @enderror"
                                            data-style-button-remove-item-position="left"
                                            data-style-button-process-item-position="right"
                                            data-style-load-indicator-position="right"
                                            data-style-progress-indicator-position="right"
                                            data-style-button-remove-item-align="false" style="height: 76px;">
                                            <input class="filepond--browser" type="file"
                                                id="filepond--browser-52d8cf0i6" name="ebook_file"
                                                aria-controls="filepond--assistant-52d8cf0i6"
                                                aria-labelledby="filepond--drop-label-52d8cf0i6" accept=""
                                                multiple="">
                                            <div class="filepond--drop-label"
                                                style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
                                                <label for="filepond--browser-52d8cf0i6"
                                                    id="filepond--drop-label-52d8cf0i6" aria-hidden="true">Drag &amp; Drop
                                                    your files or <span class="filepond--label-action"
                                                        tabindex="0">Browse</span></label>
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
                                        @error('ebook_file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="flex justify-start">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                @if (session('status'))
                                    <script>
                                        Swal.fire({
                                            icon: "success",
                                            title: "Success",
                                            text: "{{ session('status') }}"
                                        });
                                    </script>
                                @endif


                                <script>
                                    // Add event listeners to input fields to remove 'is-invalid' class on user input
                                    document.querySelectorAll('.form-control').forEach(function(input) {
                                        input.addEventListener('input', function() {
                                            if (this.classList.contains('is-invalid')) {
                                                this.classList.remove('is-invalid');
                                            }
                                        });
                                    });

                                    // Add event listener for checkboxes (categories) to remove 'is-invalid' class on change
                                    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
                                        checkbox.addEventListener('change', function() {
                                            if (this.classList.contains('is-invalid')) {
                                                this.classList.remove('is-invalid');
                                            }
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <script src="{{ asset('assets/auth/jquery-3.6.0.min.js') }}"></script>

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



    <script src="{{ asset('assets/auth/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/date-picker.js') }}"></script>

    <script src="{{ asset('assets/auth/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/form-element-select.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.querySelector('.choices');
            const choices = new Choices(element, {
                removeItemButton: true,
            });
        });
    </script>
@endsection
