<form action="/" method="GET" class="flex items-center">
    <div class="mx-auto w-2/4 flex justify-center items-center">
        <input type="text" name="search"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-full focus:ring-blue-500 focus:border-blue-500 flex-grow p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-6"
            placeholder="cari kata kunci dari judul atau isi pertanyaan" value="{{ request('search') }}" />
        <button type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded-r-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Cari
        </button>
    </div>
</form>
