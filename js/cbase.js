/**
 * @file
 * A Collection of common theming tools.
 */
(function ($) {
  $.fn.matchHeight = function() {
    var e = $(this);

    // If there are 1 or less elements, kick out.
    if (e.length <= 1) {
      return;
    }

    // Find the height of the tallest element.
    var height = 0;
    e.each(function(i) {
      height = Math.max(height, $(this).height());
    });

    // Set the heights.
    e.height(height);
  };
})(jQuery);
