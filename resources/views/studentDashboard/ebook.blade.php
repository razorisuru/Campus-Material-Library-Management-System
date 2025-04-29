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
                            <input id="searchInput" placeholder="Search eBooks" class="form-control border-0" />
                        </div>
                    </label>
                </div>

                <!-- Category Filters -->
                <div class="mb-4">
                    <div class="mb-2 d-flex flex-wrap gap-2">
                        <button id="allCategoriesBtn" class="btn btn-info btn-sm active">All Categories</button>
                        @foreach ($ebookCategories as $category)
                            <button class="btn btn-outline-info btn-sm category-btn"
                                    data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- eBooks Grid -->
                <div class="row g-4" id="ebooksGrid">
                    @foreach ($ebooks as $ebook)
                        <div class="col-md-4 col-lg-3 ebook-item"
                             data-categories="{{ $ebook->categories->pluck('id')->join(',') }}">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                                     class="card-img-top view-details"
                                     alt="{{ $ebook->title }}"
                                     style="height: 200px; object-fit: cover;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#ebookModal"
                                     data-ebook="{{ json_encode($ebook) }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ebook->title }}</h5>
                                    <p class="card-text text-muted">{{ $ebook->author }}</p>
                                    <div class="mb-2">
                                        @foreach ($ebook->categories as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                    <button class="btn btn-primary btn-sm view-details"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ebookModal"
                                            data-ebook="{{ json_encode($ebook) }}">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center" id="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- eBook Modal -->
    <div class="modal fade" id="ebookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="modalCover" src="" class="img-fluid rounded" alt="Book Cover">
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Author:</th>
                                    <td id="modalAuthor"></td>
                                </tr>
                                <tr>
                                    <th>ISBN:</th>
                                    <td id="modalIsbn"></td>
                                </tr>
                                <tr>
                                    <th>Publication Date:</th>
                                    <td id="modalPubDate"></td>
                                </tr>
                                <tr>
                                    <th>Categories:</th>
                                    <td id="modalCategories"></td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td id="modalDescription"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="readButton" href="" class="btn btn-primary" target="_blank">Read eBook</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this in the head section or at the top of your file -->
    <style>
        .ebook-item {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            transform: scale(1);
        }

        .ebook-item.hidden {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
        }

        .card-img-top {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card-img-top:hover {
            transform: scale(1.05);
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pagination .page-link {
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            transform: scale(1.1);
            z-index: 3;
        }

        .pagination .active .page-link {
            transform: scale(1.05);
        }
    </style>

    <script>
        $(document).ready(function() {
            // Search functionality with animation
            $('#searchInput').on('input', function() {
                const searchText = $(this).val().toLowerCase();
                $('.ebook-item').each(function() {
                    const title = $(this).find('.card-title').text().toLowerCase();
                    const author = $(this).find('.card-text').text().toLowerCase();
                    const shouldShow = title.includes(searchText) || author.includes(searchText);

                    if (shouldShow) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            });

            // Category filtering with animation
            $('.category-btn').click(function() {
                $('.category-btn').removeClass('active');
                $('#allCategoriesBtn').removeClass('active');
                $(this).addClass('active');

                const categoryId = $(this).data('category');
                $('.ebook-item').each(function() {
                    const categories = $(this).data('categories').toString().split(',');
                    const shouldShow = categories.includes(categoryId.toString());

                    if (shouldShow) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            });

            $('#allCategoriesBtn').click(function() {
                $('.category-btn').removeClass('active');
                $(this).addClass('active');
                $('.ebook-item').removeClass('hidden');
            });

            // Modal functionality - now works for both button and image
            $('.view-details').click(function() {
                const ebook = $(this).data('ebook');
                $('#modalCover').attr('src', '/storage/' + ebook.cover_image);
                $('.modal-title').text(ebook.title);
                $('#modalAuthor').text(ebook.author);
                $('#modalIsbn').text(ebook.isbn);
                $('#modalPubDate').text(new Date(ebook.publication_date).toLocaleDateString());
                $('#modalDescription').text(ebook.description);
                $('#modalCategories').html(
                    ebook.categories.map(cat =>
                        `<span class="badge bg-primary">${cat.name}</span>`
                    ).join(' ')
                );
                $('#readButton').attr('href', '/storage/' + ebook.file_path);
            });

            // Optional: Add a loading animation to the modal
            $('#ebookModal').on('show.bs.modal', function() {
                $(this).fadeIn('fast');
            });
        });
    </script>

@endsection
