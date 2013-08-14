/**
 * Keep the footer stuck to the bottom of the page if the content is too short.
 *
 * Borrowed from Chris Coyer
 * http://css-tricks.com/snippets/jquery/jquery-sticky-footer
 */
(function ($) {
  $.fn.stickyFooter = function() {
    var f = $(this);

    // Window load event used just in case window height is dependant upon images
    $(window).bind("load", function() {
      var fh = 0;

      // Instantiate
      positionFooter();

      /**
       * Check the position of the footer
       */
      function positionFooter() {
        fh = f.height();

        if (($(document.body).height() + fh) < $(window).height()) {
          f.addClass('fixed-bottom');
        }
        else {
          f.removeClass('fixed-bottom');
        }
      }

      $(window).scroll(positionFooter).resize(positionFooter);
    });
  };
})(jQuery);
