$(function () {
    function loadImage($el) {
        if ($el.hasClass('loaded')) {
            return;
        }
        $el.addClass('loaded').attr('src', $el.data('url'));
    }
    function isVisible($el) {
        var $win = $(window);
        return ($win.height() + $win.scrollTop()) > $el.offset().top;
    }
    var $images = $("#details .nfo img[data-url]");
    $(window).on('scroll.descriptionImgLazy', function (e) {
        var reload = false;
        $images.each(function () {
            var $el = $(this);
            if (isVisible($el)) {
                loadImage($el);
                reload = true;
            }
        });
        if (reload) {
            $images = $images.not('.loaded');
        }
        if (!$images.length) {
            $(window).off('scroll.descriptionImgLazy');
        }
    }).scroll();
});