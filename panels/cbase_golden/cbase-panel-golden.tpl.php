<?php
/**
 * @file
 * 2-Column golden ratio with configurable main column.
 */
  // Load defaults variables. (Mainly for D&D admin)
  include(__DIR__ . '/../cbase_panel_defaults.inc');
?>
<<?php print $element['main']; ?> <?php print drupal_attributes((array) $panel_attributes); ?>>
  <?php print $messages; ?>
  <?php print (!$renderer->admin ? render($tabs) : ''); ?>

  <?php if ($content['top']) : ?>
    <header><?php print $content['top']; ?></header>
  <?php endif; ?>

  <<?php print $element['content']; ?> class="columns" role="main">
    <?php if ($content['first']) : ?>
      <div class="col-1"><?php print $content['first']; ?></div>
    <?php endif; ?>

    <?php if ($content['second']) : ?>
      <aside class="col-2"><?php print $content['second']; ?></aside>
    <?php endif; ?>
  </<?php print $element['content']; ?>>

  <?php if ($content['bottom']) : ?>
    <footer><?php print $content['bottom']; ?></footer>
  <?php endif; ?>
</<?php print $element['main']; ?>>
