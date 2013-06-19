<?php

// Plugin definition
$plugin = array(
  'title' => t('Golden Left'),
  'category' => t('cBase'),
  'icon' => 'golden_left.png',
  'theme' => 'panels_golden_left',
  'page' => 'page__cbase_panel',
  'css' => 'golden_left.css',
  'regions' => array(
    'top' => t('Top'),
    'left' => t('Left side'),
    'right' => t('Right side'),
    'bottom' => t('Bottom')
  ),
);
