@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/choices.js/public/assets/styles/choices.css') }}">
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
                                    <div class="px-4 text-light bg-danger py-3 mb-4">
                                        <ul class="">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('ebook.update', $ebook->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="helperText">Title</label>
                                        <input type="text" id="helperText" value="{{ $ebook->title }}" name="title"
                                            class="form-control" placeholder="Name">
                                        {{-- <p><small class="text-muted">Enter the title.</small></p> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="helperText">Author</label>
                                        <input type="text" id="helperText" value="{{ $ebook->author }}" name="author"
                                            class="form-control" placeholder="Author">
                                        {{-- <p><small class="text-muted">Enter the title.</small></p> --}}
                                    </div>


                                    <div class="form-group with-title mt-2 mb-3">
                                        {{-- <label for="degree_programme" class="mb-2"></label> --}}
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">{{ $ebook->description }}</textarea>
                                        <label>Enter a Description</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="helperText">Publication Date</label>
                                        <input type="text" name="publication_date"
                                            value="{{ $ebook->publication_date }}"
                                            class="form-control mb-3 flatpickr-date flatpickr-input active"
                                            placeholder="Select date.." readonly="readonly">
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
                                        <label for="helperText">ISBN</label>
                                        <input type="text" id="helperText" value="{{ $ebook->isbn }}" name="isbn"
                                            class="form-control" placeholder="ISBN">
                                        {{-- <p><small class="text-muted">Enter the title.</small></p> --}}
                                    </div>

                                    <div class="form-group">
                                        <div class="choices" data-type="select-multiple" role="combobox"
                                            aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                            <div class="choices__inner"><select
                                                    class="choices form-select multiple-remove choices__input"
                                                    multiple="multiple" hidden="" tabindex="-1" data-choice="active">
                                                    <option value="trapeze" data-custom-properties="[object Object]">Trapeze
                                                    </option>
                                                    <option value="blue" data-custom-properties="[object Object]">Blue
                                                    </option>
                                                </select>
                                                <div class="choices__list choices__list--multiple">
                                                    <div class="choices__item choices__item--selectable" data-item=""
                                                        data-id="1" data-value="trapeze"
                                                        data-custom-properties="[object Object]" aria-selected="true"
                                                        data-deletable="">Trapeze<button type="button"
                                                            class="choices__button" aria-label="Remove item: 'trapeze'"
                                                            data-button="">Remove item</button></div>
                                                    <div class="choices__item choices__item--selectable" data-item=""
                                                        data-id="2" data-value="blue"
                                                        data-custom-properties="[object Object]" aria-selected="true"
                                                        data-deletable="">Blue<button type="button"
                                                            class="choices__button" aria-label="Remove item: 'blue'"
                                                            data-button="">Remove item</button></div>
                                                </div><input type="search" name="search_terms"
                                                    class="choices__input choices__input--cloned" autocomplete="off"
                                                    autocapitalize="off" spellcheck="false" role="textbox"
                                                    aria-autocomplete="list" aria-label="null">
                                            </div>
                                            <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                                <div class="choices__list" aria-multiselectable="true" role="listbox">
                                                    <div class="choices__group " role="group" data-group=""
                                                        data-id="130249733500" data-value="Colors">
                                                        <div class="choices__heading">Colors</div>
                                                    </div>
                                                    <div id="choices--duyb-item-choice-6"
                                                        class="choices__item choices__item--choice choices__item--selectable is-highlighted"
                                                        role="treeitem" data-choice="" data-id="6" data-value="green"
                                                        data-select-text="Press to select" data-choice-selectable=""
                                                        aria-selected="true">Green</div>
                                                    <div id="choices--duyb-item-choice-8"
                                                        class="choices__item choices__item--choice choices__item--selectable"
                                                        role="treeitem" data-choice="" data-id="8"
                                                        data-value="purple" data-select-text="Press to select"
                                                        data-choice-selectable="">Purple</div>
                                                    <div id="choices--duyb-item-choice-5"
                                                        class="choices__item choices__item--choice choices__item--selectable"
                                                        role="treeitem" data-choice="" data-id="5" data-value="red"
                                                        data-select-text="Press to select" data-choice-selectable="">Red
                                                    </div>
                                                    <div class="choices__group " role="group" data-group=""
                                                        data-id="1051510405513" data-value="Figures">
                                                        <div class="choices__heading">Figures</div>
                                                    </div>
                                                    <div id="choices--duyb-item-choice-4"
                                                        class="choices__item choices__item--choice choices__item--selectable"
                                                        role="treeitem" data-choice="" data-id="4"
                                                        data-value="polygon" data-select-text="Press to select"
                                                        data-choice-selectable="">Polygon</div>
                                                    <div id="choices--duyb-item-choice-1"
                                                        class="choices__item choices__item--choice choices__item--selectable"
                                                        role="treeitem" data-choice="" data-id="1"
                                                        data-value="romboid" data-select-text="Press to select"
                                                        data-choice-selectable="">Romboid</div>
                                                    <div id="choices--duyb-item-choice-3"
                                                        class="choices__item choices__item--choice choices__item--selectable"
                                                        role="treeitem" data-choice="" data-id="3"
                                                        data-value="triangle" data-select-text="Press to select"
                                                        data-choice-selectable="">Triangle</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-2 d-flex flex-column">
                                        <label for="helperText">Current Cover Image</label>
                                        <img width="400px" class="img-fluid mb-2"
                                            src="{{ asset('storage/' . $ebook->cover_image) }}" alt="">
                                        <label for="helperText">Upload New Cover Image</label>
                                        <div name="cover_image"
                                            class="filepond--root image-preview-filepond filepond--hopper"
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
                                                style="transform: translate3d(0px, 0px, 0px); opacity: 1;"><label
                                                    for="filepond--browser-j6fiedrjo" id="filepond--drop-label-j6fiedrjo"
                                                    aria-hidden="true">Drag &amp; Drop your files or <span
                                                        class="filepond--label-action"
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
                                            </div><span class="filepond--assistant" id="filepond--assistant-j6fiedrjo"
                                                role="status" aria-live="polite" aria-relevant="additions"></span>
                                            <fieldset class="filepond--data"></fieldset>
                                            <div class="filepond--drip"></div>
                                        </div>
                                    </div>



                                    <div class="mb-4">
                                        <h5>File name : <a
                                                href="{{ asset('storage/' . $ebook->file_path) }}">{{ basename($ebook->file_path) }}</a>
                                        </h5>
                                        <label for="file" class="">NewFile
                                            Upload</label>
                                        <div class="mb-4">

                                            <div name="ebook_file" class="filepond--root basic-filepond filepond--hopper"
                                                data-style-button-remove-item-position="left"
                                                data-style-button-process-item-position="right"
                                                data-style-load-indicator-position="right"
                                                data-style-progress-indicator-position="right"
                                                data-style-button-remove-item-align="false" data-hopper-state="drag-drop"
                                                style="height: 76px;"><input class="filepond--browser" type="file"
                                                    id="filepond--browser-0w6ixqzbs"
                                                    aria-controls="filepond--assistant-0w6ixqzbs"
                                                    aria-labelledby="filepond--drop-label-0w6ixqzbs" accept=""
                                                    name="ebook_file">
                                                <div class="filepond--drop-label"
                                                    style="transform: translate3d(0px, 0px, 0px); opacity: 1;"><label
                                                        for="filepond--browser-0w6ixqzbs"
                                                        id="filepond--drop-label-0w6ixqzbs" aria-hidden="true">Drag &amp;
                                                        Drop your files or <span class="filepond--label-action"
                                                            tabindex="0">Browse</span></label></div>
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
                                                </div><span class="filepond--assistant" id="filepond--assistant-0w6ixqzbs"
                                                    role="status" aria-live="polite" aria-relevant="additions"></span>
                                                <fieldset class="filepond--data"></fieldset>
                                                <div class="filepond--drip"></div>
                                            </div>
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

    {{-- <script src="{{ asset('assets/auth/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/form-element-select.js') }}"></script> --}}

    <script src="{{ asset('assets/auth/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/date-picker.js') }}"></script>

    <script src="{{ asset('assets/auth/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/form-element-select.js') }}"></script>
@endsection
