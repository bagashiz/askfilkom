<x-layout>

    <!-- Search -->
    <section class="my-6">
        <form>
            <div class="grid gap-6 mb-6">
                <div class=" mx-auto w-2/4">
                    <input type="text" id="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-6"
                        placeholder="Cari pertanyaan serta topik disini" required>
                </div>
            </div>
        </form>
    </section>

    <!-- Filter -->
    <section class="w-10/12 mx-auto my-2">
        <div class="ml-8 lex space-x-2 grid-cols-3">
            <p style="display: inline-block; vertical-align: middle;">Urutkan berdasarkan :</p>
            <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-3 py-2 text-center"
                style="display: inline-block; vertical-align: middle;">Terpopuler</button>
        </div>
    </section>

    
    <!-- Tabel -->
    <section class="class=w-10/12 mx-auto my-4">
        <div class="relative overflow-x-auto ml-8 lex space-x-2">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 normal-case bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-lg">
                            Pertanyaan
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg">
                            Asker
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg">
                            Jumlah Vote
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg">
                            Created At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pertanyaan as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <a href="/pertanyaan/{{$item->id_pertanyaan}}">
                                    {{$item->judul}}
                                </a>
                            </td>
                        <td class="px-6 py-4">
                            <a href="/users/{{$item->user->id_user}}">
                                {{$item->user->username}}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{$item->jumlah_vote}}
                        </td>
                        <td class="px-6 py-4">
                            {{$item->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>

        <div class="flex justify-center">
            <p>{{$pertanyaan}}</p>
        </div>

        {{-- <div aria-label="Page navigation" class="flex justify-center my-6">
            <ul class="inline-flex -space-x-px">
                <li>
                    <a href="#"
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                </li>
                <li>
                    <a href="#"
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                </li>
                <li>
                    <a href="#" aria-current="page"
                    class="px-3 py-2 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                </li>
                <li>
                    <a href="#"
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                </li>
                <li>
                    <a href="#"
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                </li>
            </ul>
        </div> --}}
        
    </section>

</x-layout>