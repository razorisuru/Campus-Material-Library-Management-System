@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">
    <style>
        #loader {
            display: none;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    SUMMARIZE
                </h5>
            </div>
            <div class="card-body">
                <form id="pdfForm"  enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="pdf">Upload PDF:</label>
                        <input type="file" name="pdf" id="pdf" required>
                    </div>



                    <div>
                        <label for="task">Select Task:</label>
                        <select name="task" id="task" required>
                            <option selected value="summarize">Summarize</option>
                            <option value="paraphrase">Paraphrase</option>
                            <option value="check_ai_written">Check AI-Written Content</option>
                            <option value="extract_text">Extract Text</option>
                            <option value="translate">Translate To Sinhala</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <button class="btn btn-warning" type="submit">Submit</button>
                </form>

                <div id="loader">
                    <img src="{{ asset('assets/auth/compiled/svg/rings.svg') }}" class="me-4" style="width: 3rem"
                        alt="audio">
                    <p>Please wait...</p>
                </div>

                <div id="summary" class="mt-2">
                    <!-- The summarized text will appear here -->
                    @isset($summary)
                        <p>{{ $summary }}</p>
                    @endisset
                </div>

                <script>
                    $(document).ready(function() {
                        $('#pdfForm').on('submit', function(e) {
                            e.preventDefault();

                            // Show the loader
                            $('#loader').show();
                            $('#summary').hide();

                            var formData = new FormData(this);

                            $.ajax({
                                url: "{{ route('Summarize.pdf') }}",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    // Hide the loader and display the summary
                                    $('#loader').hide();
                                    $('#summary').html('<p>' + response.summary + '</p>').show();
                                },
                                error: function(xhr, status, error) {
                                    $('#loader').hide();
                                    alert('An error occurred: ' + error);
                                }
                            });
                        });
                    });
                </script>
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
