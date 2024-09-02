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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Add Degree</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false" tabindex="-1">Add Subjects</a>
                            </li>

                        </ul>
                    </div>




                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" action="{{ route('degree.store') }}" method="POST">
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
                                                    <label for="name-column">Name</label>
                                                    <input type="text" id="name-column"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Name" name="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label>Enter a Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                                        id="exampleFormControlTextarea1" rows="3">{{ old('description') }}</textarea>

                                                    @error('description')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="col-12 mt-4 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
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



                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="col-12">
                                <div class="card">



                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form" action="{{ route('degree.SubjectStore') }}" method="POST">
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
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="role-column">Select Degree</label>
                                                            <select id="role-column"
                                                                class="form-control @error('degree_id') is-invalid @enderror"
                                                                name="degree_id">
                                                                <option value="">Select Degree</option>
                                                                @foreach ($degrees as $degree)
                                                                    <option value=" {{ $degree->id }}">
                                                                        {{ $degree->id }} - {{ $degree->name }}</option>
                                                                @endforeach


                                                            </select>
                                                            @error('degree_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="subject_code-column">Subject Code</label>
                                                            <input type="text" id="subject_code-column"
                                                                class="form-control @error('subject_code') is-invalid @enderror"
                                                                placeholder="Subject Code" name="subject_code"
                                                                value="{{ old('subject_code') }}">
                                                            @error('subject_code')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="name-column">Name</label>
                                                            <input type="text" id="name-column"
                                                                class="form-control @error('subject_name') is-invalid @enderror"
                                                                placeholder="subject_name" name="subject_name"
                                                                value="{{ old('subject_name') }}">
                                                            @error('subject_name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label>Enter a Description</label>
                                                            <textarea class="form-control @error('subject_description') is-invalid @enderror" name="subject_description"
                                                                id="exampleFormControlTextarea1" rows="3">{{ old('subject_description') }}</textarea>

                                                            @error('subject_description')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>



                                                    <div class="col-12 mt-4 d-flex justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary me-1 mb-1">Submit</button>
                                                        <button type="reset"
                                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
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



                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    title: "Success",
                    text: "{{ session('status') }}"
                });
            </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if a tab is stored in local storage
                const activeTab = localStorage.getItem('activeTab');

                if (activeTab) {
                    // Remove the 'active' class from all tabs and content
                    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(content => content.classList.remove('show',
                        'active'));

                    // Add the 'active' class to the stored tab and its content
                    const activeLink = document.querySelector(`a[href="${activeTab}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                        document.querySelector(activeTab).classList.add('show', 'active');
                    }
                }

                // Store the active tab in local storage when a tab is clicked
                document.querySelectorAll('.nav-link').forEach(tab => {
                    tab.addEventListener('shown.bs.tab', function(e) {
                        localStorage.setItem('activeTab', e.target.getAttribute('href'));
                    });
                });

                // Store the active tab when the form is submitted
                const subjectForm = document.getElementById('subject-form');
                subjectForm.addEventListener('submit', function() {
                    localStorage.setItem('activeTab', '#profile');
                });
            });
        </script>

    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
