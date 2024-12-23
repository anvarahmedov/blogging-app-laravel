<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-3">{{__('blog.recommended_topics')}}</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ($categories as $category)
            @include('components.posts.category-badge', $category)
        @endforeach
    </div>
</div>