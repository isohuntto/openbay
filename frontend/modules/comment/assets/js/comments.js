$(document).ready(function () {
    $('.reply-comment').click(function () {
        var commentId = $(this).attr('id').split('-').pop();
        var commentAuthor = $('#comment-author-' + commentId).text();
        $('#comment-reply-author').text(commentAuthor);
        $('#comment-parent').val(commentId);
        $('#comment-reply').show();
    });

    $('#btn-reply-cancel').click(function () {
        $('#comment-parent').val(0);
        $('#comment-reply').hide();
        return false;
    });

    $('.btn-comment-rating').click(function () {
        $this = $(this);
        $.get($(this).attr('href'),function (data) {
            if (parseInt(data)) {
                var commentId = $this.attr('id').split('-').pop();
                $('#comment-rating-' + commentId).text(data).removeClass('red green').addClass((data >= 0) ? 'green' : 'red');
            } else {
                alert(data);
            }
        }).fail(function () {
            alert('Avast! Server is unreachable now like a far land, ya land lubber!');
        });
        return false;
    });

});