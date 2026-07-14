<?php if (!defined('ABSPATH')) { exit; } ?><!doctype html>
<html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<header class="site-header"><div class="container nav-wrap">
  <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> home">
    <?php if (has_custom_logo()) { the_custom_logo(); } else { ?><span class="brand-mark">SM</span><?php } ?><span>Shakeel <strong>Mureed</strong></span>
  </a>
  <button class="menu-button" type="button" aria-expanded="false" aria-controls="main-nav" aria-label="<?php esc_attr_e('Toggle navigation', 'shakeel-portfolio'); ?>"><i></i><i></i><i></i></button>
  <?php wp_nav_menu(['theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav', 'container_class' => 'nav-links', 'fallback_cb' => 'smp_primary_menu_fallback', 'depth' => 1]); ?>
</div></header>

