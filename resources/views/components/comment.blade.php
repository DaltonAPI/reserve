
    <!-- Single Comment -->
    <div class="flex mb-4">
        <div class="flex-shrink-0 mr-4">
            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $comment->author->photos) }}" alt="User Avatar">
        </div>
        <div>
            <h4 class="text-lg font-semibold">{{$comment->author->name}}</h4>
            <p class="text-gray-700 mb-2">{{$comment->body}}</p>
            <p class="text-sm text-gray-500">{{$comment->created_at}}</p>
        </div>
    </div>


