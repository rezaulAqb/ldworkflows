<?php
/**
 * Site footer. Content from ACF Options (Theme Content > Footer); the
 * link row is a standard WordPress menu assigned to the "Footer
 * Navigation" location, so it's managed under Appearance > Menus like
 * the header's.
 */

$f_heading   = get_field( 'footer_heading', 'option' );
$f_primary   = get_field( 'footer_primary_text', 'option' );
$f_prim_url  = get_field( 'footer_primary_url', 'option' ) ?: '#contact';
$f_secondary = get_field( 'footer_secondary_text', 'option' );
$f_sec_url   = get_field( 'footer_secondary_url', 'option' ) ?: '#contact';
$f_copy      = get_field( 'footer_copyright', 'option' );
$f_wordmark  = get_field( 'footer_wordmark', 'option' );

$f_legal = array();
foreach ( explode( "\n", (string) get_field( 'footer_legal', 'option' ) ) as $line ) {
	$line = trim( $line );
	if ( '' === $line ) {
		continue;
	}
	$parts     = array_map( 'trim', explode( '|', $line, 2 ) );
	$f_legal[] = array(
		'label' => $parts[0],
		'url'   => isset( $parts[1] ) ? $parts[1] : '#',
	);
}
?>
<footer data-screen-label="Footer" class="ldw-footer">
  <div class="ldw-footer-inner">
    <?php if ( $f_heading || $f_primary || $f_secondary ) : ?>
      <div class="ldw-footer-top">
        <?php if ( $f_heading ) : ?>
          <h2 class="ldw-footer-heading"><?php echo esc_html( $f_heading ); ?></h2>
        <?php endif; ?>
        <div class="ldw-footer-actions">
          <?php if ( $f_primary ) : ?>
            <a href="<?php echo esc_url( $f_prim_url ); ?>"<?php echo ldw_link_target_attrs( $f_prim_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-footer-btn ldw-footer-btn--primary">
              <?php echo esc_html( $f_primary ); ?> <span aria-hidden="true">&rarr;</span>
            </a>
          <?php endif; ?>
          <?php if ( $f_secondary ) : ?>
            <a href="<?php echo esc_url( $f_sec_url ); ?>"<?php echo ldw_link_target_attrs( $f_sec_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-footer-btn ldw-footer-btn--ghost"><?php echo esc_html( $f_secondary ); ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="ldw-footer-nav">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ldw-footer-logo">
        <?php if ( has_custom_logo() ) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <img src="<?php echo esc_url( LDW_THEME_URI . '/assets/images/ld-workflows-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        <?php endif; ?>
      </a>
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'footer',
          'container'      => 'nav',
          'menu_class'     => 'ldw-footer-links',
          'depth'          => 1,
          'fallback_cb'    => false,
        )
      );
      ?>
    </div>

    <div class="ldw-footer-bottom">
      <span><?php echo esc_html( $f_copy ?: sprintf( 'All rights reserved © %s %s', date( 'Y' ), get_bloginfo( 'name' ) ) ); ?></span>
      <?php if ( $f_legal ) : ?>
        <div class="ldw-footer-legal">
          <?php foreach ( $f_legal as $item ) : ?>
            <a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( $f_wordmark ) : ?>
      <div class="ldw-footer-word" aria-hidden="true"><?php echo esc_html( $f_wordmark ); ?></div>
    <?php endif; ?>
  </div>
</footer>

</div><!-- .ldw-root -->
<?php wp_footer(); ?>
</body>
</html>
