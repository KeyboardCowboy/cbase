<?php
/**
 * @file
 * Process the data for the views results counter theme.
 */
$view = $vars['view'];

$z = $view->total_rows;
$x = $view->query->offset + 1;
$y = min($x + $view->query->limit - 1, $z);

$vars['first'] = $x;
$vars['last']  = $y;
$vars['total'] = $z;
$vars['limit'] = $view->query->limit;
