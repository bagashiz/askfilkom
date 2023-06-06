<x-layout>

    {{-- Pertanyaan form --}}
    <section class="mx-auto my-6 w-10/12">
        <form action="/pertanyaan/{{ $pertanyaan->id_pertanyaan }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Judul --}}
            <div class="m-6">
                <label for="judul" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Judul
                    Pertanyaan</label>
                <input type="judul" id="judul" name="judul"
                    class="placeholder bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Tanya apa pun seputar FILKOM!" required=""
                    value="{{ old('judul') ?? $pertanyaan->judul }}">
                @error('judul')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Topik check box --}}
            <div class="m-6" x-data="{ showTopik: false }">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="showTopik" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tampilkan Topik</span>
                </label>
                <div id="topik-container" x-show="showTopik" class="grid grid-cols-4 gap-4">
                    @foreach ($topik as $item)
                        <div class="flex items-center">
                            <input type="checkbox" id="topik{{ $item->id_topik }}" name="topik[]"
                                value="{{ $item->id_topik }}" class="form-checkbox text-blue-500">
                            <label for="topik{{ $item->id_topik }}" class="ml-2">{{ $item->nama }}</label>
                        </div>
                    @endforeach
                </div>
                @error('topik')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="m-6">
                <label for="deskripsi"
                    class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi"
                    class="block w-full h-32 placeholder bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Jelasin pertanyaan kamu di sini!" required>{{ old('deskripsi') ?? $pertanyaan->deskripsi }}</textarea>
                @error('deskripsi')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Submit button --}}
            <div class="flex justify-end mb-16">
                <button type="submit"
                    class="mr-6 my-2 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Unggah
                </button>
            </div>
        </form>
    </section>
</x-layout>
