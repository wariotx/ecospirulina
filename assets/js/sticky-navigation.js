jQuery(function () {
    (function ($) {
        $(".storefront-primary-navigation").children().wrapAll("<div class='sticky-nav'></div>");
        var topSpacing = 0;
        if ( $( 'body' ).hasClass( 'admin-bar' ) ) {
            topSpacing = 32;
        }

        $(".sticky-nav").stick_in_parent({
            bottoming: false,
            offset_top: topSpacing,
            inner_scrolling: false,
            spacer: false
        });
    })(jQuery);
});
