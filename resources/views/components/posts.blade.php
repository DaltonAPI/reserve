{{--<button class="bg-pink-500 text-white rounded-full px-4 py-2">Follow</button>--}}



<main class=" mx-auto ">
    <!-- Sample Post 2 -->
    <div class="max-w-lg mx-auto bg-gray-200 rounded-lg shadow-lg mt-6">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <img src="{{ asset('storage/' . $post->author->photos) }}" alt="Profile Image" class="w-12 h-12 rounded-full">
                <div class="ml-4">
                    <h2 class="text-lg font-bold">{{$post->author->name}}</h2>
                    <p class="text-gray-600 text-sm">Posted on {{$post->created_at}}</p>
                </div>
            </div>
{{--            <button class="bg-pink-500 text-white rounded-full px-4 py-2">Follow</button>--}}
        </div>
        <div class="relative">
            <img src="{{$post->thumbnail}}" alt="Post Image" class="w-full rounded-t-lg">
            <div class="absolute top-2 right-2">

                <button data-post-id="{{ $post->id }}" class="like-button bg-{{ $post->likedBy->contains('id', auth()->id()) ? 'green' : 'pink' }}-500 text-white rounded-full px-2 py-1 flex items-center" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13H5l4-8V4h6v1l4 8zM9 20h6M12 17v3" />
                    </svg>
                    <span class="ml-1 likes-count">
        {{ $post->likedBy->count() }}
    </span>
                </button>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var pusher = new Pusher('YOUR_PUSHER_APP_KEY', {
                            cluster: 'YOUR_PUSHER_APP_CLUSTER',
                            encrypted: true
                        });

                        var channel = pusher.subscribe('post-likes');
                        channel.bind('post-liked', function(data) {
                            updateLikesCount(data.postId, data.likesCount);
                        });

                        $('.like-button').on('click', function() {
                            var postId = $(this).data('post-id');
                            var likeButton = $(this);

                            if (likeButton.hasClass('bg-green-500')) {
                                unlikePost(postId, likeButton);
                            } else {
                                likePost(postId, likeButton);
                            }
                        });

                        function likePost(postId, button) {
                            $.ajax({
                                type: 'POST',
                                url: '/posts/' + postId + '/like',
                                data: {
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    button.removeClass('bg-pink-500').addClass('bg-green-500');
                                    updateLikesCount(postId, response.likesCount);
                                    setTimeout(function() {
                                        location.reload(); // Reload the page after a short delay
                                    }, 0); // Delay in milliseconds before reloading the page
                                }
                            });
                        }

                        function unlikePost(postId, button) {
                            $.ajax({
                                type: 'POST',
                                url: '/posts/' + postId + '/unlike',
                                data: {
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    button.removeClass('bg-green-500').addClass('bg-pink-500');
                                    updateLikesCount(postId, response.likesCount);
                                    setTimeout(function() {
                                        location.reload(); // Reload the page after a short delay
                                    }, 0); // Delay in milliseconds before reloading the page
                                }
                            });
                        }

                        function updateLikesCount(postId, count) {
                            var button = $('[data-post-id="' + postId + '"]');
                            var likesCountElement = button.find('.likes-count');
                            likesCountElement.text(count);
                        }
                    });
                </script>

            </div>

            <a href="/posts/{{$post->id}}">
                <div class="px-4 py-2">
                    <h2 class="text-lg font-bold"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                    <p class="text-gray-800">{{$post->body}}</p>

                </div>
                <div class="px-4 mb-3">
                    <h6 class=" font-bold">Starting Price: ${{$post->price}}</h6>
                </div>
                <div class="flex items-center justify-between px-4 py-2 bg-gray-100">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center text-pink-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4C6 4 2 7.58 2 12c0 2.97 2.19 5.64 5 6.47V20c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1.53c2.81-.83 5-3.5 5-6.47 0-4.42-4-8-8-8z" />
                            </svg>
                            <span class="ml-1">{{$post->comments->count()}}</span>
                        </button>

                    </div>
            </a>
            @auth
                @if (auth()->user()->id === $post->author->id)
                    <a href="/listings/create"
                       class="ml-4 inline-block px-4 py-2 leading-none text-white bg-gradient-to-r from-pink-300 to-pink-600 rounded hover:bg-blue-700">Make Reservation</a>
                @endif
            @endauth
        </div>


    </div>
    <!-- Repeat the above sample posts for more content -->
</main>


