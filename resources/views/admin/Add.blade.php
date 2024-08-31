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
                                                <div class="alert alert-danger alert-dismissible fade show px-4 py-3 mb-4"
                                                    role="alert">
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
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">First Name</label>
                                            <input type="text" id="first-name-column"
                                                class="form-control @error('fullName') is-invalid @enderror"
                                                placeholder="Full Name" name="fullName" value="{{ old('fullName') }}">
                                            @error('fullName')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="email" id="email-id-column"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                placeholder="Email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="role-column">Role</label>
                                            <select id="role-column"
                                                class="form-control @error('role') is-invalid @enderror" name="role">
                                                <option value="">Select Role</option>
                                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                                                    Student</option>
                                                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>
                                                    Teacher</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password-column">Password</label>
                                            <input type="password" id="password-column"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="Password">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>

                                    <script>
                                        // Add event listeners to input fields to remove 'is-invalid' class on user input
                                        document.querySelectorAll('.form-control').forEach(function(input) {
                                            input.addEventListener('input', function() {
                                                if (this.classList.contains('is-invalid')) {
                                                    this.classList.remove('is-invalid');
                                                }
                                            });
                                        });

                                        // Add event listener for select field (role) to remove 'is-invalid' class on change
                                        document.querySelector('#role-column').addEventListener('change', function() {
                                            if (this.classList.contains('is-invalid')) {
                                                this.classList.remove('is-invalid');
                                            }
                                        });
                                    </script>


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
