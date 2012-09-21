/**
 * @file
 * A Collection of common theming tools.
 */
(function ($) {
  $(document).ready(function() {
    // Keep the admin toolbar below the admin menu.
    cbase_adjust_admin_tools();
  });

  /**
   * Determine whether a given element is currently in the scrolled view.
   *
   * @param p [top | bottom]
   *   Position to check for.
   *   If set, return the difference between the outer edge of the element and
   *     the respective position (top or bottom).
   *   If not set, return boolen as to whether the element is anywhere in the
   *     visible doc view.
   */
  $.fn.inScrollView = function(p) {
    var e = $(this);
    var dT = $(window).scrollTop();
    var dB = dT + $(window).height();
    var eT = e.offset().top;
    var eB = eT + e.height();

    if (p && p == 'top') {
      return Math.max(0, (eB - dT));
    }

    if (p && p == 'bottom') {
      return Math.max(0, (dB - eT));
    }

    return ((eB <= dB) && (dB - eB));
  }

  /**
   * Set all elements in the range to the same height.
   */
  $.fn.matchHeight = function() {
    var e = $(this);

    // If there are 1 or less elements, kick out.
    if (e.length <= 1) {
      return;
    }

    // Find the height of the tallest element.
    var height = 0;
    e.each(function(i) {
      height = Math.max(height, $(this).outerHeight());
    });

    // Set the heights.
    e.height(height);
  };

  /**
   * Push the Admin sidebar below the Admin Menu.
   */
  function cbase_adjust_admin_tools() {
    var side = $("#admin-toolbar .admin-blocks, #admin-toolbar .admin-toggle");

    if (side.length > 0) {
      // If the admin menu is to be rendered on this page, listen for it to be
      // added then adjust the sidebar.
      if (Drupal.settings.admin_menu) {
        toplisten = setInterval(function() {
          var menu = $("#admin-menu");

          // If the menu has loaded, slide the sidebar and stop the itterations.
          if (menu.length > 0) {
            side.animate({'top': menu.inScrollView('top')});
            clearInterval(toplisten);
          }
        }, 250);
      }

      $(window).scroll(function() {
        var menu = $("#admin-menu");
        if (menu.length > 0) {
          side.css({'top': menu.inScrollView('top')});
        }
      });
    }
  }
})(jQuery);
