<?php
/**
 * Get the Main and Secondary Menus will full tree structure, keeping intact the
 * instance where, if both menus are set the same then the Main menu is one level
 * and the active item's children become the secondary menu.
 */
$main_menu_name = variable_get('menu_main_links_source', 'main-menu');
$sec_menu_name  = variable_get('menu_secondary_links_source', 'main-menu');
$vars['secondary_menu'] = array();

// If the main and secondary links are generated from the same menu, get the
// active menu item and the data for the common menu.
if ($main_menu_name == $sec_menu_name) {
  $active_item = menu_get_item();

  // Load the menu up to 4 levels (1 for primary, 3 in the secondary)
  $sec_menu = menu_tree_page_data($sec_menu_name, 4);

  // Scan through the top level items in the main menu until we find one whose
  // href is in the active trail.  Then, if that item has items in its 'below'
  // array, assign those items as the secondary menu.
  foreach ($sec_menu as $item) {
    if ((($item['link']['href'] == $active_item['href']) || $item['link']['in_active_trail']) && !empty($item['below'])) {
      $vars['secondary_menu'] = menu_tree_output($item['below']);
      break;
    }
  }
}
// If the source menus are different, simply load the menu tree as the
// secondary menu element.
else {
  //$vars['secondary_menu'] = menu_tree_output(menu_build_tree($sec_menu_name, array('min_depth' => 1, 'max_depth' => 3)));
  $vars['secondary_menu'] = menu_tree_output(menu_tree_page_data($sec_menu_name, 3));
}

// Apply theming to the secondary menu
/*if (!empty($vars['secondary_menu'])) {
  $vars['secondary_menu']['#attributes']['id'][] = 'leftnav';
  $vars['secondary_menu']['#theme_wrappers'] = array('secondary_menu_tree');
}*/

