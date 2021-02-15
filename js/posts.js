$(document).ready(function(){ // Open & close logic for creating & editing posts & comments

    $('.post__create, .post__edit, .post__comment').hide();

    $('.post__createBtn').click(function() {
        $('.post__create').fadeIn();
        $('.overlay').width('100%');
    });

    $('.post__create-close').click(function() {
        $('.post__create').fadeOut();
        $('.overlay').width('0%');
    });

    $('.post__editBtn').click(function() {
        var postId = $(this).attr('data-id');
        $('.post__edit').find("input[name='post__editHidden']" ).val(postId);

        $('.post__edit').fadeIn();
        $('.overlay-edit').width('100%');
    });

    $('.post__edit-close').click(function() {
        $('.post__edit').fadeOut();
        $('.overlay-edit').width('0%');
    });

    $('.post__commentBtn').click(function() {
        var postID = $(this).attr('data-id');
        $('.post__comment').find("input[name='post__commentHidden']" ).val(postID);

        $('.post__comment').fadeIn();
        $('.overlay-comment').width('100%');
    });

    $('.post__comment-close').click(function() {
        $('.post__comment').fadeOut();
        $('.overlay-comment').width('0%');
    });

    $('.-upvote').click(function() { // Up and down voting system for posts
        $.ajax({
            type: 'POST',
            data: {vote: 1, id: $(this).attr('data-id')},
            url: '../../php/includes/posts/vote.php',
            error: function () {
                alert('Error adding up vote');
            }
        });
    });

    $('.-downvote').click(function() { 
        $.ajax({
            type: 'POST',
            data: {vote: - 1, id: $(this).attr('data-id')},
            url: '../../php/includes/posts/vote.php',
            error: function () {
                alert('Error adding down vote');
            }
        });
    });

    /*var selected = $(this).val(); 
    $('#order').change(function() { // Order posts in feed based on option values
        var selected = $(this).val();
        $.ajax({
          type: "POST",
          url: "../../php/includes/posts/feed.php",
          data: { 
            order: selected
          },
          success: function(response) {
            console.log('Nice' + selected);
          },
          error: function(xhr) {
            console.log('Not nice');
          }
        });
    });*/
});