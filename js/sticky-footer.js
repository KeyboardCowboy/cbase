/**
 * Keep the footer stuck to the bottom of the page if the content is too short.
 *
 * Borrowed from Chris Coyer
 * http://css-tricks.com/snippets/jquery/jquery-sticky-footer
 */
(function ($) {
  $(document).ready(function() {
    // Window load event used just in case window height is dependant upon images
    $(window).bind("load", function() {
      var footerHeight = 0,
          $footer = $("footer#site-footer");

      positionFooter();

      function positionFooter() {
        footerHeight = $footer.height();

        if (($(document.body).height() + footerHeight) < $(window).height()) {
          $footer.addClass('fixed');
        }
        else {
          $footer.removeClass('fixed');
        }
      }

      $(window).scroll(positionFooter).resize(positionFooter);
    });
  });
})(jQuery);
