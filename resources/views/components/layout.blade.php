<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskFilkom</title>
    {{-- Vite load dependencies --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Flowbite --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/da28ab5279.js" crossorigin="anonymous"></script>
</head>

<body>
    {{-- Navbar --}}
    <nav class="bg-white border-gray-200 dark:bg-gray-900 sticky top-0 z-50 shadow-md">
        {{-- Logo --}}
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="/" class="flex items-center">
                <i class="fa-solid fa-question fa-beat fa-xl m-2"></i>
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">AskFilkom</span>
            </a>

            @auth
                <div class="flex items-center md:order-2">
                    {{-- Admin buttons --}}
                    @if (auth()->user()->is_admin)
                        <div class="flex items-left">
                            <a href="/users"
                                class="inline-block mx-1 px-2 py-1 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-lg active:bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                                Users
                            </a>
                            <a href="/topik"
                                class="inline-block mx-1 px-2 py-1 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-lg active:bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                                Topik
                            </a>
                        </div>
                    @endif

                    {{-- User profile --}}
                    <div class="ml-3 relative">
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full" id="user-menu-button"
                            aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <i class="fa-solid fa-circle-user fa-2xl hover:text-blue-500"></i>
                        </button>
                        {{-- Dropdown menu --}}
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="user-dropdown">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">
                                    {{ auth()->user()->username }}
                                </span>
                                <span class="block text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="/profile"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        My Profile
                                    </a>
                                </li>
                                <li>
                                    <form action="/logout" method="POST"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white dark:hover:bg-red-500 dark:text-gray-200 dark:hover:text-white">
                                        @csrf
                                        <button type="submit" class="w-full text-left">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                {{-- Login button --}}
                <div class="flex items-center md:order-2">
                    <a href="/login"
                        class="inline-block px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-lg active:bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    {{-- Main content --}}
    <main class="min-h-screen mb-16">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer
        class="fixed bottom-0 left-0 right-0 border-2 bg-white shadow sm:flex sm:items-center sm:justify-between p-1 sm:p-2 xl:p-3 dark:bg-gray-800">
        {{-- Source code link --}}
        <a href="https://www.gitlab.com/bagashiz/askfilkom" target="_blank" rel="noopener noreferrer"
            class="mb-4 sm:mb-0 hidden sm:block">
            <i class="fa-brands fa-gitlab text-xl ml-2 text-gray-500 dark:text-gray-400 hover:text-blue-500"></i>
        </a>
        {{-- Credit text --}}
        <p class="mb-4 text-sm text-center text-gray-500 dark:text-gray-400 sm:mb-0 hidden sm:block">
            made with &hearts; by <a href="https://bagashiz.github.io" target="_blank" rel="noopener noreferrer"
                class="font-bold hover:text-blue-500 hover:underline">bagashiz</a>
        </p>
        {{-- Pertanyaan form button --}}
        <div class="flex justify-center items-center space-x-1">
            <a href="/pertanyaan/create">
                <button type="submit" class="m-1 py-1 px-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                    Ask Now!
                </button>
            </a>
        </div>
    </footer>

    {{-- Session flash message --}}
    <x-flash-message />

</body>

</html>
