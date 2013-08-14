<?php
/**
 * Process variables for the html.tpl.php template.
 */
/**
 * Load any conditional stylesheets.
 */
$condsheets = cbase_get_family_info('conditional_stylesheets');
$weight = 900;
foreach ($condsheets as $themename => $theme_conditions) {
  foreach ($theme_conditions as $condition => $files) {
    foreach ($files as $file) {
      drupal_add_css(drupal_get_path('theme', $themename) . "/$file", array('group' => CSS_THEME, 'weight' => ++$weight, 'browsers' => array('IE' => $condition, '!IE' => FALSE), 'preprocess' => FALSE));
    }
  }
}

/**
 * Implement desired JS addons.
 */
$localscroll = theme_get_setting('cbase_localscroll');
$stickyfooter = theme_get_setting('cbase_sticky_footer');
if ($localscroll || $stickyfooter) {
  $js = "
  (function ($) {
    $(document).ready(function() {";

    // Prep localscroll
    if ($localscroll) {
      drupal_add_js($vars['theme_paths']['cbase'] . '/js/scrollTo-1.4.2.js');
      drupal_add_js($vars['theme_paths']['cbase'] . '/js/localscroll-1.2.7.js');
      $js .= "
        // Implement localscroll.
        $.localScroll({duration: 500});
      ";
    }

    // Prep Sticky Footer
    if ($stickyfooter) {
      drupal_add_js($vars['theme_paths']['cbase'] . '/js/sticky-footer.js');
      $js .= "
        // Implement localscroll.
        $('" . $stickyfooter . "').stickyFooter();
      ";
    }

  $js .= "  });
  })(jQuery);
  ";
  drupal_add_js($js, 'inline');
}

/**
 * Add the bootstrap CDN for fontawesome
 */
if (theme_get_setting('cbase_fontawesome')) {
  $element = array(
    '#type' => 'html_tag',
    '#tag' => 'link',
    '#attributes' => array(
      'href' => "//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css",
      'rel' => "stylesheet",
    ),
  );
  drupal_add_html_head($element, 'cbase_fontawesome');
}

/**
 * Clean out body attributes.
 */
$vars['body_attributes'] = array(
  //'class' => array(),
) + $vars['attributes_array'];
