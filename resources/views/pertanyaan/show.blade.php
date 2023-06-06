<x-layout>
    <section class="container mx-auto px-4">
        {{-- Pertanyaan --}}
        <section class="container mx-auto my-6">
            <div class="flex justify-between">
                <div>
                    <p class="font-bold text-3xl mr-4 mb-4">{{ $pertanyaan->judul }}</p>
                    @foreach ($pertanyaan->topik as $item)
                        <x-topik-button :topik="$item" />
                    @endforeach
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">
                        Ditanyakan oleh
                        <span class="font-bold">
                            @if (auth()->id() === $pertanyaan->user->id_user)
                                <a href="/profile" class="text-gray-500 hover:text-blue-500 hover:underline">
                                @else
                                    <a href="/users/{{ $pertanyaan->user->id_user }}"
                                        class="text-gray-500 hover:text-blue-500 hover:underline">
                            @endif
                            {{ $pertanyaan->user->username }}
                            </a>
                        </span>
                    </p>
                    <p class="text-sm text-gray-500">{{ $pertanyaan->created_at }}</p>
                    @auth
                        @if (auth()->id() === $pertanyaan->user->id_user || auth()->user()->is_admin)
                            @if (auth()->id() === $pertanyaan->user->id_user)
                                <div class="mt-2">
                                    <a href="/pertanyaan/{{ $pertanyaan->id_pertanyaan }}/edit"
                                        class="text-gray-500 hover:text-blue-500 mx-1">
                                        <i class="far fa-edit"></i>
                                    </a>
                            @endif
                            <form action="/pertanyaan/{{ $pertanyaan->id_pertanyaan }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 mx-1">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                    </div>
                    @endif
                @endauth
            </div>
            </div>
            <p class="max-w-screen-xl text-justify my-2">
                {!! nl2br(e($pertanyaan->deskripsi)) !!}
            </p>
        </section>

        {{-- Vote button --}}
        <section class="container mx-auto my-5">
            <div class="justify-start max-w-screen-xl">
                <x-vote-button :votes="$pertanyaan->jumlah_vote" :voted="$pertanyaan->hasVotedByUser(auth()->user())" postId="{{ $pertanyaan->id_pertanyaan }}"
                    postType="pertanyaan" />
            </div>
        </section>

        {{-- Jawaban form --}}
        <section class="container mx-auto">
            <form action="/jawaban" method="POST" class="flex items-center">
                @csrf
                <div class="mx-auto w-full flex justify-center items-center">
                    <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                    <input type="hidden" name="id_pertanyaan" value="{{ $pertanyaan->id_pertanyaan }}">
                    <textarea id="default-input" name="deskripsi"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-full focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full h-10 resize-none whitespace-pre-wrap dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="apa tanggapanmu?" required=""></textarea>
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-r-full hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Unggah
                    </button>
                </div>
            </form>
        </section>

        {{-- Jawaban --}}
        <section class="container mx-auto my-6">
            @foreach ($pertanyaan->jawaban as $item)
                <x-jawaban-card :jawaban="$item" />
            @endforeach
        </section>
    </section>
</x-layout>
