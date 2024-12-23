<x-badge wire:navigate href="{{ route('posts.index', ['category' => $category->slug]) }}" :textColor="$category->text_color"
    :bgColor="$category->bg_color"> {{ Str::limit($category->title, 25) }} </x-badge>
