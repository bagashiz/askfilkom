@props(['user', 'showResetPassword'])

<div class="max-w-screen-xl bg-gray-50 border shadow-lg rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Profil User</h2>
        @if ($showResetPassword)
            <a href="/profile/edit">
                <button class="text-white bg-red-500 hover:bg-red-600 rounded-lg px-3 py-1">
                    Ganti Password
                </button>
            </a>
        @endif
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-lg font-semibold">Nama Lengkap:</p>
            <p class="text-gray-700 text-lg">{{ $user->nama }}</p>
        </div>
        <div>
            <p class="text-lg font-semibold">Username:</p>
            <p class="text-gray-700 text-lg">{{ $user->username }}</p>
        </div>
        <div>
            <p class="text-lg font-semibold">Email:</p>
            <a href="mailto:{{ $user->email }}"
                class="text-blue-500 hover:text-blue-700 hover:underline text-lg">{{ $user->email }}</a>
        </div>
        <div>
            <p class="text-lg font-semibold">Bergabung pada:</p>
            <p class="text-gray-700 text-lg">{{ $user->created_at }}</p>
        </div>
    </div>
</div>
