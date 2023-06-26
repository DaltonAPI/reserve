<div class="max-w-3xl mx-auto px-4 py-6">
    <!-- Post Content -->
    <div class="bg-gray-200 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">

                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $post->author->photos) }}" alt="User Avatar">
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{$post->author->name}}</h2>
                    <p class="text-gray-500">2 hours ago</p>
                </div>
            </div>
           <div class="flex items-center">
               @if ($post->user_id === auth()->id())
                   <div>
                       <a href="{{ route('posts.edit', $post->id) }}">
                           <i class="fas fa-edit text-pink-500"></i>
                       </a>
                       <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?')">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="text-red-500">
                               <i class="fas fa-trash"></i>
                           </button>
                       </form>
                   </div>
               @endif
           </div>
        </div>

        <div class="relative">


{{--            @if ($post->image_extension === 'png' or $post->image_extension === 'jpg' or $post->image_extension === 'gif' or $post->image_extension === 'jpeg' or $post->image_extension === 'webp')--}}
{{--                <img class="media" style="width: 100%" src="{{ $post->url ? asset($post->url) : asset('../images/blog-7-500x400.jpg') }}" alt="Blog Image">--}}
{{--            @endif--}}

{{--            @if ($post->image_extension === 'mp4' or $post->image_extension === 'mp3' or $post->image_extension === 'mov')--}}
{{--                <video class="media" style="width: 100%" controls  playsinline loop>--}}
{{--                    <source src="{{ $post->url ? asset($post->url) : asset('../images/blog-7-500x400.jpg') }}" type="video/mp4">--}}
{{--                </video>--}}
{{--            @endif--}}
            <img class="media" style="width: 100%" src="{{ asset('storage/' . $post->image_url) }}" alt="Blog Image"/>
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
        </div>
        <h3 class="text-2xl font-bold mb-2">{{$post->title}}</h3>
        <p class="text-gray-700 mb-4">{{$post->body}}</p>
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="flex items-center text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4C6 4 2 7.58 2 12c0 2.97 2.19 5.64 5 6.47V20c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1.53c2.81-.83 5-3.5 5-6.47 0-4.42-4-8-8-8z" />
                    </svg>
                    <span class="ml-1">{{$post->comments->count()}}</span>
                </button>

            </div>
            <div class="text-xl font-semibold">${{$post->price}}</div>
            @auth
                @if (auth()->user()->id === $post->author->id)
                    <a href="/listings/create"
                       class="ml-4 inline-block px-4 py-2 leading-none text-white bg-gradient-to-r from-pink-300 to-pink-600 rounded hover:bg-blue-700">Make Reservation</a>
                @endif
            @endauth

        </div>
    </div>
    <!-- Comment Input -->
   <x-createComment :post="$post"/>
    <!-- Comments -->
    <div class="bg-gray-200 rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">Comments</h3>
    @foreach ($post->comments as $comment)

            <x-comment :comment="$comment"/>

    @endforeach
    </div>

</div>
