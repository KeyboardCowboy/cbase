<?php
/**
 * @file
 * Global preprocessor for nodes.
 */
/**
 * Append an extra node-unpublished indicator.
 */
$type = theme_get_setting('cbase_unpublished_indicator');
if (!$vars['status'] && $type) {
  $vars['classes_array'][] = 'cbase-unpublished';
  $vars['content']['unpublished_indicator'] = array(
    '#theme' => 'unpublished_indicator',
    '#position' => $type,
  );
}
