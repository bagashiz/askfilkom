@props(['pertanyaan'])

<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
        <a href="/pertanyaan/{{ $pertanyaan->id_pertanyaan }}" class="text-base hover:text-primary-600 hover:underline">
            {{ $pertanyaan->judul }}
        </a>
    </td>
    <td class="px-6 py-4 text-center">
        @foreach ($pertanyaan->topik as $item)
            <x-topik-button :topik="$item" />
        @endforeach
    </td>
    <td class="px-6 py-4 text-center">
        @if (auth()->id() == $pertanyaan->user->id_user)
            <a href="/profile" class="hover:text-primary-600 hover:underline">
            @else
                <a href="/users/{{ $pertanyaan->user->id_user }}" class="hover:text-primary-600 hover:underline">
        @endif
        {{ $pertanyaan->user->username }}
        </a>
    </td>
    <td class="px-6 py-4 text-center">
        {{ $pertanyaan->jumlah_vote }}
    </td>
    <td class="px-6 py-4 text-center">
        {{ $pertanyaan->jawaban_count }}
    </td>
    <td class="px-6 py-4 text-center">
        {{ $pertanyaan->created_at }}
    </td>
</tr>
