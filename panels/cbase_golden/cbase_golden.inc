<?php

// Plugin definition
$plugin = array(
  'title'    => t('Two Column Golden'),
  'description' => t('Two column layout proportioned to the golden ration.  Main column may be configured left or right.'),
  'category' => t('cBase'),
  'icon'     => 'cbase_golden.png',
  'theme'    => 'cbase_panel_golden',
  'template' => 'panel_cbase',
  'css'      => 'cbase_golden.css',
  'admin css' => 'cbase_golden_admin.css',
  'settings form' => 'cbase_golden_settings_form',
  'regions'  => array(
    'top'      => t('Top'),
    'first'    => t('First'),
    'second'   => t('Second'),
    'bottom'   => t('Bottom')
  ),
);

/**
 * Add settings to the layout.
 */
function cbase_golden_settings_form($display, $plugin) {
  $form['golden_main_position'] = array(
    '#type' => 'select',
    '#title' => 'Main Position',
    '#options' => array(
      'left' => t('Left'),
      'right' => t('Right'),
    ),
    '#default_value' => (isset($display->layout_settings['golden_main_position']) ? $display->layout_settings['golden_main_position'] : 'left'),
  );

  return $form;
}
