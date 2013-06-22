<?php
/**
 * Preprocessor for all cBase panels layouts.
 */
// Load the messages.
$vars['messages'] = theme('status_messages');
$vars['tabs'] = menu_local_tabs();
$vars['action_links'] = menu_local_actions();

// Define attributes for the panel wrapper element.
$vars['panel_attributes'] = array(
  'class' => $vars['classes_array'],
);

// Add the ID
if (isset($vars['css_id'])) {
  $vars['panel_attributes']['id'] = $vars['css_id'];
}

// Check for the golden content position.
if (isset($vars['settings']['golden_main_position'])) {
  $vars['panel_attributes']['class'][] = $vars['settings']['golden_main_position'];
}

// Set the appropriate elements based on whether this is a node rendering or not.
if ($node = menu_get_object()) {
  $vars['node'] = $node;
  $vars['element'] = array(
    'main' => 'section',
    'content' => 'article',
  );
}
else {
  $vars['element'] = array(
    'main' => 'div',
    'content' => 'section',
  );
}
