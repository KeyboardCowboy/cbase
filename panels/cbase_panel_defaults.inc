<?php
/**
 * Set default values for cbase panels layouts.
 */
if ($renderer->admin) {
  $messages = (isset($messages) ? $messages : '');

  switch ($layout['name']) {
    case 'cbase_golden':
      $element = array(
        'main' => 'div',
        'content' => 'div',
      );
      $panel_attributes = array('class' => array('cbase-panel-golden', isset($settings['golden_main_position']) ? $settings['golden_main_position'] : 'left'));
      break;
  }
}
//dpm(get_defined_vars());
