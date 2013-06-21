<?php
/**
 * @file
 * Panel-less page.
 */
?>
<div id="page">
  <header id="header" role="banner">
    <?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
    <?php endif; ?>

    <?php if ($site_name || $site_slogan): ?>
      <?php if ($site_name): ?>
        <h1 id="site-name">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
        </h1>
      <?php endif; ?>

      <?php if ($site_slogan): ?>
        <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
      <?php endif; ?>
    <?php endif; ?>

    <?php print render($page['header']); ?>
  </header>

  <?php print render($page['content']); ?>

  <?php print render($page['footer']); ?>
</div>

<?php print render($page['bottom']); ?>
