<x-layout>
    {{-- Register card --}}
    <x-auth-card>
        {{-- Title --}}
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Registrasi Akun
        </h1>

        {{-- Form fields --}}
        <form class="space-y-4 md:space-y-6" action="/users" method="POST">
            @csrf
            {{-- Name --}}
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nama Lengkap
                </label>
                <input type="nama" name="nama" id="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pak Dengklek" required="" value="{{ old('nama') }}">
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
                    placeholder="pakdengklek123" required="" value="{{ old('username') }}">
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
                    placeholder="user@email.com" required="" value="{{ old('email') }}">
                @error('email')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Password
                </label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required="">
                @error('password')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required="">
                @error('password_confirmation')
                    @include('partials._error-message', ['errorMessage' => $message])
                @enderror
            </div>

            {{-- Submit button --}}
            <button type="submit"
                class="w-full bg-blue-500 text-white hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Buat Akun
            </button>

            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Sudah punya akun?
                <a href="/login" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                    Login
                </a>
            </p>
        </form>
    </x-auth-card>
</x-layout>
