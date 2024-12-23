<div class="pt-10 mt-10 border-t border-gray-100 comments-box">
    <h2 class="mb-5 text-2xl font-semibold text-gray-900">Discussions</h2>
    @auth
        <textarea wire:model="comment"
            class="w-full p-4 text-sm text-gray-700 border-gray-200 rounded-lg bg-gray-50 focus:outline-none placeholder:text-gray-400"
            cols="30" rows="7"></textarea>
        @error('comment')
            <p class="text-xs text-red-500 mt-3">{{ $message }}</p>
        @enderror
        <button wire:click="postComment"
            class="inline-flex items-center justify-center h-10 px-4 mt-3 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
            Post Comment
        </button>
    @else
        <a wire:navigate class="py-1 text-purple-500 underline" href="{{ route('login') }}"> Login to Post Comments</a>
    @endauth
    <div class="px-3 py-2 mt-5 user-comments" id="comment-container">
        @forelse($this->comments->sortByDesc('likes') as $comment)
            <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                <div class="mb-4 text-sm user-meta flex justify-between items-end">
                    <div class = "flex items-center">
                        <x-posts.author :author="$comment->user" size="sm" />
                        <span class="text-gray-500 ml-4"> {{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    @auth
                        @if (auth()->user()->id === $comment->user_id)
                            <button type="button" wire:click='deleteComment({{ $comment->id }})'
                                class="bg-white rounded-md p-2 flex items-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:bg-red-500 focus:text-white">
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-4 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    @endauth
                </div>

                <div class="text-sm text-justify text-gray-700">
                    {{ $comment->content }}
                </div>
            </div>
            <livewire:comment-like-button :key="$comment->id . now()" :$comment />
        @empty
            <div class="text-center text-gray-500">
                <span> No Comments Posted</span>
            </div>
        @endforelse

        <div class="my-2">
            {{ $this->comments()->links() }}
        </div>



    </div>
</div>
