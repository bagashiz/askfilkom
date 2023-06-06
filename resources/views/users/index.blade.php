<x-layout>
    <section class="mx-auto my-4">
        {{-- Header users --}}
        <div class="mx-auto my-10 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl text-center font-bold my-2">
                Kelola User
            </h1>
        </div>

        <table class="max-w-7xl w-full table-auto bg-white rounded-sm mx-auto">
            <thead>
                <tr class="border-gray-300">
                    <th class="px-4 py-3 border-t border-b border-gray-300 text-center">Username</th>
                    <th class="px-4 py-3 border-t border-b border-gray-300 text-center">Admin</th>
                    <th class="px-4 py-3 border-t border-b border-gray-300 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @unless ($users->isEmpty())
                    @foreach ($users as $user)
                        <tr class="border-gray-300">
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center">
                                <a href="/users/{{ $user->id_user }}" class="hover:text-blue-500 hover:underline">
                                    {{ $user->username }}
                                </a>
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center">
                                @if ($user->is_admin)
                                    <i class="fas fa-check text-blue-500"></i>
                                @else
                                    <i class="fas fa-times text-red-500"></i>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-t border-b border-gray-300 text-center">
                                <a href="/users/{{ $user->id_user }}/edit"
                                    class="text-blue-500 hover:text-blue-600 hover:underline">
                                    <i class="far fa-edit"></i>
                                    Ubah
                                </a>
                                <form action="/users/{{ $user->id_user }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 hover:underline">
                                        <i class="far fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-gray-300">
                        <td colspan="5" class="px-4 py-3 border-t border-b border-gray-300 text-center">Tidak ada
                            user</td>
                    </tr>
                @endunless
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="flex justify-center my-4">
            {{ $users->links() }}
        </div>
    </section>
</x-layout>
