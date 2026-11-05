<?php
/**
 * Resources bento grid, driven by the blog's posts.
 * Section chrome from ACF Options; cards from inc/resources.php.
 *
 * Shared by the home page's teaser strip and the Resources page, so the
 * two can never drift apart. $args['prefix'] picks the field set,
 * $args['paged'] turns on pagination, and $args['anchor'] keeps the
 * id="resources" jump target on the home page only — two elements with
 * the same id would be invalid and break the nav anchor.
 */

$prefix  = ! empty( $args['prefix'] ) ? $args['prefix'] : 'res';
$anchor  = ! empty( $args['anchor'] );
$is_page = ! empty( $args['paged'] );

$heading = get_field( "{$prefix}_heading", 'option' ) ?: 'Resources';
$subtext = get_field( "{$prefix}_subtext", 'option' );
$limit   = (int) get_field( "{$prefix}_count", 'option' );
$limit   = $limit > 0 ? $limit : 8;

$max_pages = 1;
$paged     = 1;
if ( $is_page ) {
	// A static page paginates through 'paged' on /page/N/, but WP also
	// uses 'page' for <!--nextpage--> splits — read both.
	$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
}

$cards = ldw_get_resource_cards( $limit, $is_page ? $paged : 0, $max_pages );

if ( ! $cards ) {
	return;
}
?>
<div class="ldw-res-band">
  <section <?php if ( $anchor ) : ?>id="resources" <?php endif; ?>data-screen-label="<?php echo esc_attr( ! empty( $args['label'] ) ? $args['label'] : 'Resources' ); ?>" class="ldw-res">
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

    <?php
    if ( $is_page && $max_pages > 1 ) {
    	$links = paginate_links(
    		array(
    			'base'      => trailingslashit( get_permalink() ) . 'page/%#%/',
    			'format'    => '',
    			'current'   => $paged,
    			'total'     => $max_pages,
    			'type'      => 'array',
    			'prev_text' => '&larr; Newer',
    			'next_text' => 'Older &rarr;',
    		)
    	);
    	if ( $links ) :
    		?>
    		<nav class="ldw-res-pagination" aria-label="Resources pages">
    			<?php echo implode( '', $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links() returns escaped markup. ?>
    		</nav>
    		<?php
    	endif;
    }
    ?>
  </section>
</div>
