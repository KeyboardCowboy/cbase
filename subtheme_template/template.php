<?php
/**
 * @file
 * Template functionality for SUBTHEME.
 */
/**
 * Delegate processor and preprocessors to include files.
 */
function SUBTHEME_preprocess(&$vars, $hook) {
  // Add SUBTHEME global variables here.
  // $vars['var'] = 'value';
  _process_variables($vars, $hook, 'SUBTHEME', 'preprocessors');
}
function SUBTHEME_process(&$vars, $hook) {
  // Add SUBTHEME global variables here.
  // $vars['var'] = 'value';
  _process_variables($vars, $hook, 'SUBTHEME', 'processors');
}
