<?php
/**
 * @file
 * Preprocessor for all panels panes.
 */
/**
 * Add theme hook suggestions for the panel pane for the region and the layout.
 */
$type   = $vars['pane']->type;
$panel  = $vars['pane']->panel;
$layout = $vars['display']->layout;

/**
 * Not sure why the first two items don't make it on the final list, but their
 * existence seems to allow the other ones to remain, thus we add them twice
 * in order for them to be included in the final list.
 */ 
$vars['theme_hook_suggestions'] += array(
  "panels_pane__{$layout}__{$type}",
  "panels_pane__{$layout}__{$panel}__{$type}",
  "panels_pane__{$layout}",
  "panels_pane__{$panel}",
  "panels_pane__{$layout}__{$panel}",
  "panels_pane__{$panel}__{$type}",
  "panels_pane__{$layout}__{$type}",
  "panels_pane__{$layout}__{$panel}__{$type}",
);
