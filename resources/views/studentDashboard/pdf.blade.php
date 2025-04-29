@extends('layouts.stAuth')

@section('content')
    <section class="section">
        <div class="card shadow rounded">
            <div class="card-body">
                <!-- Search Input -->
                <div class="mb-3">
                    <label class="w-100">
                        <div class="input-group">
                            <span class="input-group-text border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                    </path>
                                </svg>
                            </span>
                            <input id="searchInput" placeholder="Search PDF" class="form-control border-0 " />
                        </div>
                    </label>
                </div>

                <!-- Filters -->
                <div class="mb-4">
                    <div class="mb-2 d-flex flex-wrap gap-2">
                        <div id="allCategoryButton" class="all-category-button btn btn-info btn-sm">
                            All Categories
                        </div>
                        @foreach ($pdfCategories as $pdfCategory)
                            <div class="category-button btn btn-info btn-sm" data-category="{{ $pdfCategory->name }}">
                                {{ $pdfCategory->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-2 d-flex flex-wrap gap-2">
                        <div id="allDegreeButton" class="all-degree-button btn btn-success btn-sm">
                            All Degrees
                        </div>
                        @foreach ($degrees as $degree)
                            <div class="degree-button btn btn-success btn-sm" data-degree="{{ $degree->name }}">
                                {{ $degree->name }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Material List -->
                <div id="materialList" class="mt-4">
                    <div class="row g-4">
                        @foreach ($materials as $material)
                            <div class="col-md-6 material-item" data-category="{{ $material->category->name }}"
                                data-degree="{{ $material->degree->name }}">
                                <div class="d-flex gap-3 p-3 border rounded">
                                    <div class="flex-grow-1">
                                        <p class="fw-bold  mb-1">{{ basename($material->file_path) }}</p>
                                        <p class="text-muted mb-1">{{ $material->user->name }}</p>
                                        <span class="badge bg-primary mb-1">{{ $material->category->name }}</span>
                                        <div class="d-flex gap-1">
                                            <span class="badge bg-success">{{ $material->degree->name }}</span>
                                            <span class="badge bg-secondary">{{ $material->subject->name }}</span>
                                        </div>

                                        <a href="{{ asset('storage/' . $material->file_path) }}"
                                            class="btn btn-outline-secondary btn-sm mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                fill="currentColor" viewBox="0 0 256 256">
                                                <path
                                                    d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z">
                                                </path>
                                            </svg>
                                            View
                                        </a>
                                    </div>
                                    @php
                                        $fileExtension = pathinfo($material->file_path, PATHINFO_EXTENSION);

                                        // Define a mapping of file extensions to image icons
                                        $fileIcons = [
                                            'pdf' => 'pdf.png',
                                            'docx' => 'docx.png',
                                            'doc' => 'doc.png',
                                            'ppt' => 'ppt.png',
                                            'pptx' => 'pptx.png',
                                            'xls' => 'xls.png',
                                            'xlsx' => 'xlsx.png',
                                            'txt' => 'txt.png',
                                            'zip' => 'zip.png',
                                            'rar' => 'rar.png',
                                        ];

                                        // Default icon if no match
                                        $iconPath = '/img/' . ($fileIcons[strtolower($fileExtension)] ?? 'file.png');
                                    @endphp

                                    <div class="bg-image flex-shrink-0"
                                        onclick="window.location.href='{{ asset('storage/' . $material->file_path) }}';"
                                        style='width:100px; height:100px; background-image: url("{{ $iconPath }}"); background-size:contain; background-repeat:no-repeat; background-position:center; cursor:pointer;'>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <div class="d-flex justify-content-between mt-5">
                    <div class="text-muted small">&nbsp;</div>
                    <div class="text-muted small">Isuru Bandara</div>
                </div>
            </div>
    </section>

    <script>
        $('#searchInput').on('input', function() {
            const searchValue = $(this).val().toLowerCase();
            $('.material-item').each(function() {
                const materialTitle = $(this).find('.fw-bold').text().toLowerCase();
                const materialUser = $(this).find('.text-muted').text().toLowerCase();
                const materialCategory = $(this).find('.badge').text().toLowerCase();

                if (materialTitle.includes(searchValue) ||
                    materialUser.includes(searchValue) ||
                    materialCategory.includes(searchValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        const categoryButtons = $('.category-button');
        const degreeButtons = $('.degree-button');
        const allCategoryButton = $('#allCategoryButton');
        const allDegreeButton = $('#allDegreeButton');
        const materials = $('.material-item');

        let selectedCategory = 'all';
        let selectedDegree = 'all';

        function filterMaterials() {
            materials.each(function() {
                const materialCategory = $(this).data('category');
                const materialDegree = $(this).data('degree');

                const matchesCategory = (selectedCategory === 'all' || materialCategory === selectedCategory);
                const matchesDegree = (selectedDegree === 'all' || materialDegree === selectedDegree);

                if (matchesCategory && matchesDegree) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        allCategoryButton.on('click', function() {
            selectedCategory = 'all';
            filterMaterials();

            allCategoryButton.addClass('bg-[#4e7397] text-white');
            categoryButtons.removeClass('bg-[#4e7397] text-white');
        });

        allDegreeButton.on('click', function() {
            selectedDegree = 'all';
            filterMaterials();

            allDegreeButton.addClass('bg-[#2c9f5b] text-white');
            degreeButtons.removeClass('bg-[#2c9f5b] text-white');
        });

        categoryButtons.each(function() {
            $(this).on('click', function() {
                const category = $(this).data('category');

                if (selectedCategory === category) {
                    selectedCategory = 'all';
                    $(this).removeClass('bg-[#4e7397] text-white');
                    allCategoryButton.addClass('bg-[#4e7397] text-white');
                } else {
                    selectedCategory = category;
                    categoryButtons.removeClass('bg-[#4e7397] text-white');
                    $(this).addClass('bg-[#4e7397] text-white');
                    allCategoryButton.removeClass('bg-[#4e7397] text-white');
                }
                filterMaterials();
            });
        });

        degreeButtons.each(function() {
            $(this).on('click', function() {
                const degree = $(this).data('degree');

                if (selectedDegree === degree) {
                    selectedDegree = 'all';
                    $(this).removeClass('bg-[#2c9f5b] text-white');
                    allDegreeButton.addClass('bg-[#2c9f5b] text-white');
                } else {
                    selectedDegree = degree;
                    degreeButtons.removeClass('bg-[#2c9f5b] text-white');
                    $(this).addClass('bg-[#2c9f5b] text-white');
                    allDegreeButton.removeClass('bg-[#2c9f5b] text-white');
                }
                filterMaterials();
            });
        });
    </script>
@endsection
