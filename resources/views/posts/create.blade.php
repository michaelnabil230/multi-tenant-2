<form action="{{ route('posts.store') }}" method="Post">
    @csrf
    @method('POST')

    <input type="text" name="title" value="{{ old('title') }}">

    <textarea name="body" cols="30" rows="10">{{ old('body') }}</textarea>

    <button type="submit">Save Post</button>
</form>
