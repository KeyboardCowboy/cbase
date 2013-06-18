<?php
/**
 * @file
 * Preprocessor for all regions.
 */
/**
 * Trim down the attributes.
 */
$vars['region_attributes'] = array(
  'id' => strtr($vars['region'], '_', '-'),
  //'class' => array(),
) + $vars['attributes_array'];
