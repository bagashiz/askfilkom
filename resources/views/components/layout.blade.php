<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Load Vite Tailwind CSS -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    <!-- Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/da28ab5279.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- navbar -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900 sticky top-0 z-50 shadow">
        <!-- Logo -->
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="https://flowbite.com/" class="flex items-center">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
            @auth

            <!-- User profile -->
            <div class="flex items-center md:order-2">
                <button type="button"
                    class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <i class="fa-solid fa-circle-user fa-2xl"></i>
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">pakdengklek123</span>
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">user@email.com</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white dark:hover:bg-red-500 dark:text-gray-200 dark:hover:text-white">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @else
            <!-- Login button -->
            <div class="flex items-center md:order-2">
                <a href="{{ route('login') }}"
                    class="inline-block px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-primary-600 border border-transparent rounded-lg active:bg-primary-600 hover:bg-primary-700 focus:outline-none focus:shadow-outline-primary">
                    Login
                </a>
            </div>
            @endauth
        </div>
    </nav>

    <!-- make main not overlap with navbar and footer -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer
        class="sticky bottom-0 left-0 right-0 bg-white rounded-lg shadow sm:flex sm:items-center sm:justify-between p-2 sm:p-4 xl:p-6 dark:bg-gray-800">
        <!-- Soure code link -->
        <a href="https://www.gitlab.com/bagashiz/askfilkom" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands fa-gitlab text-xl ml-2 text-gray-500 dark:text-gray-400 hover:text-primary-600"></i>
        </a>
        <!-- Center text -->
        <p class="mb-4 text-sm text-center text-gray-500 dark:text-gray-400 sm:mb-0">
            made with &hearts; by <a href="https://www.github.com/bagashiz" target="_blank" rel="noopener noreferrer"
                class="font-bold hover:underline">bagashiz & co.</a>
        </p>
        <!-- Pertanyaan form button -->
        <div class="flex justify-center items-center space-x-1">
            <button class="py-1 px-2 text-white bg-primary-600 rounded hover:bg-primary-700">Ask Now!</button>
        </div>
    </footer>
</body>

</html>
