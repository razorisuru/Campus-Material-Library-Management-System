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
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
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

                                    {{-- <td><a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
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
                                                            <button type="submit"
                                                                class="btn btn-warning btn-sm">Pending</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.reject', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Reject</button>
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
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.reject', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @else
                                        <td>

                                            <div class="dropdown">
                                                <button class="badge bg-danger border-0 dropdown-toggle me-1" type="button"
                                                    id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    {{ $material->status }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5"
                                                    style="">
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.approve', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    </div>
                                                    <div class="dropdown-item">
                                                        <form action="{{ route('materials.pending', $material->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-warning btn-sm">Pending</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @endif



                                    <td>{{ $material->user->name }}</td> --}}
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
                </div>
            </div>
        </div>

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
