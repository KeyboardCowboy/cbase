<?php
/**
 * Set default values for cbase panels layouts.
 */
$element['main'] = (!empty($element['main']) ? $element['main'] : 'div');
$element['content'] = (!empty($element['content']) ? $element['content'] : 'div');
$panel_attributes = (!empty($panel_attributes) ? (array) $panel_attributes : array());
$messages = (isset($messages) ? $messages : '');
