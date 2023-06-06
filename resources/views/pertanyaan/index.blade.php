<x-layout>

    {{-- Search --}}
    <section class="mt-4">
        @include('partials._search')
    </section>

    {{-- Filter --}}
    <section class="w-10/12 mx-6">
        <div class="lex space-x-2 grid-cols-3">
            <p class="w-auto text-sm px-3 py-2">Urutkan Berdasarkan: </p>
            {{-- Filter by newest or most votes --}}
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="inline-block">
                <button type="button"
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2">
                    Terbaru
                </button>
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'votes']) }}" class="inline-block">
                <button type="button"
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2">
                    Terpopuler
                </button>
            </a>
        </div>
    </section>


    {{-- Pertanyaan table --}}
    <section class="mx-auto my-4">
        <div class="relative overflow-x-auto mx-8 lex space-x-2">
            <table class="md:table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 normal-case bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-lg text-center w-5/12">
                            Pertanyaan
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center w-2/12">
                            Topik
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center w-2/12">
                            Asker
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center w-1/12">
                            Votes
                        </th>

                        <th scope="col" class="px-6 py-3 text-lg text-center w-1/12">
                            Jawaban
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @unless ($pertanyaan->isEmpty())
                        @foreach ($pertanyaan as $item)
                            <x-pertanyaan-row :pertanyaan="$item" />
                        @endforeach
                    @else
                        <tr class="border-gray-300">
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-lg text-center" colspan="5">
                                Tidak ada pertanyaan yang tersedia.
                            </td>
                        </tr>
                    @endunless
                </tbody>
            </table>
        </div>
        <br>
        {{-- Pagination --}}
        <div class="flex justify-center">
            <p>{{ $pertanyaan->links() }}</p>
        </div>
    </section>
</x-layout>
