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
                    Degree Datatable
                    <a class="btn btn-primary float-end" href="{{ route('degree.add') }}">Add</a>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Subjects</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($degrees as $degree)
                                <tr>

                                    <td>{{ $degree->id }}</td>
                                    <td>{{ $degree->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($degree->subjects as $subject)
                                                <li>{{ $subject->subject_code }} {{ $subject->name }} </li>
                                            @endforeach
                                        </ul>
                                    </td>


                                    <td>
                                        {{-- <div class="d-flex">
                                            <a class="btn btn-sm btn-info me-1"
                                                href="{{ route('ebook.EditPage', $degree->id) }}">Update</a>
                                            <form action="{{ route('ebook.destroy', $degree->id) }}" method="POST"
                                                onsubmit="return submitForm(this);">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                            </form>
                                        </div> --}}
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
