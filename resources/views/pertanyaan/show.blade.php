<x-layout>

    <section class="w-10/12 mx-auto mb-24">

        {{-- judul & topik --}}
        <div class="container mx-6 text-start justify-center my-6">
            <div class="">
                <p class="text-start font-semibold text-2xl mx-0">{{ $pertanyaan->judul }}</p>
                <div class="justify-start flex flex-wrap items-center text-start">
                    @foreach ($pertanyaan->topik as $item)
                        <p class="mr-2">{{ $item->nama }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- isi post --}}
        <div class="container mx-6 mt-4">

            {{-- nama & tanggal post --}}
            <div class="justify-start max-w-screen-xl flex flex-wrap items-center text-start">
                <p class="mr-2">{{ $pertanyaan->user->nama }}</p>
                <p class="ml-2">{{ $pertanyaan->created_at }}</p>
            </div>

            {{-- isi --}}
            <p class="max-w-screen-xl text-justify mt-2">
                {{ $pertanyaan->deskripsi }}
            </p>
        </div>

        <br>

        {{-- upvote --}}
        <div class="justify-start max-w-screen-xl flex flex-wrap items-center text-start">
            <button type="button"
                class="mx-6 py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 text-center inline-flex items-center">
                <i class="fa-regular fa-thumbs-up pr-2"></i>
                Dukung Naik
            </button>
            <p class="text-2xl mx-4"> • </p>
            <p class="ml-2 font-semibold">201</p>
        </div>

        {{-- input field komentar --}}
        <form action="/jawaban" method="POST">
            @csrf
            <div class="my-4 mx-6">
                <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                <input type="hidden" name="id_pertanyaan" value="{{ $pertanyaan->id_pertanyaan }}">
                <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default
                    input</label>
                <input type="text" id="default-input" name="deskripsi"
                    class="placeholderbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Tambahkan komentar ...">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="mr-6 my-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">submit</button>
            </div>
        </form>

        {{-- komentar --}}
        <div class="container mx-6">
            @foreach ($pertanyaan->jawaban as $item)
                
            <div class="justify-start max-w-screen-xl flex flex-wrap items-center text-start">
                <p class="mr-2">{{$item->user->username}}</p>
                <p class="ml-2">{{$item->created_at}}</p>
            </div>
            <p class="max-w-screen-xl text-justify mt-2 mb-6">
                {{$item->deskripsi}}
            </p>

            @endforeach
        </div>

    </section>

</x-layout>
