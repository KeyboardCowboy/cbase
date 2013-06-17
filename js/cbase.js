/**
 * @file
 * A Collection of common theming tools.
 */
(function ($) {
  /**
   * Global modifiers loaded into Drupal's behaviors.  They will be loaded into
   * every page context.
   */
  Drupal.behaviors.cBase = {
    // DOM Elements
    e: {},

    attach: function() {
      this.adjustAdminMenus();
    },

    /**
     * Push the Admin sidebar below the Admin Menu.
     */
    adjustAdminMenus: function() {
      var self = this;
      this.e.adminSidebar = $("#admin-toolbar .admin-blocks, #admin-toolbar .admin-toggle", context);
      this.e.adminMenu = $("#admin-menu", context);

      if (this.e.adminSidebar.length > 0) {
        // If the admin menu is to be rendered on this page, listen for it to be
        // added then adjust the sidebar.
        if (Drupal.settings.admin_menu) {
          toplisten = setInterval(function() {
            // If the menu has loaded, slide the sidebar and stop the itterations.
            if (self.e.adminMenu.length > 0) {
              self.e.adminSidebar.animate({'top': self.e.adminMenu.inScrollView('top')});
              clearInterval(toplisten);
            }
          }, 250);
        }

        $(window).scroll(function() {
          if (self.e.adminMenu.length > 0) {
            self.e.adminSidebar.css({'top': self.e.adminMenu.inScrollView('top')});
          }
        });
      }
    },
  };

  /**
   * Create a fade-in/fade-out dialog box to display messages.
   *
   * Dependencies:
   *   - isset();
   */
  cBaseDialog = {
    e: $('<aside></aside>', {'id': 'cbase-dialog'}),
    spinner: $('<span>Working...</span>'),
    spinner_fa: $('<i></i>', {'class': 'icon-spinner icon-spin icon-2x'}),

    // Initialize the dialog.
    init: function() {
      this.e.appendTo('body');

      // Preload the spinner to prevent rendering delay.
      this.spinner_fa.appendTo('body').addClass('element-invisible');
    },

    // Display (and optionally hide) the dialog.
    show: function(content, delay) {
      // Set the dialog contents.
      this.e.html(content);

      // Position the dialog in the center of the viewport.
      var y = ($(window).height() / 2) - (this.e.height() / 2);
      var x = ($(window).width() / 2) - (this.e.width() / 2);
      this.e.css({'top': y, 'left': x});

      // Show the dialog
      this.e.fadeIn('fast');

      // If a delay was provided, hide the dialog after the delay.
      if (isset(delay)) {
        this.hide(delay);
      }
    },

    // Hide the dialog.
    hide: function(delay) {
      delay = delay || 0;
      this.e.delay(delay).fadeOut('slow');
    },

    // Show the working image (font-awesome version).
    working: function(delay) {
      this.show(this.spinner_fa, delay);
    }
  };

  /**
   * Generic inline utility functions.
   * These do not be instatiated on page load.
   */
  cBaseUtil = {};

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
  };

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
      height = Math.max(height, $(this).outerHeight(true));
    });

    // Set the height for each element taking into account border, padding and
    // margins set for each.
    e.each(function(i) {
      var diff = $(this).outerHeight(true) - $(this).height();
      $(this).css({'min-height': height - diff + 'px'});
    });
  };

  /**
   * Shorthand function to set element positioning.
   */
  $.fn.setPos = function(t,r,b,l) {
    var pos = {};
    var css = {};

    pos.top    = t != 'undefined' ? t : null;
    pos.right  = r != 'undefined' ? r : null;
    pos.bottom = b != 'undefined' ? b : null;
    pos.left   = l != 'undefined' ? l : null;

    for (var i in pos) {
      if (pos[i] != null) {
        css[i] = pos[i];
      }
    }

    $(this).css(css);
  };

  /**
   * Return the value of a URL query parameter.
   */
  function getQueryParam(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
    var results = regex.exec(location.search);
    return results == null ? null : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  /**
   * Shorthand function to mimic PHP's isset() function.
   */
  function isset(v) {
    return (typeof v != 'undefined');
  }
})(jQuery);
