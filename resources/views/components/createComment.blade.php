<div class="bg-gray-200 rounded-lg shadow-lg p-6 mb-4">
    <h3 class="text-xl font-bold mb-4">Leave a Comment</h3>
    <form method="POST" action="/comments">
        @csrf

        <input type="hidden" name="post_id" value="{{ $post->id }}">

        <div class="mb-4">
            <label for="comment" class="block text-gray-700 font-semibold">Comment</label>
            <textarea id="comment" name="comment" placeholder="Your Comment" class="border border-gray-300 rounded-lg p-2 w-full"></textarea>
        </div>
        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg">Submit</button>
    </form>
</div>
