<?php

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('One Column w/sidebar'),
  'category' => t('Columns: 1'),
  'icon' => 'onecol-sidebar.png',
  'theme' => 'panels_onecol_sidebar',
  'css' => 'onecol-sidebar.css',
  'regions' => array(
    'sidebar' => t('Sidebar'),
    'main' => t('Main'),
  ),
);
