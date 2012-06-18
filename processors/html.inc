<?php
/**
 * HTML processor for CBase.
 */
/**
 * Remove the cbase stylesheet.
 */
if (theme_get_setting('cbase_css') == 0) {
  $cbase_css = $vars['theme_paths']['cbase'] . '/css/cbase.css';
  if (isset($vars['css'][$cbase_css])) {
    unset($vars['css'][$cbase_css]);
  }
  $vars['styles'] = drupal_get_css($vars['css']);
}
