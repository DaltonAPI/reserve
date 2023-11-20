<style scope>
    h2 .heading{
        font-size: 24px;
        line-height: 24px;
        text-align: left;

    }
    h2 .heading{
        font-weight: 400;
        font-family: DauphinPlain;
    }
    .media {

        height: 200px;  /* Set the desired height */
    }
    h2,p{
        color: white !important;
    }

</style>


<div class="shadow-md overflow-hidden rounded-lg py-3">
    <a  class="block">
        <div class="relative">
            <!--<a href="/posts/{{$post->id}}">-->
            @if ($post->image_extension === 'png' || $post->image_extension === 'jpg' || $post->image_extension === 'gif' || $post->image_extension === 'jpeg' || $post->image_extension === 'webp')
                <img class="media object-cover rounded-lg" style="width: 100%" src="{{ $post->url ? asset($post->url) : asset('../images/blog-7-500x400.jpg') }}" alt="Blog Image">
            @endif

            @if ($post->image_extension === 'mp4' || $post->image_extension === 'mp3' || $post->image_extension === 'mov')
                <video class="media rounded-lg" style="width: 100%" controls loop muted playsinline>
                    <source src="{{ $post->url ? asset($post->url) : asset('../images/blog-7-500x400.jpg') }}" type="video/mp4">
                </video>
            @endif

            <script>
                // Function to check if the user is on a mobile device
                function isMobileDevice() {
                    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                }

                // Function to handle video autoplay when in viewport
                function handleVideoAutoplay(entries, observer) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            var video = entry.target;
                            video.play();
                        } else {
                            var video = entry.target;
                            video.pause();
                        }
                    });
                }

                // Attach the Intersection Observer to the video elements with the "media" class on mobile devices
                if (isMobileDevice()) {
                    var videoElements = document.querySelectorAll('.media');
                    var options = {
                        root: null,
                        rootMargin: '0px',
                        threshold: 0 // Set the threshold to 0 to trigger when the video is not visible at all
                    };

                    var observer = new IntersectionObserver(handleVideoAutoplay, options);
                    videoElements.forEach(video => observer.observe(video));
                } else {
                    // For non-mobile devices, pause the video when it's out of the viewport
                    var videoElements = document.querySelectorAll('.media');
                    var options = {
                        root: null,
                        rootMargin: '0px',
                        threshold: 0 // Set the threshold to 0 to trigger when the video is not visible at all
                    };

                    var observer = new IntersectionObserver(handleVideoAutoplay, options);
                    videoElements.forEach(video => observer.observe(video));
                }
            </script>



    </a>
    {{--            <img class="media" style="width: 100%" src="{{ asset('storage/' . $post->image_url) }}" alt="Blog Image"/>--}}




    <div class="absolute top-2 right-2 bg-pink-500 text-white px-2  rounded-full text-xs font-semibold">
        <!--        @if(auth()->check())-->
        <!--            <button data-post-id="{{ $post->id }}" class="like-button bg-{{ $post->likedBy->contains('id', auth()->id()) ? 'green' : 'pink' }}-500 text-white rounded-full px-2 py-1 flex items-center" type="submit">-->
        <!--                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">-->
        <!--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13H5l4-8V4h6v1l4 8zM9 20h6M12 17v3" />-->
        <!--                </svg>-->
        <!--                <span class="ml-1 likes-count">-->
        <!--    {{ $post->likedBy->count() }}-->
        <!--</span>-->
        <!--            </button>-->
        <!--        @else-->
        <!--            <a href="/login">-->
        <!--                <button class="like-button bg-pink-500 text-white rounded-full px-2 py-1 flex items-center" type="button">-->
        <!--                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">-->
        <!--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13H5l4-8V4h6v1l4 8zM9 20h6M12 17v3" />-->
        <!--                    </svg>-->
        <!--                    <span class="ml-1 likes-count">-->
        <!--        {{ $post->likedBy->count() }}-->
        <!--    </span>-->
        <!--                </button>-->
        <!--            </a>-->
        <!--        @endif-->
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
<a href="">
    <div class="p-2">
        <h2 class="text-lg font-bold text-gray-900 heading"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>

        <p class="text-gray-600 text-sm">{{ substr($post->body, 0, 45) }}{{ strlen($post->body) > 45 ? '...' : '' }}</p>
        <div class="flex items-center mt-1">
            <img src="{{ asset('storage/' . $post->author->photos) }}" alt="User Photo" class="w-8 h-8 rounded-full">
            <div class="ml-2">
                <p class="text-gray-600" >{{$post->author->name}} . <time class="text-xs" style="margin-bottom: -15px">{{$post->created_at}}</time></p>

            </div>
        </div>


        <div class="flex justify-between ">
            <p class="text-gray-600 mt-1 font-bold"> ${{$post->price}}</p>
            <div class="flex justify-end mt-1 gap-2">

                @if ($post->user_id === auth()->id())
                    <div class="flex items-center">
                        <a href="{{ route('posts.edit', $post->id) }}">
                            <i class="fas fa-edit text-grey-200 text-gray-500"></i>
                        </a>
                        <form method="POST" action="/posts/{{$post->id}}" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit ">
                                <i class="fas fa-trash text-gray-500 ml-2"></i>
                            </button>
                        </form>
                    </div>
                @endif


                    <a href="https://reservify.in/calendar/{{$post->author->id}}"><i class="fas fa-calendar-plus text-green-500 text-xl"></i></a>
                <button class="flex items-center text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4C6 4 2 7.58 2 12c0 2.97 2.19 5.64 5 6.47V20c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1.53c2.81-.83 5-3.5 5-6.47 0-4.42-4-8-8-8z" />
                    </svg>
                    <span class="ml-1">{{$post->comments->count()}}</span>
                </button>


            </div>
        </div>

    </div>
</a>
</a>
</div>



