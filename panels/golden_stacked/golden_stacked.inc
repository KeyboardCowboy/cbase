<?php

// Plugin definition
$plugin = array(
  'title' => t('Golden stacked'),
  'category' => t('Columns: 2'),
  'icon' => 'golden_stacked.png',
  'theme' => 'panels_golden_stacked',
  'css' => 'golden_stacked.css',
  'regions' => array(
    'top' => t('Top'),
    'left' => t('Left side'),
    'right' => t('Right side'),
    'bottom' => t('Bottom')
  ),
);
