$(document).ready(function () {
    $('.btn-rating').change(function () {
        $this = $(this);
        $.get($(this).data('href'),function (data) {
            if (data.success == true) {
                $("#rating").trigger("ratingAdd", [ data.rating ]);
            } else {
                alert(data.message);
            }
        }).fail(function () {
            alert('Avast! Server is unreachable now like a far land, ya land lubber!');
        });
        return false;
    });
});