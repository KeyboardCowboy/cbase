<?php
/**
 * User settings for the CBase theme.
 */
function cbase_form_system_theme_settings_alter(&$form, &$form_state) {
  $form['cbase'] = array(
    '#type' => 'fieldset',
    '#title' => t('CBase Settings'),
    '#collapsible' => TRUE,
  );
  $form['cbase']['cbase_css'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use CBase Reset Stylesheet'),
    '#default_value' => theme_get_setting('cbase_css'),
  );
}
