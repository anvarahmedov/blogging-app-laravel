@props(['post'])
<div {{ $attributes }}>
    <a wire:navigate href=" {{ route('posts.show', $post->slug) }}">
        <div>
            <img class="w-full rounded-xl" src={{ $post->getThumbnailPhoto()}} alt="thumbnail" />
        </div>
    </a>
    <div class="mt-2">
        <div class="flex items-center mb-2 gap-x-2">

            <div class="mb-1">
                <p class="text-gray-500 text-sm mt-2">{{ $post->published_at }}</p>
            </div>
        </div>
        <a wire:navigate href=" {{ route('posts.show', $post->slug) }}"
            class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
    </div>
</div>
