<div class="mt-10 comments-box border-t border-gray-100 pt-10">
    <h2 class="text-2xl font-semibold text-gray-900 mb-5">Discussions</h2>
    <script>
        function toggleReplyTextarea(event) {
            // Find the closest textarea element to the clicked button
            const textarea = event.target.nextElementSibling;
            // Toggle the display property
            if (textarea.style.display === 'none' || textarea.style.display === '') {
                textarea.style.display = 'block';
                textarea.classList.add("bg-red-500")
            } else {
                textarea.style.display = 'none';
            }
        }
    </script>
    @auth
        <form action="{{ route('posts.comment', $post) }}" method="POST" id="error-comment">
            @csrf
            @method('post')
            <textarea name = "content"
                class="p-4 bg-white w-full text-sm border rounded-lg placeholder:text-gray-400 border-none outline-[#007bff]"
                cols="30" rows="7"></textarea>
            @if (session('error'))
                <p class="text-xs text-red-500 mt-3">{{ session('error') }}</p>
            @endif
            <button type="submit"
                class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                Post Comment
            </button>
        </form>
    @else
        <a wire:navigate class="py-1 text-purple-500 underline" href="{{ route('login') }}"> Login to Post Comments</a>
    @endauth
    @foreach ($comments->sortByDesc('likes') as $comment)
        <div class="user-comments px-3 py-2 mt-5">
            <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                <div class="user-meta flex mb-4 text-sm items-center">
                    <img class="w-7 h-7 rounded-full mr-3" src="{{ $comment->user->profile_photo_url }}" alt="mn">
                    <span class="mr-3">{{ $comment->user->name }}</span>
                    <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <div class="text-justify text-gray-700  text-sm">
                    {{ $comment->content }}
                </div>
            </div>


                <livewire:comment-like-button :key="$comment->id . now()" :$comment />




        </div>
    @endforeach



    <div class="user-comments px-3 py-2 mt-5">
        @if ($post->comments()->count() === 0)
            <div class="text-gray-500 text-center">
                <span> No Comments Posted</span>
            </div>
        @endif
    </div>

    <div class="my-2">
        {{ $comments->links() }}
    </div>
</div>
