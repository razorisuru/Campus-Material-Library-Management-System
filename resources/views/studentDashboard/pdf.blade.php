@extends('layouts.stAuth')

@section('content')
    <section class="section">
        <div class="card shadow rounded">
            <div class="card-body">
                <!-- Top Controls -->
                <div class="d-flex flex-column flex-md-row gap-3 mb-4 align-items-center">
                    <!-- Search -->
                    <div class="search-container flex-grow-1 w-100">
                        <div class="input-group">
                            <span class="input-group-text  border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                    </path>
                                </svg>
                            </span>
                            <input id="searchInput" type="search" class="form-control border-start-0"
                                placeholder="Search materials...">
                        </div>
                    </div>

                    <!-- View Toggle & Sort -->
                    <div class="d-flex gap-2">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary view-toggle" data-view="grid">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button class="btn btn-outline-primary view-toggle" data-view="list">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                        <select class="form-select w-auto" id="sortSelect">
                            <option value="name">Name</option>
                            <option value="date">Date</option>
                            <option value="size">Size</option>
                        </select>
                    </div>
                </div>

                <!-- Filters for Mobile -->
                <div class="d-md-none mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <select class="form-select" id="mobileCategorySelect">
                                <option value="all">All Categories</option>
                                @foreach ($pdfCategories as $pdfCategory)
                                    <option value="{{ $pdfCategory->name }}">{{ $pdfCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-select" id="mobileDegreeSelect">
                                <option value="all">All Degrees</option>
                                @foreach ($degrees as $degree)
                                    <option value="{{ $degree->name }}">{{ $degree->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Desktop Filters -->
                <div class="d-none d-md-block mb-4">
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
                    <div class="row g-3" id="materialsContainer">
                        @foreach ($materials as $material)
                            @php
                                $fileExtension = pathinfo($material->file_path, PATHINFO_EXTENSION);
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
                                $iconPath = '/img/' . ($fileIcons[strtolower($fileExtension)] ?? 'file.png');
                            @endphp
                            <div class="col-12 col-md-6 col-lg-4 material-item"
                                data-category="{{ $material->category->name }}"
                                data-degree="{{ $material->degree->name }}"
                                data-date="{{ $material->created_at }}"
                                data-name="{{ basename($material->file_path) }}">
                                <div class="material-card-modern h-100">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="file-preview-modern">
                                                    @if (strtolower($fileExtension) === 'pdf')
                                                        <embed src="{{ asset('storage/' . $material->file_path) }}#toolbar=0&navpanes=0&scrollbar=0"
                                                            type="application/pdf"
                                                            class="pdf-thumb-modern"
                                                            alt="PDF preview"
                                                            />
                                                    @else
                                                        <img src="{{ $iconPath }}" class="file-icon-modern" alt="File icon">
                                                    @endif
                                                    <span class="file-ext-modern">{{ strtoupper($fileExtension) }}</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="file-name-modern mb-1">{{ basename($material->file_path) }}</h6>
                                                    <div class="d-flex flex-wrap gap-1 mb-1">
                                                        <span class="badge bg-gradient-primary">{{ $material->category->name }}</span>
                                                        <span class="badge bg-gradient-success">{{ $material->degree->name }}</span>
                                                        <span class="badge bg-gradient-secondary">{{ $material->subject->name }}</span>
                                                    </div>
                                                    <div class="file-meta-modern text-muted small">
                                                        <span><i class="bi bi-calendar"></i> {{ $material->created_at->format('M d, Y') }}</span>
                                                        <span><i class="bi bi-file-earmark"></i> {{ round(filesize('storage/' . $material->file_path)/1000000, 2) }} MB</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted small"><i class="bi bi-person"></i> {{ $material->user->name }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $material->file_path) }}"
                                                    class="btn btn-modern w-100">
                                                    <i class="bi bi-eye"></i> View Document
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <style>
        .material-card {
            transition: all 0.3s ease;
        }

        .material-card:hover {
            transform: translateY(-2px);
        }

        .file-icon-wrapper {
            position: relative;
            width: 60px;
            height: 60px;
        }

        .file-icon {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .file-ext {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 2px;
        }

        .file-meta span {
            margin-right: 1rem;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .file-icon-wrapper {
                width: 40px;
                height: 40px;
            }
        }

        .material-card-modern {
            transition: box-shadow 0.2s, transform 0.2s;
            border-radius: 1.2rem;
            overflow: hidden;
            border: 2px solid #000; /* Add this line for a black border around the whole card */
        }
        .material-card-modern .card {
            border-radius: 1.2rem;
            background: #fff;
            box-shadow: 0 2px 16px 0 rgba(60,72,88,0.07);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .material-card-modern:hover .card {
            box-shadow: 0 8px 32px 0 rgba(60,72,88,0.18);
            transform: translateY(-4px) scale(1.02);
        }
        .file-preview-modern {
            position: relative;
            width: 56px;
            height: 72px;
            flex-shrink: 0;
            border-radius: 0.5rem;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .pdf-thumb-modern {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
            background: #f2f2f2;
        }
        .file-icon-modern {
            width: 48px;
            height: 48px;
            object-fit: contain;
            opacity: 0.85;
        }
        .file-ext-modern {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: #fff;
            font-size: 11px;
            text-align: center;
            padding: 2px 0;
            border-radius: 0 0 0.5rem 0.5rem;
            letter-spacing: 1px;
        }
        .file-name-modern {
            font-weight: 600;
            font-size: 1rem;
            color: #2d3748;
            margin-bottom: 0.25rem;
            word-break: break-all;
        }
        .file-meta-modern span {
            margin-right: 1rem;
            font-size: 0.92em;
        }
        .btn-modern {
            background: linear-gradient(90deg, #4f8cff 0%, #38c6ff 100%);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px 0 rgba(60,72,88,0.08);
        }
        .btn-modern:hover, .btn-modern:focus {
            background: linear-gradient(90deg, #38c6ff 0%, #4f8cff 100%);
            color: #fff;
            box-shadow: 0 4px 16px 0 rgba(60,72,88,0.12);
        }
        .bg-gradient-primary {
            background: linear-gradient(90deg, #4f8cff 0%, #38c6ff 100%) !important;
            color: #fff !important;
        }
        .bg-gradient-success {
            background: linear-gradient(90deg, #42e695 0%, #3bb2b8 100%) !important;
            color: #fff !important;
        }
        .bg-gradient-secondary {
            background: linear-gradient(90deg, #a18cd1 0%, #fbc2eb 100%) !important;
            color: #fff !important;
        }
        @media (max-width: 768px) {
            .file-preview-modern {
                width: 40px;
                height: 52px;
            }
            .file-icon-modern {
                width: 32px;
                height: 32px;
            }
            .material-card-modern .card-body {
                padding: 1rem 0.75rem;
            }
        }
    </style>



    <script>
        $('#searchInput').on('input', function() {
            const searchValue = $(this).val().toLowerCase();
            $('.material-item').each(function() {
                const materialTitle = $(this).find('.file-name').text().toLowerCase();
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

        // View Toggle
        $('.view-toggle').click(function() {
            const view = $(this).data('view');
            const container = $('#materialsContainer');

            $('.view-toggle').removeClass('active');
            $(this).addClass('active');

            if (view === 'list') {
                container.find('.col-md-6').removeClass('col-md-6 col-lg-4').addClass('col-12');
            } else {
                container.find('.col-12').removeClass('col-12').addClass('col-md-6 col-lg-4');
            }
        });

        // Sorting
        $('#sortSelect').change(function() {
            const sortBy = $(this).val();
            const container = $('#materialsContainer');
            const items = container.find('.material-item').get();

            items.sort((a, b) => {
                const aVal = $(a).data(sortBy);
                const bVal = $(b).data(sortBy);
                return aVal > bVal ? 1 : -1;
            });

            container.empty().append(items);
        });

        // Mobile filters
        $('#mobileCategorySelect, #mobileDegreeSelect').change(function() {
            selectedCategory = $('#mobileCategorySelect').val();
            selectedDegree = $('#mobileDegreeSelect').val();
            filterMaterials();
        });

        // Helper function for file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
@endsection
