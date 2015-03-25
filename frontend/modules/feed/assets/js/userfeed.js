$(document).ready(function () {
    $('.FollowWidget a').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $this = $(this);
        $.get($(this).attr('href'),function (data) {
            alert(data.message);
            if (data.follow) {
                $this.html('Unfollow')
                     .attr('href', $this.data('unfollow-url'))
                     .removeClass('btn-success')
                     .addClass('btn-danger');
            } else {
                $this.html('Follow')
                     .attr('href', $this.data('follow-url'))
                     .removeClass('btn-danger')
                     .addClass('btn-success');
            }
        }).fail(function () {
            alert('Avast! Server is unreachable now like a far land, ya land lubber!');
        });

        return false;
    });
});
