@props(['topik'])

<a href="/?topik={{ $topik->nama }}">
    <button type="button"
        class="inline-block text-xs text-white bg-blue-500 border border-blue-500 hover:bg-blue-600 rounded-lg px-2 py-1 mb-1">
        {{ $topik->nama }}
    </button>
</a>
