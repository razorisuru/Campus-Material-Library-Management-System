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
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Upload PDF:</label>
                        <input type="file" name="pdf" id="pdf" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="task" class="form-label">Select Task:</label>
                        <select name="task" id="task" class="form-select" required>
                            <option selected value="summarize">Summarize</option>
                            <option value="paraphrase">Paraphrase</option>
                            <option value="check_ai_written">Check AI-Written Content</option>
                            <option value="extract_text">Extract Text</option>
                            <option value="translate">Translate To Sinhala</option>
                        </select>
                    </div>

                    <button class="btn btn-warning w-100" type="submit">Submit</button>
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

                {{-- <script>
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
                </script> --}}

                <!-- Include pdfjs-dist -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('pdfForm');
                        const loader = document.getElementById('loader');
                        const summaryDiv = document.getElementById('summary');

                        // Hide loader initially
                        loader.style.display = 'none';

                        form.addEventListener('submit', function(event) {
                            event.preventDefault();

                            // Show loader and hide summary
                            loader.style.display = 'block';
                            summaryDiv.style.display = 'none';

                            const fileInput = document.getElementById('pdf');
                            const task = document.getElementById('task').value;

                            if (fileInput.files.length === 0) {
                                alert('Please upload a PDF file.');
                                return;
                            }

                            const file = fileInput.files[0];
                            const reader = new FileReader();

                            // Read the PDF as binary data
                            reader.readAsArrayBuffer(file);

                            reader.onload = function() {
                                const typedArray = new Uint8Array(reader.result);

                                // Load the PDF
                                pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
                                    let pdfText = '';

                                    // Read each page and extract the text
                                    const promises = [];
                                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                                        promises.push(
                                            pdf.getPage(pageNum).then(function(page) {
                                                return page.getTextContent().then(function(
                                                    textContent) {
                                                    let pageText = textContent.items.map(
                                                        item => item.str).join(' ');
                                                    pdfText += pageText +
                                                    '\n\n'; // Append the page text
                                                });
                                            })
                                        );
                                    }

                                    // Once all pages are read, process the text
                                    Promise.all(promises).then(function() {
                                        sendToAPI(pdfText, task);
                                    });
                                });
                            };
                        });

                        function sendToAPI(pdfText, task) {
                            // Create the content to send to the API based on the task
                            let content = `Perform the task '${task}' on this: ${pdfText}`;
                            if (task === 'summarize') {
                                content = `Summarize this: ${pdfText}`;
                            } else if (task === 'paraphrase') {
                                content = `Paraphrase this: ${pdfText}`;
                            } else if (task === 'check_ai_written') {
                                content = `Check if this content is AI-written: ${pdfText}`;
                            } else if (task === 'translate') {
                                content = `Translate this to Sinhala: ${pdfText}`;
                            }

                            // Send the content to the API (replace with your API key and URL)
                            fetch('https://api.pawan.krd/cosmosrp/v1', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Authorization': 'Bearer YOUR_API_KEY_HERE'
                                    },
                                    body: JSON.stringify({
                                        model: 'pai-001-light',
                                        messages: [{
                                            role: 'user',
                                            content: content
                                        }]
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Hide loader and display the summary
                                    loader.style.display = 'none';
                                    summaryDiv.innerHTML = `<p>${data.choices[0].message.content}</p>`;
                                    summaryDiv.style.display = 'block';
                                })
                                .catch(error => {
                                    loader.style.display = 'none';
                                    alert('An error occurred: ' + error.message);
                                });
                        }
                    });
                </script>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    CHAT
                </h5>
            </div>

            @if (session('error'))
                <p style="color: red;">{{ session('error') }}</p>
            @endif
            <div class="card-body">
                <form action="{{ route('openai.chat') }}" method="POST" class="p-4 rounded shadow-sm">
                    @csrf
                    <div class="mb-3">
                        <label for="prompt" class="form-label">Enter Prompt:</label>
                        <textarea name="prompt" id="prompt" rows="5" class="form-control" placeholder="Type your prompt here..."
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Chat</button>
                </form>



                <div id="loader">
                    <img src="{{ asset('assets/auth/compiled/svg/rings.svg') }}" class="me-4" style="width: 3rem"
                        alt="audio">
                    <p>Please wait...</p>
                </div>

                <div id="summary" class="mt-2 p-4 rounded shadow-sm">
                    <!-- The summarized text will appear here -->
                    @isset($chat)
                        <p>{{ $chat }}</p>
                    @endisset
                </div>


            </div>
        </div>






    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
