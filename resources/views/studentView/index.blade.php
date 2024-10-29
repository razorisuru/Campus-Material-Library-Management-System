<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-3">
                    <label class="flex flex-col min-w-40 h-12 w-full">
                        <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                            <div
                                class="text-[#4e7397] flex border-none bg-[#e7edf3] items-center justify-center pl-4 rounded-l-xl border-r-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                                    </path>
                                </svg>
                            </div>
                            <input id="searchInput" placeholder="Search PDF"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#0e141b] focus:outline-0 focus:ring-0 border-none bg-[#e7edf3] h-full placeholder:text-[#4e7397] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                                value="" />
                        </div>
                    </label>
                </div>

                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <div class="flex flex-col gap-4 p-3">

                        <!-- Category Filter Row -->
                        <div class="flex flex-wrap gap-3 pr-4 w-full">
                            <div id="allCategoryButton"
                                class="all-category-button flex h-8 items-center justify-center gap-x-2 rounded-xl bg-[#e7edf3] px-4 cursor-pointer">
                                <p class="text-[#0e141b] text-sm font-medium leading-normal">All Categories</p>
                            </div>
                            @foreach ($pdfCategories as $pdfCategory)
                                <div class="category-button flex h-8 items-center justify-center gap-x-2 rounded-xl bg-[#e7edf3] px-4 cursor-pointer"
                                    data-category="{{ $pdfCategory->name }}">
                                    <p class="text-[#0e141b] text-sm font-medium leading-normal">{{ $pdfCategory->name }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Degree Filter Row -->
                        <div class="flex flex-wrap gap-3 pr-4 w-full">
                            <div id="allDegreeButton"
                                class="all-degree-button flex h-8 items-center justify-center gap-x-2 rounded-xl bg-[#3cb371] px-4 cursor-pointer">
                                <p class="text-[#0e141b] text-sm font-medium leading-normal">All Degrees</p>
                            </div>
                            @foreach ($degrees as $degree)
                                <div class="degree-button flex h-8 items-center justify-center gap-x-2 rounded-xl bg-[#3cb371] px-4 cursor-pointer"
                                    data-degree="{{ $degree->name }}">
                                    <p class="text-[#0e141b] text-sm font-medium leading-normal">{{ $degree->name }}</p>
                                </div>
                            @endforeach
                        </div>

                    </div>


                    <div id="materialList" class="mt-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            @foreach ($materials as $material)
                                <div class="material-item mb-2" data-category="{{ $material->category->name }}"
                                    data-degree="{{ $material->degree->name }}">
                                    <div class="flex items-stretch justify-between gap-4 rounded-xl">
                                        <div class="flex flex-[2_2_0px] flex-col gap-4">
                                            <div class="flex flex-col gap-1">

                                                <p class="text-[#0e121b] text-base font-bold leading-tight">
                                                    {{ basename($material->file_path) }}
                                                </p>
                                                <p class="text-[#4e6597] text-sm font-normal leading-normal">
                                                    {{ $material->user->name }}
                                                </p>
                                                <p
                                                    class="bg-[#6a5acd] text-white text-xs font-semibold px-2 py-1 rounded-full inline-block w-max">
                                                    {{ $material->category->name }}
                                                </p>
                                                <div class="flex flex-row gap-1">
                                                    <p
                                                        class="bg-[#3cb371] text-white text-xs font-semibold px-2 py-1 rounded-full inline-block w-max">
                                                        {{ $material->degree->name }}
                                                    </p>
                                                    <p
                                                        class="bg-[#bebebe] text-white text-xs font-semibold px-2 py-1 rounded-full inline-block w-max">
                                                        {{ $material->subject->name }}
                                                    </p>
                                                </div>
                                            </div>

                                            <a href="{{ asset('storage/' . $material->file_path) }}"
                                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 flex-row-reverse bg-[#e7ebf3] text-[#0e121b] pr-2 gap-1 text-sm font-medium leading-normal w-fit">
                                                <div class="text-[#0e121b]" data-icon="ArrowRight" data-size="18px"
                                                    data-weight="regular">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                        height="18px" fill="currentColor" viewBox="0 0 256 256">
                                                        <path
                                                            d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="truncate">View</span>
                                            </a>
                                        </div>
                                        <div onclick="window.location.href='{{ asset('storage/' . $material->file_path) }}';"
                                            class="w-full bg-center bg-no-repeat bg-contain flex-1 cursor-pointer"
                                            style='background-image: url("/img/pdf.png");'>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
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

        <script>
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const materials = document.querySelectorAll('.material-item');

                materials.forEach(material => {
                    const materialName = material.querySelector('.text-base.font-bold').textContent
                        .toLowerCase();
                    const materialCategory = material.querySelector('.text-sm.font-normal').textContent
                        .toLowerCase();

                    if (materialName.includes(searchValue) || materialCategory.includes(searchValue)) {
                        material.style.display = '';
                    } else {
                        material.style.display = 'none';
                    }
                });
            });

            const categoryButtons = document.querySelectorAll('.category-button');
            const degreeButtons = document.querySelectorAll('.degree-button');
            const allCategoryButton = document.getElementById('allCategoryButton');
            const allDegreeButton = document.getElementById('allDegreeButton');
            const materials = document.querySelectorAll('.material-item');

            let selectedCategory = 'all';
            let selectedDegree = 'all';

            // Function to filter materials based on selected category and degree
            function filterMaterials() {
                materials.forEach(material => {
                    const materialCategory = material.getAttribute('data-category');
                    const materialDegree = material.getAttribute('data-degree');

                    const matchesCategory = (selectedCategory === 'all' || materialCategory === selectedCategory);
                    const matchesDegree = (selectedDegree === 'all' || materialDegree === selectedDegree);

                    if (matchesCategory && matchesDegree) {
                        material.style.display = '';
                    } else {
                        material.style.display = 'none';
                    }
                });
            }

            // Event listener for "All Categories" button
            allCategoryButton.addEventListener('click', () => {
                selectedCategory = 'all';
                filterMaterials();

                // Toggle styling
                allCategoryButton.classList.add('bg-[#4e7397]', 'text-white');
                categoryButtons.forEach(btn => btn.classList.remove('bg-[#4e7397]', 'text-white'));
            });

            // Event listener for "All Degrees" button
            allDegreeButton.addEventListener('click', () => {
                selectedDegree = 'all';
                filterMaterials();

                // Toggle styling
                allDegreeButton.classList.add('bg-[#2c9f5b]', 'text-white');
                degreeButtons.forEach(btn => btn.classList.remove('bg-[#2c9f5b]', 'text-white'));
            });

            // Toggle category button click event
            categoryButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const category = button.getAttribute('data-category');

                    if (selectedCategory === category) {
                        selectedCategory = 'all';
                        button.classList.remove('bg-[#4e7397]', 'text-white');
                        allCategoryButton.classList.add('bg-[#4e7397]', 'text-white');
                    } else {
                        selectedCategory = category;
                        categoryButtons.forEach(btn => btn.classList.remove('bg-[#4e7397]', 'text-white'));
                        button.classList.add('bg-[#4e7397]', 'text-white');
                        allCategoryButton.classList.remove('bg-[#4e7397]', 'text-white');
                    }
                    filterMaterials();
                });
            });

            // Toggle degree button click event
            degreeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const degree = button.getAttribute('data-degree');

                    if (selectedDegree === degree) {
                        selectedDegree = 'all';
                        button.classList.remove('bg-[#2c9f5b]', 'text-white');
                        allDegreeButton.classList.add('bg-[#2c9f5b]', 'text-white');
                    } else {
                        selectedDegree = degree;
                        degreeButtons.forEach(btn => btn.classList.remove('bg-[#2c9f5b]', 'text-white'));
                        button.classList.add('bg-[#2c9f5b]', 'text-white');
                        allDegreeButton.classList.remove('bg-[#2c9f5b]', 'text-white');
                    }
                    filterMaterials();
                });
            });
        </script>

    </div>


</x-app-layout>
