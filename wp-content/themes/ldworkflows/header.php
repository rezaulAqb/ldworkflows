<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="ldw-root">

<header data-screen-label="Nav" class="ldw-nav-header">
  <div class="ldw-nav-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ldw-nav-logo">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <img src="<?php echo esc_url( LDW_THEME_URI . '/assets/images/ld-workflows-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height:36px;width:auto;display:block">
      <?php endif; ?>
    </a>

    <nav class="ldw-nav-links">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'depth'          => 2,
          'walker'         => new LDW_Nav_Walker(),
          'fallback_cb'    => false,
        )
      );
      ?>
    </nav>

    <button type="button" class="ldw-nav-toggle" aria-label="Menu" aria-expanded="false">
      <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="display:block"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
    </button>
  </div>

  <div class="ldw-nav-mobile">
    <div class="ldw-nav-mobile-inner">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'          => 0,
          'menu_class'     => 'ldw-nav-mobile-list',
          'fallback_cb'    => false,
        )
      );
      ?>
    </div>
  </div>
</header>
