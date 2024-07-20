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
                                    <div class="px-4 text-light bg-danger py-3 mb-4">
                                        <ul class="">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <fieldset class="form-group">
                                        <label for="degree_programme" class="mb-2">Select Degree
                                            Programme</label>
                                        <select class="form-select" id="degreeSelect" name="degree_programme_id">
                                            <option value="" disabled selected>Select Degree</option>
                                            @foreach ($degrees as $degree)
                                                <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="degree_programme" class="mb-2">Select Subject</label>
                                        <select class="form-select" id="subjectSelect" name="subject_id" disabled>
                                            <option value="" disabled selected>Select Subject</option>
                                        </select>
                                    </fieldset>

                                    <div class="form-group">
                                        <label for="helperText">Title</label>
                                        <input type="text" id="helperText" name="title" class="form-control"
                                            placeholder="Name">
                                        {{-- <p><small class="text-muted">Enter the title.</small></p> --}}
                                    </div>


                                    <div class="form-group with-title mt-2 mb-3">
                                        {{-- <label for="degree_programme" class="mb-2"></label> --}}
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        <label>Enter a Description</label>
                                    </div>


                                    <div class="mb-4">
                                        <label class="block mb-2">Select Category</label>
                                        <div class="flex ">
                                            @foreach ($categories as $category)
                                                <label class="inline-flex items-center mb-2 sm:mb-0">
                                                    <input type="radio" name="category" value="{{ $category->id }}"
                                                        class="form-radio text-blue-600">
                                                    <span class="ml-2">{{ $category->name }}</span>
                                                </label>
                                            @endforeach
                                            {{-- <label class="inline-flex items-center mb-2 sm:mb-0">
                                                <input type="radio" name="category" value="lecture_notes"
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Lecture Notes</span>
                                            </label>
                                            <label class="inline-flex items-center mb-2 sm:mb-0">
                                                <input type="radio" name="category" value="presentations"
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Presentations</span>
                                            </label>
                                            <label class="inline-flex items-center mb-2 sm:mb-0">
                                                <input type="radio" name="category" value="tests"
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Tests</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="category" value="activities"
                                                    class="form-radio text-blue-600">
                                                <span class="ml-2">Activities</span>
                                            </label> --}}
                                        </div>
                                    </div>



                                    <div class="mb-4">
                                        <label for="file" class="">File
                                            Upload</label>
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <label for="files" id="drop-zone"
                                                class="d-flex flex-column align-items-center justify-content-center w-100 h-32 border border-dashed rounded-lg cursor-pointer transition-colors duration-200 ease-in-out">
                                                <div
                                                    class="d-flex flex-column align-items-center justify-content-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 " xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 1 1 8 0m-4 0V5m0 0a4 4 0 1 1 8 0m-8 4v4m0 4v4m0-4H3m8 0h8m-4-4h4m-4 4H7" />
                                                    </svg>
                                                    <p class="mb-2 text-muted"><span class="font-weight-semibold">Click to
                                                            upload</span> or drag and drop</p>
                                                    <p class="text-muted small">Only Upload PDF, DOCX, PPTX up to 50MB</p>
                                                </div>
                                                <input id="files" name="files[]" type="file" class="d-none" multiple>
                                            </label>
                                        </div>
                                        <div id="file-list" class="mt-4 text-muted small"></div>
                                    </div>

                                    <script>
                                        const dropZone = document.getElementById('drop-zone');
                                        const fileInput = document.getElementById('files');
                                        const fileList = document.getElementById('file-list');

                                        dropZone.addEventListener('dragover', (e) => {
                                            e.preventDefault();
                                            dropZone.classList.add('border-primary');
                                        });

                                        dropZone.addEventListener('dragleave', () => {
                                            dropZone.classList.remove('border-primary');
                                        });

                                        dropZone.addEventListener('drop', (e) => {
                                            e.preventDefault();
                                            dropZone.classList.remove('border-primary');
                                            fileInput.files = e.dataTransfer.files;
                                            updateFileList();
                                        });

                                        fileInput.addEventListener('change', updateFileList);

                                        function updateFileList() {
                                            fileList.innerHTML = '';
                                            for (let i = 0; i < fileInput.files.length; i++) {
                                                fileList.innerHTML += `<p>${fileInput.files[i].name}</p>`;
                                            }
                                        }
                                    </script>


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
                        url: '/degree-programmes/' + degreeId + '/subjects',
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
