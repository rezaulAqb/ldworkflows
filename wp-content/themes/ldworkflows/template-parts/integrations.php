<?php
/**
 * "Integrates with the systems you already run on" logo grid.
 * Heading/subtext from ACF Options; tiles from the Integration CPT,
 * so the count is whatever the admin has published.
 */

$heading = get_field( 'int_heading', 'option' ) ?: 'Integrates with the systems you already run on';
$subtext = get_field( 'int_subtext', 'option' );
$items   = ldw_get_integrations();

if ( ! $items ) {
	return;
}
?>
<div class="ldw-int-band">
  <section id="integrations" data-screen-label="Integrations" class="ldw-int">
    <div class="ldw-int-head">
      <h2 class="ldw-int-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php if ( $subtext ) : ?>
        <p class="ldw-int-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>
    </div>

    <div class="ldw-int-grid">
      <?php
      foreach ( $items as $item ) :
        $tag  = $item['url'] ? 'a' : 'div';
        $attr = $item['url'] ? ' href="' . esc_url( $item['url'] ) . '" target="_blank" rel="noopener"' : '';
        ?>
        <<?php echo $tag . $attr; ?> class="ldw-int-tile">
          <div class="ldw-int-tile-inner">
            <?php if ( $item['logo'] ) : ?>
              <?php echo wp_get_attachment_image( $item['logo'], 'medium', false, array( 'class' => 'ldw-int-logo', 'alt' => esc_attr( $item['name'] ) ) ); ?>
            <?php else : ?>
              <span class="ldw-int-name"><?php echo esc_html( $item['name'] ); ?></span>
            <?php endif; ?>
          </div>
        </<?php echo $tag; ?>>
      <?php endforeach; ?>
    </div>
  </section>
</div>
