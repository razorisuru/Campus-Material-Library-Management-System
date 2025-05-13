@extends('layouts.stAuth')

@section('content')
    <section class="section">
        <div class="card shadow rounded">
            <div class="card-body">
                <!-- Mobile Header -->
                <div class="d-block d-md-none mb-3">
                    <h5 class="fw-bold mb-3">Study Materials</h5>
                    <div class="accordion mb-3" id="mobileFiltersAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#filterCollapse">
                                    <i class="bi bi-funnel me-2"></i> Filters & Sort
                                </button>
                            </h2>
                            <div id="filterCollapse" class="accordion-collapse collapse"
                                data-bs-parent="#mobileFiltersAccordion">
                                <div class="accordion-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" id="mobileCategorySelect">
                                                <option value="all">All Categories</option>
                                                @foreach ($pdfCategories as $pdfCategory)
                                                    <option value="{{ $pdfCategory->name }}">{{ $pdfCategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Degree</label>
                                            <select class="form-select" id="mobileDegreeSelect">
                                                <option value="all">All Degrees</option>
                                                @foreach ($degrees as $degree)
                                                    <option value="{{ $degree->name }}">{{ $degree->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Sort By</label>
                                            <select class="form-select" id="mobileSortSelect">
                                                <option value="name">Name (A-Z)</option>
                                                <option value="nameDesc">Name (Z-A)</option>
                                                <option value="dateNewest">Date (Newest)</option>
                                                <option value="dateOldest">Date (Oldest)</option>
                                                <option value="sizeSmallest">Size (Smallest)</option>
                                                <option value="sizeLargest">Size (Largest)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="search-container w-100 mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input id="searchInput" type="search" class="form-control border-start-0"
                            placeholder="Search materials by name, category, subject...">
                    </div>
                </div>

                <!-- Desktop Header Controls -->
                <div class="d-none d-md-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Study Materials</h5>
                    <div class="d-flex gap-2">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary view-toggle active" data-view="grid">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button class="btn btn-outline-primary view-toggle" data-view="list">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                        <select class="form-select" id="sortSelect">
                            <option value="name">Name (A-Z)</option>
                            <option value="nameDesc">Name (Z-A)</option>
                            <option value="dateNewest">Date (Newest)</option>
                            <option value="dateOldest">Date (Oldest)</option>
                            <option value="sizeSmallest">Size (Smallest)</option>
                            <option value="sizeLargest">Size (Largest)</option>
                        </select>
                    </div>
                </div>

                <!-- Desktop Filters -->
                <div class="d-none d-md-block mb-4">
                    <div class="filter-section">
                        <span class="filter-label">Category:</span>
                        <div class="filter-pills">
                            <button id="allCategoryButton" class="filter-pill active" data-filter="category"
                                data-value="all" type="button">
                                All
                            </button>
                            @foreach ($pdfCategories as $pdfCategory)
                                <button class="filter-pill" data-filter="category" data-value="{{ $pdfCategory->name }}"
                                    type="button">
                                    {{ $pdfCategory->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-section mt-2">
                        <span class="filter-label">Degree:</span>
                        <div class="filter-pills">
                            <button id="allDegreeButton" class="filter-pill active" data-filter="degree" data-value="all"
                                type="button">
                                All
                            </button>
                            @foreach ($degrees as $degree)
                                <button class="filter-pill" data-filter="degree" data-value="{{ $degree->name }}"
                                    type="button">
                                    {{ $degree->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Materials Container -->
                <div id="materialList">
                    <div id="noResultsMessage" class="text-center py-5 d-none">
                        <div class="mb-3">
                            <i class="bi bi-search fs-1 text-muted"></i>
                        </div>
                        <h5>No materials found</h5>
                        <p class="text-muted">Try adjusting your search or filters</p>
                    </div>

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
                                $fileName = basename($material->file_path);
                                $fileSize = round(filesize('storage/' . $material->file_path) / 1000000, 2);
                            @endphp
                            <div class="col-12 col-md-6 col-lg-4 material-item"
                                data-category="{{ $material->category->name }}"
                                data-degree="{{ $material->degree->name }}" data-date="{{ $material->created_at }}"
                                data-name="{{ $fileName }}" data-size="{{ $fileSize }}">
                                <div class="material-card h-100">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="file-preview">
                                                    <img src="{{ $iconPath }}" class="file-icon"
                                                        alt="{{ strtoupper($fileExtension) }} icon">
                                                    <span class="file-ext">{{ strtoupper($fileExtension) }}</span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h6 class="file-name text-truncate mb-1" title="{{ $fileName }}">
                                                        {{ $fileName }}</h6>
                                                    <div class="d-flex flex-wrap gap-1 mb-1">
                                                        <span
                                                            class="badge bg-primary">{{ $material->category->name }}</span>
                                                        <span
                                                            class="badge bg-success">{{ $material->degree->name }}</span>
                                                        <span
                                                            class="badge bg-secondary">{{ $material->subject->name }}</span>
                                                    </div>
                                                    <div class="file-meta text-muted small">
                                                        <span><i
                                                                class="bi bi-calendar me-1"></i>{{ $material->created_at->format('M d, Y') }}</span>
                                                        <span><i class="bi bi-file-earmark me-1"></i>{{ $fileSize }}
                                                            MB</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted small"><i
                                                            class="bi bi-person me-1"></i>{{ $material->user->name }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                                    class="btn btn-primary w-100">
                                                    <i class="bi bi-eye me-1"></i> View Document
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
        /* Base Styles */
        .card {
            border-radius: 0.75rem;
            transition: all 0.25s ease;
        }

        /* Material Card Styling */
        .material-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 0.75rem;
        }

        .material-card:hover {
            transform: translateY(-4px);
        }

        .material-card .card {
            border-radius: 0.75rem;
            overflow: hidden;
            height: 100%;
            border: 1px solid var(--bs-border-color);
        }

        .material-card:hover .card {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* File Preview */
        .file-preview {
            position: relative;
            width: 56px;
            height: 70px;
            flex-shrink: 0;
            border-radius: 0.5rem;
            background: var(--bs-tertiary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .file-icon {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .file-ext {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 10px;
            text-align: center;
            padding: 2px 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .file-name {
            font-weight: 600;
            font-size: 0.95rem;
            line-height: 1.3;
        }

        .file-meta span {
            margin-right: 1rem;
            display: inline-flex;
            align-items: center;
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(45deg, #4f8cff, #38c6ff);
            border: none;
            box-shadow: 0 2px 5px rgba(79, 140, 255, 0.3);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #38c6ff, #4f8cff);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(79, 140, 255, 0.4);
        }

        /* Filter Pills */
        .filter-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-label {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-pill {
            border: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50rem !important;
            /* Force pill shape */
            transition: all 0.2s;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .filter-pill:hover {
            background: var(--bs-tertiary-bg);
        }

        .filter-pill.active[data-filter="category"] {
            background: #4f8cff;
            border-color: #4f8cff;
            color: #fff;
        }

        .filter-pill.active[data-filter="degree"] {
            background: #42e695;
            border-color: #42e695;
            color: #fff;
        }

        /* List View Styles */
        .list-view .material-item {
            width: 100%;
        }

        .list-view .file-name {
            font-size: 1.1rem;
        }

        /* Mobile Optimizations */
        @media (max-width: 767.98px) {
            .card-body {
                padding: 1rem;
            }

            .file-preview {
                width: 46px;
                height: 58px;
            }

            .file-icon {
                width: 32px;
                height: 32px;
            }

            .file-name {
                font-size: 0.9rem;
            }

            .badge {
                font-size: 0.7rem;
            }

            .file-meta {
                font-size: 0.75rem !important;
            }

            .file-meta span {
                margin-right: 0.5rem;
            }
        }

        /* Accordion Customizations */
        .accordion-button:not(.collapsed) {
            background-color: rgba(79, 140, 255, 0.1);
            color: var(--bs-primary);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(79, 140, 255, 0.25);
        }

        /* Dark Mode Compatibility */
        @media (prefers-color-scheme: dark) {
            .btn-primary {
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            }

            .btn-primary:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            }

            .filter-pill.active[data-filter="category"],
            .filter-pill.active[data-filter="degree"] {
                box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.2);
            }

            .file-preview {
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables
            const materialsContainer = document.getElementById('materialsContainer');
            const searchInput = document.getElementById('searchInput');
            const materialItems = document.querySelectorAll('.material-item');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const viewToggles = document.querySelectorAll('.view-toggle');
            const sortSelect = document.getElementById('sortSelect');
            const mobileSortSelect = document.getElementById('mobileSortSelect');
            const filterPills = document.querySelectorAll('.filter-pill');
            const mobileCategorySelect = document.getElementById('mobileCategorySelect');
            const mobileDegreeSelect = document.getElementById('mobileDegreeSelect');

            // Filter state
            let filters = {
                category: 'all',
                degree: 'all',
                search: '',
                sort: 'name'
            };

            // Search functionality
            searchInput.addEventListener('input', function() {
                filters.search = this.value.toLowerCase().trim();
                applyFilters();
            });

            // Filter pills click handling
            filterPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    const filterType = this.dataset.filter;
                    const filterValue = this.dataset.value;

                    // Update active state visually
                    document.querySelectorAll(`.filter-pill[data-filter="${filterType}"]`).forEach(
                        p => {
                            p.classList.remove('active');
                        });
                    this.classList.add('active');

                    // Update filter state
                    filters[filterType] = filterValue;

                    // Update mobile selects to match
                    if (filterType === 'category') {
                        mobileCategorySelect.value = filterValue;
                    } else if (filterType === 'degree') {
                        mobileDegreeSelect.value = filterValue;
                    }

                    applyFilters();
                });
            });

            // Mobile filter selects
            mobileCategorySelect.addEventListener('change', function() {
                filters.category = this.value;
                applyFilters();

                // Update desktop filter pills
                document.querySelectorAll('.filter-pill[data-filter="category"]').forEach(pill => {
                    pill.classList.remove('active');
                    if (pill.dataset.value === this.value) {
                        pill.classList.add('active');
                    }
                });
            });

            mobileDegreeSelect.addEventListener('change', function() {
                filters.degree = this.value;
                applyFilters();

                // Update desktop filter pills
                document.querySelectorAll('.filter-pill[data-filter="degree"]').forEach(pill => {
                    pill.classList.remove('active');
                    if (pill.dataset.value === this.value) {
                        pill.classList.add('active');
                    }
                });
            });

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                filters.sort = this.value;
                applyFilters();

                // Keep mobile sort in sync
                mobileSortSelect.value = this.value;
            });

            mobileSortSelect.addEventListener('change', function() {
                filters.sort = this.value;
                applyFilters();

                // Keep desktop sort in sync
                sortSelect.value = this.value;
            });

            // View toggles (grid/list)
            viewToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const view = this.dataset.view;

                    // Update active state
                    viewToggles.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Apply view
                    if (view === 'list') {
                        materialsContainer.classList.add('list-view');
                        document.querySelectorAll('#materialsContainer > .col-md-6').forEach(
                        col => {
                            col.classList.remove('col-md-6', 'col-lg-4');
                            col.classList.add('col-12');
                        });
                    } else {
                        materialsContainer.classList.remove('list-view');
                        document.querySelectorAll('#materialsContainer > .col-12').forEach(col => {
                            col.classList.remove('col-12');
                            col.classList.add('col-md-6', 'col-lg-4');
                        });
                    }
                });
            });

            // Main filter application function
            function applyFilters() {
                let visibleCount = 0;

                // Process each material item
                materialItems.forEach(item => {
                    const category = item.dataset.category;
                    const degree = item.dataset.degree;
                    const name = item.dataset.name.toLowerCase();
                    const date = new Date(item.dataset.date);
                    const size = parseFloat(item.dataset.size);
                    const itemContent = item.textContent.toLowerCase();

                    // Match category and degree
                    const matchCategory = filters.category === 'all' || category === filters.category;
                    const matchDegree = filters.degree === 'all' || degree === filters.degree;

                    // Match search text
                    const matchSearch = filters.search === '' ||
                        name.includes(filters.search) ||
                        itemContent.includes(filters.search);

                    // Determine visibility
                    const isVisible = matchCategory && matchDegree && matchSearch;
                    item.style.display = isVisible ? '' : 'none';

                    if (isVisible) visibleCount++;
                });

                // Show/hide no results message
                noResultsMessage.classList.toggle('d-none', visibleCount > 0);

                // Apply sorting
                sortItems();
            }

            // Sort items function
            function sortItems() {
                const items = Array.from(materialItems);
                const sortedItems = items.sort((a, b) => {
                    switch (filters.sort) {
                        case 'name':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'nameDesc':
                            return b.dataset.name.localeCompare(a.dataset.name);
                        case 'dateNewest':
                            return new Date(b.dataset.date) - new Date(a.dataset.date);
                        case 'dateOldest':
                            return new Date(a.dataset.date) - new Date(b.dataset.date);
                        case 'sizeSmallest':
                            return parseFloat(a.dataset.size) - parseFloat(b.dataset.size);
                        case 'sizeLargest':
                            return parseFloat(b.dataset.size) - parseFloat(a.dataset.size);
                        default:
                            return 0;
                    }
                });

                // Re-append items in sorted order
                sortedItems.forEach(item => {
                    materialsContainer.appendChild(item);
                });
            }

            // Initial filter application
            applyFilters();
        });
    </script>
@endsection
