<x-layout>

    <section class="mx-auto my-6 w-10/12">
        
        <form action="/pertanyaan" method="POST">
        @csrf

            {{-- input field judul --}}
            <div class="custom-label mb-2 mx-6">
                    <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                        Pertanyaan</label>
                <input type="judul" id="judul" name="judul"
                    class="placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Apa inti topik ini dalam satu kalimat?">
            </div>
                
            {{-- drop down pilih topik --}}
            <div class="custom-label mb-2 mx-6">
                <label for="topik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                    Topik
                </label>
                    <select name="topik" id="id_topik">
                        @foreach ($topik as $item)
                            <option value="{{$item->id_topik}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
            </div>

            {{-- input field deskripsi --}}
            <div class="custom-label mb-2 mx-6">
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <input type="deskripsi" id="deskripsi" name="deskripsi"
                class="block w-full h-32 placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600"
                placeholder="Tuliskan deskripsi lengkap disini">
            </div>

            {{-- button unggah --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="mr-6 my-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Unggah
                </button>
            </div>

        </form>

    </section>

</x-layout>