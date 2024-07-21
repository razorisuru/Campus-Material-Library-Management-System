<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Modal Structure -->
    <div id="ebookModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg  max-w-4xl p-6">

            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#0e141b]">Ebook Details</h2>
                <button id="closeModal" class="text-[#0e141b] text-lg font-bold">&times;</button>
            </div>




            <div class="px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col  py-5 flex-1">
                    <div class="@container">
                        <div class="@[480px]:px-4 @[480px]:py-3">
                            <div id="modalCoverImage"
                                class="w-full bg-center bg-no-repeat bg-cover flex flex-col justify-end overflow-hidden bg-slate-50 @[480px]:rounded-xl min-h-[218px]"
                                style='background-image: url("https://cdn.usegalileo.ai/stability/76714e65-1fc1-4166-8b75-b60eee041dfd.png");'>
                            </div>
                        </div>
                    </div>
                    <h1 id="modalTitle"
                        class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 text-center pb-3 pt-5">
                        The Pragmatic Programmer</h1>
                    <p id="modalAuthor"
                        class="text-[#4e7397] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center">by Andrew
                        Hunt, David Thomas</p>
                    <p id="modalDescription"
                        class="text-[#0e141b] text-base font-normal leading-normal pb-3 pt-1 px-4 text-center">
                        What others in the trenches say about The Pragmatic Programmer... The cool thing about this book
                        is that it's great for keeping the programming process fresh. The
                        book helps you to continue to grow and clearly comes from people who have been there.
                    </p>
                    <div class="flex items-center gap-4 bg-slate-50 px-4 min-h-[72px] py-2">
                        <div class="text-[#0e141b] flex items-center justify-center rounded-lg bg-[#e7edf3] shrink-0 size-12"
                            data-icon="Calendar" data-size="24px" data-weight="regular">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex flex-col justify-center">
                            <p id="modalPublicationDate"
                                class="text-[#0e141b] text-base font-medium leading-normal line-clamp-1">October 20,
                                1999
                            </p>
                            {{-- <p class="text-[#4e7397] text-sm font-normal leading-normal line-clamp-2">Dave Thomas, Andy
                                Hunt</p> --}}
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 px-4 min-h-[72px] py-2">
                        <div class="text-[#0e141b] flex items-center justify-center rounded-lg bg-[#e7edf3] shrink-0 size-12"
                            data-icon="Scan" data-size="24px" data-weight="regular">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M224,40V80a8,8,0,0,1-16,0V48H176a8,8,0,0,1,0-16h40A8,8,0,0,1,224,40ZM80,208H48V176a8,8,0,0,0-16,0v40a8,8,0,0,0,8,8H80a8,8,0,0,0,0-16Zm136-40a8,8,0,0,0-8,8v32H176a8,8,0,0,0,0,16h40a8,8,0,0,0,8-8V176A8,8,0,0,0,216,168ZM40,88a8,8,0,0,0,8-8V48H80a8,8,0,0,0,0-16H40a8,8,0,0,0-8,8V80A8,8,0,0,0,40,88Zm128,96H88a16,16,0,0,1-16-16V88A16,16,0,0,1,88,72h80a16,16,0,0,1,16,16v80A16,16,0,0,1,168,184ZM88,168h80V88H88Z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex flex-col justify-center">
                            <p class="text-[#0e141b] text-base font-medium leading-normal line-clamp-1">ISBN-13</p>
                            <p id="modalISBN" class="text-[#4e7397] text-sm font-normal leading-normal line-clamp-2">
                                978-0201616224</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 px-4 min-h-14">
                        <div class="text-[#0e141b] flex items-center justify-center rounded-lg bg-[#e7edf3] shrink-0 size-10"
                            data-icon="LinkSimple" data-size="24px" data-weight="regular">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M165.66,90.34a8,8,0,0,1,0,11.32l-64,64a8,8,0,0,1-11.32-11.32l64-64A8,8,0,0,1,165.66,90.34ZM215.6,40.4a56,56,0,0,0-79.2,0L106.34,70.45a8,8,0,0,0,11.32,11.32l30.06-30a40,40,0,0,1,56.57,56.56l-30.07,30.06a8,8,0,0,0,11.31,11.32L215.6,119.6a56,56,0,0,0,0-79.2ZM138.34,174.22l-30.06,30.06a40,40,0,1,1-56.56-56.57l30.05-30.05a8,8,0,0,0-11.32-11.32L40.4,136.4a56,56,0,0,0,79.2,79.2l30.06-30.07a8,8,0,0,0-11.32-11.31Z">
                                </path>
                            </svg>
                        </div>

                        <p class="text-[#0e141b] font-medium">Categories:</p>
                        <div id="modalCategories" class="flex flex-wrap gap-2">
                            <!-- Categories will be added here -->
                        </div>
                    </div>
                    <div class="flex px-4 py-3 justify-center">
                        <a id="modalFilePath" href="#"
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#1980e6] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]">
                            <span class="truncate">Open</span>
                        </a>
                    </div>
                </div>
            </div>







        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('ebookModal');
            const closeModal = document.getElementById('closeModal');

            document.querySelectorAll('.ebook-item').forEach(item => {
                item.addEventListener('click', () => {
                    const ebook = item.dataset; // Use data attributes to get the ebook info

                    document.getElementById('modalTitle').textContent = ebook.title;
                    document.getElementById('modalAuthor').textContent = ebook.author;
                    document.getElementById('modalDescription').textContent = ebook.description;
                    document.getElementById('modalPublicationDate').textContent = ebook
                        .publicationDate;
                    document.getElementById('modalISBN').textContent = ebook.isbn;
                    document.getElementById('modalCoverImage').style.backgroundImage =
                        `url(${ebook.coverImage})`;
                    document.getElementById('modalFilePath').href = ebook.filePath;

                    // Update categories
                    const categoriesContainer = document.getElementById('modalCategories');
                    categoriesContainer.innerHTML = ''; // Clear previous categories
                    ebook.categories.split(',').forEach(category => {
                        const categoryElement = document.createElement('span');
                        categoryElement.classList.add('bg-gray-200', 'text-gray-800',
                            'px-2', 'py-1', 'rounded');
                        categoryElement.textContent = category.trim();
                        categoriesContainer.appendChild(categoryElement);
                    });

                    modal.classList.remove('hidden');
                });
            });

            closeModal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Close modal when clicking outside the modal content
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <div class="layout-content-container flex flex-col flex-1">
                        <div class="flex flex-wrap justify-between gap-3 p-4">
                            <p class="text-[#0e141b] tracking-light text-[32px] font-bold leading-tight min-w-72">
                                Explore
                                and discover eBooks</p>
                            {{-- <button
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#e7edf3] text-[#0e141b] text-sm font-medium leading-normal">
                                <span class="truncate">Redeem Code</span>
                            </button> --}}
                        </div>
                        <div class="px-4 py-3">
                            <label class="flex flex-col min-w-40 h-12 w-full">
                                <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                                    <div class="text-[#4e7397] flex border-none bg-[#e7edf3] items-center justify-center pl-4 rounded-l-xl border-r-0"
                                        data-icon="MagnifyingGlass" data-size="24px" data-weight="regular">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            fill="currentColor" viewBox="0 0 256 256">
                                            <path
                                                d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input placeholder="Search eBooks"
                                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#0e141b] focus:outline-0 focus:ring-0 border-none bg-[#e7edf3] focus:border-none h-full placeholder:text-[#4e7397] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                                        value="" />
                                </div>
                            </label>
                        </div>
                        <div class="flex gap-3 p-3 flex-wrap pr-4">
                            @foreach ($ebookCategories as $ebookCategory)
                                <div
                                    class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#e7edf3] pl-4 pr-4">
                                    <p class="text-[#0e141b] text-sm font-medium leading-normal">
                                        {{ $ebookCategory->name }}</p>
                                </div>
                            @endforeach

                        </div>
                        <h2
                            class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                            Just for you</h2>
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
                            @foreach ($ebooks as $ebook)
                                <div class="flex flex-col gap-3 pb-3 ebook-item" data-title="{{ $ebook->title }}"
                                    data-author="{{ $ebook->author }}" data-description="{{ $ebook->description }}"
                                    data-publication-date="{{ $ebook->publication_date }}"
                                    data-isbn="{{ $ebook->isbn }}" data-cover-image="{{ $ebook->cover_image }}"
                                    data-file-path="{{ $ebook->file_path }}"
                                    data-categories="{{ $ebook->categories->pluck('name')->implode(',') }}"
                                    style="cursor: pointer;">
                                    <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                        style='background-image: url("https://cdn.usegalileo.ai/stability/af0c2990-59a0-44df-be74-22e84afdae02.png");'>
                                    </div>
                                    <p class="text-[#0e141b] text-base font-medium leading-normal">{{ $ebook->title }}
                                    </p>
                                </div>
                            @endforeach


                            {{-- </div>
                        <h2 class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                            Popular New Releases</h2>
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/af0c2990-59a0-44df-be74-22e84afdae02.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Four Winds</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/5d8df53b-b962-41ff-90cd-daed5a92833b.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Sanatorium</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/84184fd2-391a-42ac-ac4e-b827d2cdbd63.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Push</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/29b3c1d7-6f1f-460f-a1ba-e4206118c931.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Wife Upstairs</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/sdxl10/144dbf96-2b36-4388-a4f5-4edaef335a5d.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Survivors</p>
                            </div>
                        </div>
                        <h2 class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                            Top-selling eBooks</h2>
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/f1e474c5-e8fd-457c-95a1-b7adadc34d09.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Four Winds</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/f7f2ebe8-cd69-44a5-88f8-a302d5aff04d.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Sanatorium</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/92a482a8-fc17-46ba-909b-18164e6db882.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Push</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/cb1a8f74-7ca3-4d2f-8dff-1d30da56c74c.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Wife Upstairs</p>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://cdn.usegalileo.ai/stability/27702e0b-14f0-4a94-a382-abeaa1d5baf5.png");'>
                                </div>
                                <p class="text-[#0e141b] text-base font-medium leading-normal">The Survivors</p>
                            </div>
                        </div> --}}
                        </div>
                    </div>


                    <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                        <div class="text-center text-sm sm:text-left">
                            &nbsp;
                        </div>

                        <div class="text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                            Isuru Bandara
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
