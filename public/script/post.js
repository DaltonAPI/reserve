

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
