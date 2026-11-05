<?php
/**
 * Checklist feature block for the CRM page — an illustration beside a
 * heading and tick list, as on the source page. Driven by
 * $args['prefix'] so one definition serves "Grouping of customers",
 * "Core features" and "Emails & team communications"; items are one per
 * line in a textarea, the same convention as the CTA band's trust items.
 *
 * $args['image_side'] ('left'|'right') alternates the layout down the
 * page. With no image uploaded the block falls back to a centred,
 * full-width list.
 */

$prefix = ! empty( $args['prefix'] ) ? $args['prefix'] : 'crm_features';
$side   = ( ! empty( $args['image_side'] ) && 'right' === $args['image_side'] ) ? 'right' : 'left';

$heading = get_field( "{$prefix}_heading", 'option' );
$subtext = get_field( "{$prefix}_subtext", 'option' );
$image   = get_field( "{$prefix}_image", 'option' );
$items   = array_values( array_filter( array_map( 'trim', explode( "\n", (string) get_field( "{$prefix}_items", 'option' ) ) ) ) );

if ( ! $heading && ! $items ) {
	return;
}

$has_image = ( is_array( $image ) && ! empty( $image['url'] ) );
?>
<section data-screen-label="<?php echo esc_attr( ! empty( $args['label'] ) ? $args['label'] : 'CRM features' ); ?>" class="ldw-crmp-checklist<?php echo $has_image ? ' ldw-crmp-checklist--split ldw-crmp-checklist--img-' . esc_attr( $side ) : ''; ?>">
  <div class="ldw-crmp-checklist-inner">
    <?php if ( $has_image ) : ?>
      <div class="ldw-crmp-checklist-media">
        <img src="<?php echo esc_url( $image['url'] ); ?>"
             alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : (string) $heading ); ?>"
             <?php if ( ! empty( $image['width'] ) ) : ?>width="<?php echo esc_attr( $image['width'] ); ?>"<?php endif; ?>
             <?php if ( ! empty( $image['height'] ) ) : ?>height="<?php echo esc_attr( $image['height'] ); ?>"<?php endif; ?>
             loading="lazy" decoding="async">
      </div>
    <?php endif; ?>

    <div class="ldw-crmp-checklist-copy">
      <?php if ( $heading ) : ?>
        <h2 class="ldw-crmp-checklist-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php endif; ?>

      <?php if ( $subtext ) : ?>
        <p class="ldw-crmp-checklist-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>

      <?php if ( $items ) : ?>
        <ul class="ldw-crmp-checklist-list">
          <?php foreach ( $items as $item ) : ?>
            <li class="ldw-crmp-checklist-item">
              <span class="ldw-crmp-checklist-tick" aria-hidden="true">&#10003;</span>
              <span><?php echo esc_html( $item ); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</section>
