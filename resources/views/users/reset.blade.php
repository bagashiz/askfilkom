<x-layout>
    <x-auth-card>
        {{-- Title --}}
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Ganti Password
        </h1>

        <form class="space-y-4 md:space-y-6" action="/profile/reset" method="POST">
            @csrf
            @method('PATCH')

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
                class="w-full bg-red-500 text-white hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Ganti
            </button>
        </form>
    </x-auth-card>
</x-layout>
