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
                    PDF TOOLs
                </h5>
            </div>
            <div class="card-body">
                <form id="pdfForm" enctype="multipart/form-data" class="p-4 rounded shadow-sm">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-5 mb-3">
                            <label for="pdf" class="form-label">Upload PDF:</label>
                            <input type="file" name="pdf" id="pdf" class="form-control" required>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="task" class="form-label">Select Task:</label>
                            <select name="task" id="task" class="form-select" required>
                                <option selected value="summarize">Summarize</option>
                                <option value="paraphrase">Paraphrase</option>
                                <option value="check_ai_written">Check AI-Written Content</option>
                                <option value="extract_text">Extract Text</option>
                                <option value="translate">Translate To Sinhala</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3 d-grid">
                            <button class="btn btn-warning" type="submit">Submit</button>
                        </div>
                    </div>
                </form>



                <div id="loader">
                    <img src="{{ asset('assets/auth/compiled/svg/rings.svg') }}" class="me-4" style="width: 3rem"
                        alt="audio">
                    <p>Please wait...</p>
                </div>

                <div id="summary" class="mt-2 p-4 rounded shadow-sm">
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








    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
