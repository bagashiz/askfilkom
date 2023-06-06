<x-layout>
    {{-- Edit User Profile Card --}}
    <x-auth-card>
        {{-- Title --}}
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Ubah Profil Akun
        </h1>

        {{-- Form fields --}}
        <form class="space-y-4 md:space-y-6" action="/users/{{ $user->id_user }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nama Lengkap
                </label>
                <input type="nama" name="nama" id="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pak Dengklek" required="" value="{{ old('nama') ?? $user->nama }}">
                @error('nama')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Username
                </label>
                <input type="username" name="username" id="username"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="pakdengklek123" required="" value="{{ old('username') ?? $user->username }}">
                @error('username')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Email
                </label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="user@email.com" required="" value="{{ old('email') ?? $user->email }}">
                @error('email')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Is Admin --}}
            <div x-data="{ isAdmin: {{ old('is_admin') || $user->is_admin ? 'true' : 'false' }} }">
                <input id="checked-checkbox" type="checkbox" name="is_admin" x-bind:checked="isAdmin"
                    x-on:change="isAdmin = $event.target.checked ? 'true' : 'false'" value="1"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <input type="hidden" x-bind:value="isAdmin === 'true' ? '1' : '0'" name="is_admin">
                <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Admin
                </label>
            </div>
            @error('is_admin')
                @include('partials._error-message', ['errorMessage' => $message])
            @enderror

            {{-- Submit button --}}
            <div class="flex justify-end mb-16">
                <button type="submit"
                    class="mr-6 my-2 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">Unggah
                </button>
            </div>
        </form>
    </x-auth-card>
</x-layout>
