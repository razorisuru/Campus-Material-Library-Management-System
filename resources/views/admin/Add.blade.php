@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add User</h4>
                    </div>


                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="{{ route('admin.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            @if ($errors->any())
                                                <div class="px-4 text-light bg-danger py-3 mb-4">
                                                    <ul class="">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">First Name</label>
                                            <input type="text" id="first-name-column" class="form-control"
                                                placeholder="Full Name" name="fullName">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="email" id="email-id-column" class="form-control" name="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="role-column">Role</label>
                                            <select id="role-column" class="form-control" name="role">
                                                <option value="student">Student</option>
                                                <option value="teacher">Teacher</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="password" id="email-id-column" class="form-control"
                                                name="password" placeholder="Password">
                                        </div>
                                    </div>


                                    <div class="col-12 mt-4 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>

                                    {{-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="company-column">Company</label>
                                            <input type="text" id="company-column" class="form-control"
                                                name="company-column" placeholder="Company">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox5" class="form-check-input"
                                                    checked="">
                                                <label for="checkbox5">Remember Me</label>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                            </form>
                        </div>
                    </div>
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
