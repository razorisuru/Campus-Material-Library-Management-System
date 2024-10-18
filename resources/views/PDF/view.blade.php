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
                    <a class="btn btn-primary float-end" href="{{ route('upload.view') }}">Upload</a>
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
                                <th>Category</th>
                                <th>Degree</th>
                                <th>Subject</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Uploaded By</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td><input class="form-check-input item-checkbox" type="checkbox"
                                            value="{{ $material->id }}"></td>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>{{ $material->category->name }}</td>
                                    <td>{{ $material->degree->name }}</td>
                                    <td>{{ $material->subjects->subject_code . '-' . $material->subjects->name }}</td>

                                    <td><a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                            class="">
                                            {{ basename($material->file_path) }}
                                        </a></td>

                                    @if ($material->status == 'approved')
                                        <td>

                                            <div class="dropdown">
                                                <button class="badge bg-success border-0 dropdown-toggle me-1"
                                                    type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    {{ $material->status }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5"
                                                    style="">
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.pending', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <button type="submit"
                                                                class="btn btn-warning btn-sm">Pending</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.reject', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <input name="UserName" type="text"
                                                                value="{{ $material->user->name }}" hidden>
                                                            <input name="pdfName" type="text"
                                                                value="{{ basename($material->file_path) }}" hidden>
                                                            <input type="text" class="form-control" name="rejectReason"
                                                                placeholder="Reason">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm mt-1">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>
                                    @elseif ($material->status == 'pending')
                                        <td>

                                            <div class="dropdown">
                                                <button class="badge bg-warning border-0 dropdown-toggle me-1"
                                                    type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    {{ $material->status }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5"
                                                    style="">
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.approve', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <input name="UserName" type="text"
                                                                value="{{ $material->user->name }}" hidden>
                                                            <input name="pdfName" type="text"
                                                                value="{{ basename($material->file_path) }}" hidden>
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.reject', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <input name="UserName" type="text"
                                                                value="{{ $material->user->name }}" hidden>
                                                            <input name="pdfName" type="text"
                                                                value="{{ basename($material->file_path) }}" hidden>
                                                            <input type="text" class="form-control" name="rejectReason"
                                                                placeholder="Reason">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm mt-1">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @else
                                        <td>

                                            <div class="dropdown">
                                                <button class="badge bg-danger border-0 dropdown-toggle me-1"
                                                    type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    {{ $material->status }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5"
                                                    style="">
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.approve', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <input name="UserName" type="text"
                                                                value="{{ $material->user->name }}" hidden>
                                                            <input name="pdfName" type="text"
                                                                value="{{ basename($material->file_path) }}" hidden>
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.pending', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input name="uploaderMail" type="text"
                                                                value="{{ $material->user->email }}" hidden>
                                                            <button type="submit"
                                                                class="btn btn-warning btn-sm">Pending</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @endif



                                    <td>{{ $material->user->name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-sm btn-info me-1"
                                                href="{{ route('upload.EditPage', $material->id) }}">Update</a>
                                            <form action="{{ route('upload.destroy', $material->id) }}" method="POST"
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
                                url: '{{ route('material.bulkDelete') }}',
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
                    title: "{{ session('status') }}",
                });
            </script>
        @endif


    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
