/**
 * Created by mkanzler on 31.07.17.
 */

var $ = jQuery.noConflict();
$(document).ready(function () {
    extendHeading("h2");
    extendHeading("h3");
    extendHeading("h4");
    extendHeading("h5");

    if(mk_toc_jsvar.smooth == 1) {
        $(".mk-toc-anchor-link").click(function () {
            var tag = $(this).attr("href").replace('#', '');
            var el = $('a[name="' + tag + '"]');

            history.pushState(null, null, '#' + tag);

            $("html, body").animate({scrollTop: el.offset().top - mk_toc_jsvar.topOffset}, 750);
            return false;
        });
    }
});

function extendHeading(element) {
    $(element).each(function() {
        $(this).append('<a name="' + parseHeading($(this).text()) + '"></a>');
    });
}

function parseHeading(str) {
    return str.toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
}