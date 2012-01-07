<?php
/*******************************************************************************
 * CORE HOOKS
 ******************************************************************************/
/**
 * Implementation of template_preprocess().
 *
 * Maintains a separate directory in the theme folder called 'preprocessors'
 * where all preprocess logic is stored.  Each hook called corresponds to a
 * file of the same name.
 */
function cbase_preprocess(&$vars, $hook) {
  // Get a list of all theme paths in the current theme ancestry.
  $theme_paths = eeretheme_get_ancestral_info('path');

  // Define directories for preprocessors to include EERETHEME and a subtheme
  // if set.  This way the subtheme doesn't need to implement it's own preprocess
  // hook like this one.
  $dirs = array();
  foreach ($theme_paths as $path) {
    $dirs[] = "$path/preprocessors/";
  }

  // Define the standard preprocessor hook.
  $preprocessors = array($hook);

  // Merge template suggestions with the standard hook preprocessor file suggestion.
  if (is_array($vars['theme_hook_suggestions'])) {
    $preprocessors = array_merge($preprocessors, $vars['theme_hook_suggestions']);
  }

  // Load any available preprocessors
  foreach ($preprocessors as $file) {
    foreach ($dirs as $dir) {
      $filepath = $dir . $file . '.inc';
      if (file_exists($filepath)) {
        include($filepath);
      }
    }
  }
}

/**
 * Implements hook_theme().
 */
function cbase_theme($existing, $type, $theme, $path) {
  return array(
    'view_results_count' => array(
      'variables' => array('view' => NULL),
    ),
  );
}

/*******************************************************************************
 * CUSTOM THEMES
 ******************************************************************************/
/**
 * Theme the result count for a view.
 */
function theme_view_results_count($variables) {
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
function cbase_get_ancestral_info($key = NULL) {
  global $theme;

  $all_themes = list_themes();
  $base_themes = array_keys((isset($all_themes[$theme]->base_themes) ? $all_themes[$theme]->base_themes : (isset($all_themes[$theme]->base_theme) ? array($all_themes[$theme]->base_theme => 0) : array())));
  $theme_ancestry = array_merge($base_themes, array($theme));
  $info = array();

  // These keys are exclusive to each theme.  The value of the parent theme is
  // irrevelent to the child theme, and so they must be explicitly defined in
  // each child theme.
  $overrides = array('regions', 'features', 'overlay_regions', 'regions_hidden');

  // If the key is an overridden value, we don't need to combine all ancestral
  // values, just return the active theme's value.
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

  return $info;
}
