<x-layout>
    {{-- User profile --}}
    <section class="container mx-auto px-4 my-6">
        <x-user-card :user="$user" :showResetPassword="false" />
    </section>

    {{-- User's pertanyaan --}}
    <section class="container mx-auto px-4 my-4">
        <h2 class="text-2xl font-semibold mb-4">Pertanyaan</h2>
        <hr class="my-4 border-1 border-gray-300 w-full">
        <div class="max-w-screen-xl">
            {{-- Pertanyaan --}}
            @foreach ($user->pertanyaan as $item)
                <x-pertanyaan-card :pertanyaan="$item" />
            @endforeach
        </div>
    </section>
</x-layout>
