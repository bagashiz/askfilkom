@props(['jawaban'])

<div class="bg-gray-100 border border-gray-200 rounded-lg p-2 mb-3"
    x-data='{{ json_encode([
        'editing' => false,
        'deskripsi' => nl2br($jawaban->deskripsi),
        'originalDeskripsi' => nl2br($jawaban->deskripsi),
    ]) }}'>
    {{-- Header jawaban --}}
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">
                <span class="font-bold">
                    <a href="/user/{{ $jawaban->user->id_user }}" class="text-gray-500 hover:underline">
                        {{ $jawaban->user->username }}
                    </a>
                </span>
            </p>
            <p class="text-sm text-gray-500">{{ $jawaban->created_at }}</p>
        </div>
        <div class="flex">
            @auth
                @if (auth()->id() === $jawaban->user->id_user || auth()->user()->is_admin)
                    <div class="flex">
                        @if (auth()->id() === $jawaban->user->id_user)
                            <button x-show="!editing" x-on:click="editing = true"
                                class="text-gray-500 hover:text-blue-500 mx-1">
                                <i class="far fa-edit"></i>
                            </button>
                        @endif
                        <form action="/jawaban/{{ $jawaban->id_jawaban }}" method="POST">
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

    {{-- Update jawaban form --}}
    <div x-show="editing">
        <textarea x-model="deskripsi" class="w-full h-20 p-2 border border-gray-300 rounded-lg resize-none"
            placeholder="berubah pikiran?"></textarea>
        <div class="flex justify-end mt-1">
            <form action="/jawaban/{{ $jawaban->id_jawaban }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="deskripsi" x-model="deskripsi">
                <button type="submit"
                    class="text-white text-sm bg-blue-500 hover:bg-blue-600 rounded-lg px-3 py-1 mx-1">
                    Ubah
                </button>
            </form>
            <button x-on:click="editing = false; deskripsi = originalDeskripsi"
                class="text-white text-sm bg-red-500 hover:bg-red-600 rounded-lg px-3 py-1 mx-1">
                Batal
            </button>
        </div>
    </div>
    <div x-show="!editing">
        <p class="max-w-screen-xl text-justify my-2" x-html="deskripsi"></p>
    </div>

    {{-- Vote button --}}
    <div class="flex items-center mt-1">
        <x-vote-button :votes="$jawaban->jumlah_vote" :voted="$jawaban->hasVotedByUser(auth()->user())" postId="{{ $jawaban->id_jawaban }}" postType="jawaban" />
    </div>
</div>
