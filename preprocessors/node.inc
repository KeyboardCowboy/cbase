<?php
/**
 * @file
 * Global preprocessor for nodes.
 */
/**
 * Append an extra node-unpublished indicator.
 */
if (!$vars['status']) {
  $vars['content']['body'][0]['#markup'] .= '<div class="unpublished-indicator">&nbsp;</div>';
}
