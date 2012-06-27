<?php
/**
 * User settings for the CBase theme.
 */
function cbase_form_system_theme_settings_alter(&$form, &$form_state) {
  $themes = list_themes();

  // Render the Theme Settings page header.  We can't use a theme function or
  // template here because the cbase theme is not loaded into the registry if
  // we are using a separate administration theme.
  $form['screenshot'] = array(
    '#type' => 'markup',
    '#markup' => cbase_theme_settings_header($form_state['build_info']['args'][0], $themes),
    '#weight' => -999,
  );

  // Define a vertical tabs items
  $form['tabs'] = array(

  );

  // Configure Stylesheets
  $form['style'] = array(
    '#type' => 'fieldset',
    '#title' => t('Stylesheets'),
    '#collapsible' => TRUE,
  );
  $form['style']['cbase_css'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use CBase Reset Stylesheet'),
    '#default_value' => theme_get_setting('cbase_css'),
  );

  // Configure UI enhancements
  $form['ui'] = array(
    '#type' => 'fieldset',
    '#title' => t('User Interface'),
    '#collapsible' => TRUE,
  );
  $form['ui']['cbase_localscroll'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Smooth Scroll for Anchors'),
    '#description' => t('Page reference links, such as \'Back to Top\' links, will scroll instead of jump to position.'),
    '#default_value' => theme_get_setting('cbase_localscroll'),
  );

  // Adjust labels
  $form['theme_settings']['#title'] = t('Features');
  $form['favicon']['#title']        = t('Shortcut Icon (Favicon)');

  // Weight fieldsets
  $form['style']['#weight']          = 0;
  $form['ui']['#weight']             = 5;
  $form['favicon']['#weight']        = 10;
  $form['theme_settings']['#weight'] = 15;

  // Tweak a few settings to accomodate vertical tabs.
  $form['logo']['#attributes']['class'] = array();

  // Put fieldsets into vertical tabs
  $form['tabs'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => -99,
  );
  foreach (element_children($form) as $child) {
    if ($form[$child]['#type'] == 'fieldset') {
      $form[$child]['#group'] = 'tabs';
      $form['tabs'][$child] = $form[$child];
      unset($form[$child]);
    }
  }
}

/**
 * Theme the header.
 *
 * @param $themename
 *   The current theme machine name.
 * @param $themes
 *   An array of objects representing theme data.
 *
 * @return
 *   A themed header block.
 */
function cbase_theme_settings_header($themename, $themes) {
  // Get the current theme's data
  $theme = $themes[$themename];
  $info  = $theme->info;
  drupal_set_title(t('!name Settings', array('!name' => $info['name'])));

  // Derrive the lineage
  $lineage[$theme->name] = $info['name'];
  $next_theme = $themes[$themename];
  while (isset($next_theme->base_theme) && !empty($next_theme->base_theme)) {
    $lineage[$themes[$next_theme->base_theme]->name] = l($themes[$next_theme->base_theme]->info['name'], 'admin/appearance/settings/' . $themes[$next_theme->base_theme]->name);
    $next_theme = $themes[$next_theme->base_theme];
  }

  // Create the screenshot
  // Look for a screenshot in the current theme or in its closest ancestor.
  $sc = '';
  foreach (array_keys(array_reverse($lineage)) as $theme_key) {
    if (isset($themes[$theme_key]) && file_exists($themes[$theme_key]->info['screenshot'])) {
      $sc = array(
        'path' => $themes[$theme_key]->info['screenshot'],
        'alt' => t('Screenshot for !theme theme', array('!theme' => $info['name'])),
        'title' => t('Screenshot for !theme theme', array('!theme' => $info['name'])),
        'attributes' => array('class' => array('screenshot')),
      );
      break;
    }
  }
  $screenshot = ($sc ? '  <div style="float: left; margin-right: 1em;" id="screenshot">' . theme('image', $sc) . '</div>' : '');

  // Create the markup
  $out  = '';
  $out .= '<div id="theme-settings-header">';
  $out .= $screenshot;
  $out .= '  <h2 id="title">' . t('!name Settings', array('!name' => $info['name'])) . '</h2>';
  $out .= '  <div id="lineage"><strong>' . t('Lineage') . ':</strong> '. implode("&nbsp;&raquo;&nbsp;", array_reverse($lineage)) . "</div>";
  $out .= '  <div class="clearfix"></div>';
  $out .= '</div>';

  return $out;
}
