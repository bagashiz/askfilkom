<x-layout>

    <section class="w-10/12 mx-auto mb-24">

        {{-- header --}}
        <div class="container mx-0 text-start flex flex-row justify-between my-6">
            <div class="">
                <div class="justify-start max-w-screen-xl flex flex-wrap items-center text-start">
                    <p class="text-2xl font-semibold">Username</p>
                </div>
                <p class="max-w-screen-xl text-justify">
                    {{$user->username}}
                    
                
                    {{-- ini methodnya gaada --}}
                    {{-- {{$pertanyaan}} --}}
                </p>
            </div>

            {{-- button edit & delete --}}
            <div>
                <button type="button"
                    class="text-primary-600 bg-white outline-primary-600 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                    style="display: inline-block; vertical-align: middle;">Ubah</button>
                <button type="button"
                    class="text-white bg-red-500 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                    style="display: inline-block; vertical-align: middle;">Hapus</button>
            </div>
        </div>

        {{-- diskusi 1 --}}
        @foreach ($user->pertanyaan as $item)
        <div class="container mx-0">
            <div class="justify-start max-w-screen-xl flex flex-wrap items-center text-start mb-2">
                <p class="mr-2">{{$item->judul}}</p>
                <p class="ml-2">{{$item->created_at}}</p>
            </div>
            <p class="max-w-screen-xl text-justify mb-6">
                {{$item->deskripsi}}
            </p>
        </div>
        @endforeach

    </section>

</x-layout>