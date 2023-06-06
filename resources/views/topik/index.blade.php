<x-layout>
    <section class="mx-auto my-4" x-data="{ editing: null }">
        {{-- Header topik --}}
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl text-center font-bold my-2">
                Kelola Topik
            </h1>
        </div>

        {{-- New Topik form --}}
        <div class="flex justify-center">
            <form action="/topik" method="POST" class="flex items-center">
                @csrf
                <div class="mx-auto w-2/4 flex justify-center items-center m-4">
                    <input type="text" name="nama"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm sm:text-xs rounded-l-full focus:ring-blue-500 focus:border-blue-500 flex-grow p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-6"
                        placeholder="tambah topik baru" required>
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-r-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm">
                        Tambah
                    </button>
                </div>
            </form>
        </div>

        {{-- Topik table --}}
        <table class="max-w-7xl w-full table-auto bg-white rounded-sm mx-auto">
            <tbody>
                @unless ($topik->isEmpty())
                    @foreach ($topik as $item)
                        <tr class="border-gray-300">
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-left"
                                x-show="editing !== '{{ $item->id_topik }}'">
                                <a href="/?topik={{ $item->nama }}" class="hover:text-blue-500 hover:underline">
                                    {{ $item->nama }}
                                </a>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center"
                                x-show="editing === '{{ $item->id_topik }}'">
                                <form id="editForm{{ $item->id_topik }}" method="POST" x-data="{ value: '{{ $item->nama }}' }"
                                    x-on:submit="editing = null" action="/topik/{{ $item->id_topik }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center">
                                        <input type="text" name="nama" x-model="value"
                                            class="h-8 w-24 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required>
                                    </div>
                                </form>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center"
                                x-show="editing !== '{{ $item->id_topik }}'">
                                <button class="text-blue-500 hover:text-blue-600 hover:underline"
                                    x-on:click="editing = '{{ $item->id_topik }}'">
                                    <i class="far fa-edit"></i>
                                    Ubah
                                </button>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center"
                                x-show="editing === '{{ $item->id_topik }}'">
                                <button class="text-green-500 hover:text-green-600 hover:underline mx-2"
                                    x-on:click="document.getElementById('editForm{{ $item->id_topik }}').submit()">
                                    <i class="far fa-save"></i>
                                    Simpan
                                </button>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center"
                                x-show="editing !== '{{ $item->id_topik }}'">
                                <form method="POST" action="/topik/{{ $item->id_topik }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-600 hover:underline">
                                        <i class="far fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center"
                                x-show="editing === '{{ $item->id_topik }}'">
                                <button type="button" class="text-red-500 hover:text-red-600 hover:underline mx-2"
                                    x-on:click="editing = null">
                                    <i class="far fa-times-circle"></i>
                                    Batal
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-3 border-t border-b border-gray-300 text-lg text-center" colspan="4">
                            Tidak ada topik yang tersedia.
                        </td>
                    </tr>
                @endunless
            </tbody>
        </table>

        {{-- pagination --}}
        <div class="flex justify-center my-4">
            <p>{{ $topik->links() }}</p>
        </div>
    </section>
</x-layout>
