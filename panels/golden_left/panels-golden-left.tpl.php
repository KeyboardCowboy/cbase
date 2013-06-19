<?php
/**
 * @file
 * 2-Column golden ratio with the content on the left.
 *
 * This layout should be used for composite/landing pages.
 */
?>
<div <?php //print drupal_attributes($panel_attributes); ?>>
  <?php if ($content['top']) : ?>
    <div><?php print $content['top']; ?></div>
  <?php endif; ?>

  <?php if ($content['left']) : ?>
    <section><?php print $content['left']; ?></section>
  <?php endif; ?>

  <?php if ($content['right']) : ?>
    <aside><?php print $content['right']; ?></aside>
  <?php endif; ?>

  <?php if ($content['bottom']) : ?>
    <aside><?php print $content['bottom']; ?></aside>
  <?php endif; ?>
</div>
