<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <style>
        /* Optional custom styles */
        #file-list {
            list-style: none;
            padding: 0;
        }

        #file-list li {
            margin-bottom: 5px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>


    <div class="py-12">
        <!-- Alert Container -->
        <div id="alert-container" class="fixed top-0 left-0 right-0 flex justify-center mt-4" style="display: none;">
            <div id="alert" class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg relative max-w-4xl mx-auto fade-in">
                <strong class="font-bold text-lg"></strong>
                <span class="block sm:inline">{{ session('status') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg id="close-alert" class="fill-current h-6 w-6 text-blue-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a.5.5 0 01-.707 0L10 10.707l-3.646 3.646a.5.5 0 01-.707-.707L9.293 10 5.646 6.354a.5.5 0 11.707-.707L10 9.293l3.646-3.646a.5.5 0 11.707.707L10.707 10l3.646 3.646a.5.5 0 010 .707z" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form class="bg-white p-6 rounded-lg shadow-md w-full max-w" action="{{ route('StUpload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="degree_programme" class="block text-gray-700 font-medium mb-2">Select Degree
                            Programme</label>
                        <select id="degree_programme" name="degree_programme_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">Please select a degree programme</option>
                            @foreach ($degrees as $degree)
                            <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Select Subject</label>
                        <select id="subject" name="subject_id" disabled class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">Please select a subject</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                    </div>

                    <!-- New Category Radio Buttons Section -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Select Category</label>
                        <div class="flex flex-col sm:flex-row sm:space-x-4">
                            <label class="inline-flex items-center mb-2 sm:mb-0">
                                <input type="radio" name="category" value="lecture_notes" class="form-radio text-blue-600">
                                <span class="ml-2">Lecture Notes</span>
                            </label>
                            <label class="inline-flex items-center mb-2 sm:mb-0">
                                <input type="radio" name="category" value="presentations" class="form-radio text-blue-600">
                                <span class="ml-2">Presentations</span>
                            </label>
                            <label class="inline-flex items-center mb-2 sm:mb-0">
                                <input type="radio" name="category" value="tests" class="form-radio text-blue-600">
                                <span class="ml-2">Tests</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="category" value="activities" class="form-radio text-blue-600">
                                <span class="ml-2">Activities</span>
                            </label>
                        </div>
                    </div>


                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 font-medium mb-2">File Upload</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="files" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-200 ease-in-out" id="drop-area">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 1 1 8 0m-4 0V5m0 0a4 4 0 1 1 8 0m-8 4v4m0 4v4m0-4H3m8 0h8m-4-4h4m-4 4H7" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">Only Upload PDF, DOCX, PPTX up to 50MB</p>
                                </div>
                                <input id="files" name="files[]" type="file" class="hidden" multiple>
                            </label>
                        </div>
                        <div id="file-list" class="mt-4 text-sm text-gray-700"></div>
                    </div>

                    <script>
                        const dropArea = document.getElementById('drop-area');
                        const fileInput = document.getElementById('files');
                        const fileList = document.getElementById('file-list');
                        let droppedFiles = [];

                        // Prevent default behavior for drag-and-drop events
                        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                            dropArea.addEventListener(eventName, preventDefaults, false);
                            document.body.addEventListener(eventName, preventDefaults, false);
                        });

                        function preventDefaults(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }

                        // Highlight drop area when file is dragged over it
                        ['dragenter', 'dragover'].forEach(eventName => {
                            dropArea.addEventListener(eventName, () => dropArea.classList.add('border-blue-500'), false);
                        });

                        ['dragleave', 'drop'].forEach(eventName => {
                            dropArea.addEventListener(eventName, () => dropArea.classList.remove('border-blue-500'), false);
                        });

                        // Handle dropped files
                        dropArea.addEventListener('drop', handleDrop, false);

                        function handleDrop(e) {
                            const dt = e.dataTransfer;
                            const files = dt.files;

                            handleFiles(files);
                        }

                        // Handle file selection via input
                        fileInput.addEventListener('change', (e) => {
                            const files = fileInput.files;
                            handleFiles(files);
                        });

                        function handleFiles(files) {
                            files = [...files];
                            droppedFiles = [...droppedFiles, ...files];
                            displayFiles(droppedFiles);
                            updateFileInput(droppedFiles);
                        }

                        function displayFiles(files) {
                            fileList.innerHTML = "";
                            files.forEach(file => {
                                let fileItem = document.createElement('p');
                                fileItem.textContent = file.name;
                                fileList.appendChild(fileItem);
                            });
                        }

                        function updateFileInput(files) {
                            const dataTransfer = new DataTransfer();
                            files.forEach(file => {
                                dataTransfer.items.add(file);
                            });
                            fileInput.files = dataTransfer.files;
                        }
                    </script>




                    <div class="flex justify-start">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Submit</button>
                    </div>

                    @if (session('status'))
                    {{-- <div class="mt-4">
                            <p class="text-green-600">{{ session('status') }}</p>
            </div> --}}
            <script>
                // JavaScript to handle alert display and dismissal

                const alertContainer = document.getElementById('alert-container');
                const alert = document.getElementById('alert');
                alertContainer.style.display = 'flex';
                alert.classList.add('fade-in');


                document.getElementById('close-alert').addEventListener('click', function() {
                    document.getElementById('alert-container').style.display = 'none';
                });
            </script>
            @endif
            </form>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('degree_programme').addEventListener('change', function() {
            const degreeId = this.value;
            const subjectSelect = document.getElementById('subject');

            // Clear the subject options and disable it
            subjectSelect.innerHTML = '<option value="">Please select a subject</option>';
            subjectSelect.disabled = true;

            if (degreeId) {
                axios.get(`/degree-programmes/${degreeId}/subjects`)
                    .then(response => {
                        const subjects = response.data;
                        subjects.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.subject_code + " - " + subject.name;
                            subjectSelect.appendChild(option);
                        });
                        subjectSelect.disabled = false; // Enable the subject select
                    })
                    .catch(error => {
                        console.error('Error fetching subjects:', error);
                    });
            }
        });
    </script>
    <script>
        document.getElementById('files').addEventListener('change', function(event) {
            const fileList = event.target.files;
            const fileListContainer = document.getElementById('file-list');
            fileListContainer.innerHTML = ''; // Clear the list

            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                const li = document.createElement('li');
                li.textContent = file.name;
                fileListContainer.appendChild(li);
            }
        });
    </script>

</x-app-layout>