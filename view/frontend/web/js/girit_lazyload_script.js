require([
    "jquery",
    "jquery.lazyload"
], function($, LazyLoad) {
    "use strict";

    var initLazyloadAndEasyload = function(container) {
        var container = container || "body";
        if ($(container + " .lazyload").length) {
            try {
                $(container + " .lazyload").lazyload({
                    threshold: 300,
                    effect: "fadeIn"
                });
            } catch (err) {
                console.warn("Notice: An error occured while initializing Lazyload (" + err + "), Falling back to easylazy instead.");
                $(container + " .lazyload").each(function() {
                    if ($(this).is("img") || $(this).is("iframe")) {
                        $(this).attr("src", $(this).attr("data-original"));
                    } else {
                        $(this).css("background-image", "url('" + $(this).attr("data-original") + "')");
                    }
                    $(this).removeClass("lazyload");
                });
            }
        }
        if ($(container + " .easylazy").length) {
            setTimeout(function() {
                $(container + " .easylazy").each(function() {
                    if ($(this).is("img") || $(this).is("iframe")) {
                        $(this).attr("src", $(this).attr("data-src"));
                    } else {
                        $(this).css("background-image", "url('" + $(this).attr("data-src") + "')");
                    }
                });
            }, 2100);
        }
    };


    $(document).ready(function($) {
        // Initialize LazyLoad on images, iframes, etc...
        initLazyloadAndEasyload();
    });

    return;
});