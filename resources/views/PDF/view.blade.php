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
                                <th>Category</th>
                                <th>Subject</th>
                                <th>File Path</th>
                                <th>Status</th>
                                <th>Uploaded By</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>{{ $material->category->name }}</td>
                                    <td>{{ $material->subjects->subject_code . '-' . $material->subjects->name }}</td>

                                    <td><a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                            class="">
                                            {{ $material->file_path }}
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



                                    <td>{{ $material->user->name }}</td>
                                    <td>
                                        <form action="{{ route('upload.destroy', $material->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit"
                                                onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
