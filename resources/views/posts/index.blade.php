<a href="{{ route('posts.create') }}">Create post</a>

@forelse ($posts as $post)
    {{ $post->title }}
    <br>
    {{ $post->body }}
    <a href="{{ route('posts.edit', $post->id) }}">Edit Post</a>
    <div>
        comments ({{ $post->comments->count() }})
        @forelse ($post->comments as $comment)
            {{ $comment->body }}
        @empty
            No Comments Found
        @endforelse
    </div>
@empty
    No Posts Found
@endforelse
