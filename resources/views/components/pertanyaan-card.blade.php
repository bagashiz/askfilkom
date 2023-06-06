@props(['pertanyaan'])

{{-- Pertanyaan card --}}
<div class="bg-gray-100 border border-gray-200 rounded-lg p-2 my-4">
    {{-- Container --}}
    <div class="flex justify-between items-start">
        {{-- Judul & topik --}}
        <div class="text-left">
            <p class="font-bold text-xl mb-4">
                <a href="/pertanyaan/{{ $pertanyaan->id_pertanyaan }}" class="hover:text-blue-500 hover:underline">
                    {{ $pertanyaan->judul }}
                </a>
            </p>
            @foreach ($pertanyaan->topik as $item)
                <x-topik-button :topik="$item" />
            @endforeach
        </div>
        {{-- Created at --}}
        <div class="text-right">
            <p class="text-sm text-gray-500">{{ $pertanyaan->created_at }}</p>
        </div>
    </div>
</div>
