@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    PDF Datatable
                    <a class="btn btn-primary float-end" href="{{ route('ebook.UploadView') }}">Upload</a>

                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>ISBN</th>
                                <th>Category</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ebooks as $ebook)
                                <tr>
                                    <td><input class="form-check-input item-checkbox" type="checkbox"
                                            value="{{ $ebook->id }}"></td>
                                    <td><a href="{{ asset('storage/' . $ebook->file_path) }}" data-bs-toggle="tooltip"
                                            data-bs-original-title="Download Ebook">{{ $ebook->title }}</a></td>
                                    <td>{{ $ebook->description }}</td>
                                    <td>{{ $ebook->author }}</td>
                                    <td>{{ $ebook->publication_date }}</td>
                                    <td>{{ $ebook->isbn }}</td>
                                    <td>
                                        @foreach ($ebook->categories as $category)
                                            {{ $category->name }},
                                        @endforeach
                                    </td>


                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-sm btn-info me-1"
                                                href="{{ route('ebook.EditPage', $ebook->id) }}">Update</a>
                                            <form action="{{ route('ebook.destroy', $ebook->id) }}" method="POST"
                                                onsubmit="return submitForm(this);">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-start">
                        <input class="form-check-input ms-2" type="checkbox" id="select-all">
                        <button id="bulk-delete" class="btn btn-sm btn-danger ms-2">Delete Selected</button>
                    </div>

                </div>
            </div>
        </div>

        <script>
            // Select/Deselect all checkboxes
            $('#select-all').click(function() {
                $('.item-checkbox').prop('checked', this.checked);
            });

            // Handle bulk delete button click
            $('#bulk-delete').click(function() {
                let selected = [];

                $('.item-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('ebook.bulkDelete') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    ids: selected
                                },
                                success: function(response) {
                                    location.reload();
                                    Swal.fire({
                                        icon: "success",
                                        title: response.message,
                                    });
                                    // Reload the table after deletion
                                },
                                error: function(xhr) {
                                    alert('An error occurred');
                                }
                            });

                        }
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "No Items Selected",
                    });
                }
            });
        </script>

        <script>
            function submitForm(form) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the form submission
                        form.submit();
                    }
                });
                return false;
            }
        </script>



        @if (session('status'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Deleted Successfully",
                });
            </script>
        @endif

    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
