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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
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
                        fetch(`{{ url('/category') }}/${categoryId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: newName
                            })
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                row.querySelector('.category-name').innerText = newName;
                                row.querySelector('.category-name').classList.remove('d-none');
                                row.querySelector('.category-input').classList.add('d-none');
                                this.classList.add('d-none');
                                row.querySelector('.edit-btn').classList.remove('d-none');
                                Swal.fire({
                                    icon: "success",
                                    title: "Update Success",
                                });
                            } else {
                                alert('Error updating category');
                            }
                        }).catch(error => {
                            alert('Error updating category');
                            console.error('Error:', error);
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
