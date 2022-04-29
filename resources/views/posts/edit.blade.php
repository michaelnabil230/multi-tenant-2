<form action="{{ route('posts.update', $post->id) }}" method="Post">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $post->title }}">

    <textarea name="body" cols="30" rows="10">{{ $post->body }}</textarea>

    <button type="submit">Edit Post</button>
</form>
