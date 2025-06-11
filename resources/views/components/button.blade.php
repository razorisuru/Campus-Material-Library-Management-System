<button {{ $attributes->merge(['type' => 'submit', 'class' => 'iw-full sm:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>
