<?php
/*******************************************************************************
 * Copy both of these functions into your subtheme's template.php file and
 * replace cbase with your theme's name.
 ******************************************************************************/
/**
 * Implementation of template_preprocess().
 */
function cbase_preprocess(&$vars, $hook) {
  // Add some preprocess suggestions


  _process_variables($vars, $hook, 'cbase', 'preprocessors');
}

/**
 * Implementation of template_process().
 */
function cbase_process(&$vars, $hook) {
  _process_variables($vars, $hook, 'cbase', 'processors');
}
/******************************************************************************/

/**
 * Helper function to process variables for the preprocessor and processor hooks.
 *
 * Maintains separate directories in the theme folder called 'preprocessors'
 * and 'processors' where all preprocess logic is stored.  Each hook called
 * corresponds to a file of the same name.
 *
 * @param &$vars
 *   The $variables array passed into the processing hooks.
 * @param $hook
 *   The processing hook.
 * @param $theme
 *   The name of the theme calling the processors.
 * @param $directory
 *   The directory in which to scan for processor files.
 */
function _process_variables(&$vars, $hook, $theme, $directory = 'preprocessors') {
  $_vars['pp'] = array();

  // Define theme paths for all themes in the family.
  $vars['theme_paths'] = cbase_get_family_info('path');

  /**
   * Build a list of processing files to search for.
   */
  // Define the standard preprocessor hook.
  $_vars['pp'][] = $hook;

  // Merge template suggestions with the standard hook preprocessor file suggestion.
  if (is_array($vars['theme_hook_suggestions'])) {
    $_vars['pp'] = array_merge($_vars['pp'], $vars['theme_hook_suggestions']);
  }

  // Candidate preprocessors
  //dpm($_vars['pp'], $hook);

  // Load any available preprocessors
  foreach ($_vars['pp'] as $file) {
    $_vars['filepath'] = $vars['theme_paths'][$theme] . "/$directory/$file" . '.inc';
    if (file_exists($_vars['filepath'])) {
      include($_vars['filepath']);
    }
  }
}

/**
 * Implements hook_form_alter().
 */
function cbase_form_alter(&$form, &$form_state, $form_id) {
	// Add a Cancel link for node submission forms
	if ($form['#id'] == 'node-form') {
		$form['buttons']['cancel'] = array(
			'#type' => 'markup',
			'#value' => l(t('Cancel'), $_SERVER['HTTP_REFERER']),
			'#weight' => 99,
		);
	}
}

/**
 * Implements hook_theme().
 */
function cbase_theme($existing, $type, $theme, $path) {
  return array(
    'unpublished_indicator' => array(
      'variables' => array('position' => 'side-left'),
    ),
    'view_results_count' => array(
      'variables' => array('view' => NULL),
    ),
  );
}

/*******************************************************************************
 * THEME OVERRIDES
 ******************************************************************************/
/**
 * Theme messages.
 */
function cbase_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages $type\">\n";
    $output .= '  <div class="inner">';
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) >= 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n</div>\n";
  }
  return $output;
}

/*******************************************************************************
 * CUSTOM THEMES
 ******************************************************************************/
/**
 * Theme a custom unpublished indicator.
 */
function cbase_unpublished_indicator($vars) {
  return '<div class="unpublished-indicator ' . $vars['position'] . '">&nbsp;</div>';
}

/**
 * Theme the result count for a view.
 */
function cbase_view_results_count($variables) {
  $view = $variables['view'];

  $z = $view->total_rows;
  $x = $view->query->offset + 1;
  $y = min($x + $view->query->limit - 1, $z);
  return ($view->query->limit == 0 ? "Showing all $z results." : "Showing results $x - $y of $z");
}

/*******************************************************************************
 * THEME FUNCTIONS
 ******************************************************************************/
/**
 * Get ancestral data from info files in the entire family of themes stemming
 * from the active theme.
 *
 * @param $key
 *   The .info values to return.
 *
 * @return array()
 *   All $key values from all .info files in the ancestry, ordered oldest to
 *   newest.  Full info data if $key is NULL.
 */
function cbase_get_family_info($key = NULL) {
  global $theme;
  $data = &drupal_static(__FUNCTION__);

  // Check for cached data
  if (!isset($data[$key])) {
    $all_themes = list_themes();

    // Build an array of base-theme ancestry
    $theme_ancestry[0] = $theme;
    $next_theme = $all_themes[$theme];
    while (isset($next_theme->base_theme) && !empty($next_theme->base_theme)) {
      $theme_ancestry[] = $next_theme->base_theme;
      $next_theme = $all_themes[$next_theme->base_theme];
    }

    // Invert the array so the oldest theme (root theme) is first and the
    // current default theme is last.
    $theme_ancestry = array_reverse($theme_ancestry);

    // These keys are exclusive to each theme.  The value of the parent theme is
    // irrevelent to the child theme, and so they must be explicitly defined in
    // each child theme.
    $overrides = array('regions', 'features', 'overlay_regions', 'regions_hidden');

    // If the key is an overridden value, we don't need to combine all ancestral
    // values, just return the active theme's value.
    $info = array();
    if (in_array($key, $overrides)) {
      $info[$key] = $all_themes[$theme]->$key;
    }
    else {
      foreach ($theme_ancestry as $_theme) {
        if (!$key) {
          $info[$_theme] = $all_themes[$_theme]->info;
        }
        elseif ($key == 'path') {
          $info[$_theme] = drupal_get_path('theme', $_theme);
        }
        else {
          if (isset($all_themes[$_theme]->info[$key]) && is_array($all_themes[$_theme]->info[$key])) {
            $info[$_theme] = $all_themes[$_theme]->info[$key];
          }
          elseif (isset($all_themes[$_theme]->info[$key]) && !is_array($all_themes[$_theme]->info[$key])) {
            $info[$_theme] = $all_themes[$_theme]->info[$key];
          }
        }
      }
    }

    $data[$key] = $info;
  }

  return $data[$key];
}

/**
 * Create an element for an empty region.
 *
 * @param $page
 *   The page array containing the region data.
 * @param $region
 *   The region to initialize.
 */
function cbase_init_region(&$page, $region) {
  if (!isset($page[$region]) || empty($page[$region])) {
    $page[$region]['#theme_wrappers'][] = 'region';
    $page[$region]['#region'] = $region;
  }

  if (module_exists($context)) {
    if ($plugin = context_get_plugin('reaction', 'region')) {
      $plugin->execute($page);
    }
  }
}

/**
 * Filter out and translate bad characters from the title tag.
 *
 * @param $string
 *   The raw title string.
 *
 * @return
 *   Clean, compliant and valid title string.
 */
function cbase_title_filter($string) {
  // Strip off any HTML elements that may have snuck in.
  $string = strip_tags($string);

  // List items to be translated in order that they should be replaced.
  $translate = array(
    '&amp;'   => 'and',
    '&nbsp;'  => ' ',
    '&ndash;' => '-',
    '&mdash;' => '-',
    '&#039;'  => "'",
    '&'       => 'and',
  );

  // Run the replacements
  foreach ($translate as $from => $to) {
    $string = str_replace($from, $to, $string);
  }

  return $string;
}
