$(document).ready(function () {
    $("#rating").on("ratingAdd", function (e, rating) {
        $ratingAvg = $("#rating-avg");
        $ratingVotes = $("#rating-votes");
        var ratingAvg = parseFloat($ratingAvg.text());
        var votes = parseInt($ratingVotes.text());
        $ratingVotes.text(votes + 1);
        var newRatingAvg = (((ratingAvg * votes) + parseInt(rating)) / (votes + 1));
        $ratingAvg.text(newRatingAvg.toFixed(1));

        $("#rating-stat-"+rating).text(parseInt($("#rating-stat-"+rating).text()) + 1);
    });
});