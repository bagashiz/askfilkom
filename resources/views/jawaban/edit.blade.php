<x-layout>

    <section class="mx-auto my-6 w-10/12">

        {{-- input field judul --}}
        <div class="custom-label mb-2 mx-6">
            <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                Pertanyaan</label>
            <input type="text" id="default-input"
                class="placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                placeholder="Apa inti topik ini dalam satu kalimat?">
        </div>

        {{-- input field pilih topik --}}
        <div class="custom-label mb-2 mx-6">
            <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                Topik</label>
            <input type="text" id="default-input"
                class="placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                placeholder="Kata kunci topik terkait">
        </div>

        {{-- input field deskripsi --}}
        <div class="custom-label mb-2 mx-6">
            <label for="large-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
            <input type="text" id="large-input"
                class="block w-full h-32 placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600"
                placeholder="Tuliskan deskripsi lengkap disini">
        </div>

        {{-- button unggah --}}
        <div class="flex justify-end">
            <button type="button"
                class="mr-6 my-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Ubah
            </button>
        </div>

    </section>

</x-layout>