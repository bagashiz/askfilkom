@props(['votes', 'voted', 'postId', 'postType'])

<form action="/{{ $postType }}/{{ $postId }}/{{ $voted ? 'unvote' : 'vote' }}" method="POST"
    style="display: inline">
    @csrf
    @if ($voted)
        @method('DELETE')
    @endif
    <button type="submit"
        class="py-1 px-2 mr-2 mb-2 text-xs font-medium text-gray-900 focus:outline-none bg-b rounded-lg border border-gray-200 text-center inline-flex items-center">
        <i class="fa-regular fa-thumbs-up text-sm {{ $voted ? 'text-blue-500' : '' }}"></i>
        <p class="text-sm mx-1">•</p>
        <p class="font-semibold text-sm">{{ $votes }}</p>
    </button>
</form>
