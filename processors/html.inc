<?php
/**
 * HTML processor for CBase.
 */
/**
 * Adjust the stylesheets according to the theme settings selected.
 */
$css = theme_get_setting('cbase_css');
$system_path = drupal_get_path('module', 'system');
if (is_array($css)) {
  foreach ($css as $sheet => $enabled) {
    $csspath = '';
    if (stripos($sheet, 'cbase') === 0) {
      $csspath = $vars['theme_paths']['cbase'] . "/css/{$sheet}";
    }
    elseif (stripos($sheet, 'system') === 0) {
      $csspath = "$system_path/$sheet";
    }

    if (!$enabled && $csspath && isset($vars['css'][$csspath])) {
      unset($vars['css'][$csspath]);
    }
  }

  $vars['styles'] = drupal_get_css($vars['css']);
}
