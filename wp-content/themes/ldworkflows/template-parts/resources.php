<?php
/**
 * Resources bento grid, driven by the blog's posts.
 * Section chrome from ACF Options; cards from inc/resources.php.
 */

$heading = get_field( 'res_heading', 'option' ) ?: 'Resources';
$subtext = get_field( 'res_subtext', 'option' );
$limit   = (int) get_field( 'res_count', 'option' );
$cards   = ldw_get_resource_cards( $limit > 0 ? $limit : 8 );

if ( ! $cards ) {
	return;
}
?>
<div class="ldw-res-band">
  <section id="resources" data-screen-label="Resources" class="ldw-res">
    <div class="ldw-res-head">
      <h2 class="ldw-res-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php if ( $subtext ) : ?>
        <p class="ldw-res-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>
    </div>

    <div class="ldw-res-grid">
      <?php foreach ( $cards as $card ) : ?>
        <?php
        $span = sprintf( '--cols:%d;--rows:%d;', $card['cols'], $card['rows'] );
        if ( $card['image'] ) :
          ?>
          <a href="<?php echo esc_url( $card['url'] ); ?>" class="ldw-res-card ldw-res-card--image" style="<?php echo esc_attr( $span . '--band:' . $card['band'] . ';' ); ?>">
            <div class="ldw-res-card-media">
              <?php echo wp_get_attachment_image( $card['image'], 'ldw-resource', false, array( 'alt' => '' ) ); ?>
            </div>
            <div class="ldw-res-card-veil" aria-hidden="true"></div>
            <?php if ( $card['tag'] ) : ?>
              <span class="ldw-res-tag"><?php echo esc_html( $card['tag'] ); ?></span>
            <?php endif; ?>
            <div class="ldw-res-card-body">
              <h3 class="ldw-res-card-title"><?php echo esc_html( $card['title'] ); ?></h3>
              <?php if ( $card['excerpt'] && 2 === $card['rows'] ) : ?>
                <p class="ldw-res-card-copy"><?php echo esc_html( $card['excerpt'] ); ?></p>
              <?php endif; ?>
              <span class="ldw-res-card-cta"><?php echo esc_html( $card['cta'] ); ?> <span aria-hidden="true">&rarr;</span></span>
            </div>
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url( $card['url'] ); ?>" class="ldw-res-card ldw-res-card--text" style="<?php echo esc_attr( $span . 'background:' . $card['tint'] . ';' ); ?>">
            <?php if ( $card['tag'] ) : ?>
              <span class="ldw-res-card-kicker"><?php echo esc_html( $card['tag'] ); ?></span>
            <?php endif; ?>
            <h3 class="ldw-res-card-heading"><?php echo esc_html( $card['title'] ); ?></h3>
            <p class="ldw-res-card-text"><?php echo esc_html( $card['excerpt'] ); ?></p>
            <span class="ldw-res-card-arrow" aria-hidden="true">&rarr;</span>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
</div>
