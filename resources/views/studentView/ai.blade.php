<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        #loader {
            display: none;
            text-align: center;
        }
    </style>






    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <div class="layout-content-container flex flex-col flex-1">
                        <div class="flex flex-wrap justify-between gap-3 p-4">
                            <p class="text-[#0e141b] tracking-light text-[32px] font-bold leading-tight min-w-72">
                                PDF TOOLS</p>
                        </div>


                    </div>


                    <form id="pdfForm" enctype="multipart/form-data" class="p-4 rounded shadow-sm">
                        @csrf
                        <div class="mb-3">
                            <label for="pdf" class="form-label block mb-2">Upload PDF:</label>
                            <input type="file" name="pdf" id="pdf" class="form-control w-full" required>
                        </div>

                        <div class="mb-3">
                            <label for="task" class="form-label block mb-2">Select Task:</label>
                            <select name="task" id="task" class="form-select w-full" required>
                                <option selected value="summarize">Summarize</option>
                                <option value="paraphrase">Paraphrase</option>
                                <option value="check_ai_written">Check AI-Written Content</option>
                                <option value="extract_text">Extract Text</option>
                                <option value="translate">Translate To Sinhala</option>
                            </select>
                        </div>

                        <button class="btn btn-warning w-full" type="submit">Submit</button>
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
        </div>
    </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <div class="layout-content-container flex flex-col flex-1">
                        <div class="flex flex-wrap justify-between gap-3 p-4">
                            <p class="text-[#0e141b] tracking-light text-[32px] font-bold leading-tight min-w-72">
                                PDF TOOLS</p>
                        </div>


                    </div>


                    @if (session('error'))
                        <p style="color: red;">{{ session('error') }}</p>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('openai.chat') }}" method="POST" class="p-4 rounded shadow-sm">
                            @csrf
                            <div class="mb-3">
                                <label for="prompt" class="form-label block mb-2">Enter Prompt:</label>
                                <textarea name="prompt" id="prompt" rows="5" class="form-control w-full"
                                    placeholder="Type your prompt here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-full">Chat</button>
                        </form>



                        <div id="loader">
                            <img src="{{ asset('assets/auth/compiled/svg/rings.svg') }}" class="me-4"
                                style="width: 3rem" alt="audio">
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
            </div>
        </div>
        <div class="text-center mt-4 text-sm text-gray-500 sm:text-right sm:ml-0">
            Isuru Bandara
        </div>
    </div>


    </div>


</x-app-layout>
