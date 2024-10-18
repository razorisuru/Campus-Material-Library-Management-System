@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5 class="float-start">
                        Category
                    </h5>
                    <form method="POST" action="{{ route('category.store') }}">
                        @csrf

                        <button type="submit" class="btn btn-primary float-end ms-2">Add</button>
                        <div class="form-group float-end">
                            {{-- <label for="helperText">Title</label> --}}
                            <input type="text" id="name" name="category_name" class="form-control"
                                placeholder="Name">
                            {{-- <p><small class="text-muted">Enter the title.</small></p> --}}
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger text-sm">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td><input class="form-check-input item-checkbox" type="checkbox"
                                            value="{{ $category->id }}"></td>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <span class="category-name">{{ $category->name }}</span>
                                        <input type="text" class="form-control category-input d-none"
                                            value="{{ $category->name }}">
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm edit-btn" type="button">Edit</button>
                                        <button class="btn btn-success btn-sm save-btn d-none" type="button">Save</button>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            class="d-inline" onsubmit="return submitForm(this);">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                        </form>
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
                                url: '{{ route('category.bulkDelete') }}',
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        row.querySelector('.category-name').classList.add('d-none');
                        row.querySelector('.category-input').classList.remove('d-none');
                        this.classList.add('d-none');
                        row.querySelector('.save-btn').classList.remove('d-none');
                    });
                });

                document.querySelectorAll('.save-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const input = row.querySelector('.category-input');
                        const newName = input.value;
                        const categoryId = row.querySelector('td:first-child').innerText;

                        // Make an AJAX request to update the category name
                        fetch(`/category-update/${categoryId}`, {
                                method: 'put',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    name: newName
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Update UI
                                } else {
                                    alert('Error updating category');
                                }
                            })
                            .catch(error => {
                                console.error('There has been a problem with your fetch operation:',
                                    error);
                            });

                    });
                });
            });
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
