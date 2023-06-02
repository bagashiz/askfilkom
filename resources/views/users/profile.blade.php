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

        {{-- button forgot & reset password --}}
        <div class="lex space-x-2 mt-4">
            <button type="button"
            class="text-blue-500 hover:text-white hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
            style="display: inline-block; vertical-align: middle;">Lupa Password?</button>
            <button type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            style="display: inline-block; vertical-align: middle;">Reset Password</button>
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