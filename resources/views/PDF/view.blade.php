@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/toastify-js/src/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <script src="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/sweetalert2.js') }}"></script>


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
                                <th>Category</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>File Path</th>
                                <th>Uploaded By</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->category->name }}</td>
                                    <td>{{ $material->subjects->subject_code . '-' . $material->subjects->name }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td><a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="">
                                            {{ $material->file_path }}
                                        </a></td>
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
