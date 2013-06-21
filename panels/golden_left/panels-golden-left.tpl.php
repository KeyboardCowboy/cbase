<?php
/**
 * @file
 * 2-Column golden ratio with the content on the left.
 *
 * This layout should be used for composite/landing pages.
 */
  // Load defaults
  include(__DIR__ . '/../cbase_panel_defaults.inc');
?>
<<?php print $element['main']; ?> <?php print drupal_attributes((array) $panel_attributes); ?>>
  <?php print $messages; ?>
  <?php print render($tabs); ?>

  <?php if ($content['top']) : ?>
    <div><?php print $content['top']; ?></div>
  <?php endif; ?>

  <<?php print $element['content']; ?> role="main">
    <?php if ($content['left']) : ?>
      <div><?php print $content['left']; ?></div>
    <?php endif; ?>

    <?php if ($content['right']) : ?>
      <aside><?php print $content['right']; ?></aside>
    <?php endif; ?>
  </<?php print $element['content']; ?>>

  <?php if ($content['bottom']) : ?>
    <div><?php print $content['bottom']; ?></div>
  <?php endif; ?>
</<?php print $element['main']; ?>>
