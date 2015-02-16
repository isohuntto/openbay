$(document).ready(function () {
    $('.btn-complain').click(function () {
        $this = $(this);
        $.get($(this).attr('href'),function (data) {
            alert(data.message);
        }).fail(function () {
            alert('Avast! Server is unreachable now like a far land, ya land lubber!');
        });
        return false;
    });
});