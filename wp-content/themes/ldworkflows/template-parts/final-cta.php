<?php
/**
 * Closing "Don't just take our word for it." band on the Pricing page.
 * Content from ACF Options (Theme Content > Final CTA).
 *
 * Distinct from template-parts/cta-band.php: that one is the homepage's
 * centred badge/heading/single-button panel and owns id="contact". This
 * is the design's horizontal band — copy left, two buttons right.
 */

$prefix    = ! empty( $args['prefix'] ) ? $args['prefix'] : 'final_cta';
$heading   = get_field( "{$prefix}_heading", 'option' );
if ( ! $heading && 'final_cta' === $prefix ) {
	$heading = "Don't just take our word for it.";
}
$accent    = get_field( "{$prefix}_accent", 'option' );
$primary   = get_field( "{$prefix}_primary_text", 'option' );
$prim_url  = get_field( "{$prefix}_primary_url", 'option' ) ?: '#';
$secondary = get_field( "{$prefix}_secondary_text", 'option' );
$sec_url   = get_field( "{$prefix}_secondary_url", 'option' ) ?: '#';
?>
<?php if ( $heading || $accent || $primary || $secondary ) : ?>
<section data-screen-label="Final CTA" class="ldw-final-cta-section">
  <div class="ldw-final-cta">
    <div class="ldw-final-cta-copy">
      <?php if ( $heading ) : ?><h2 class="ldw-final-cta-heading"><?php echo esc_html( $heading ); ?></h2><?php endif; ?>
      <?php if ( $accent ) : ?>
        <div class="ldw-final-cta-accent"><?php echo esc_html( $accent ); ?></div>
      <?php endif; ?>
    </div>

    <?php if ( $primary || $secondary ) : ?>
      <div class="ldw-final-cta-actions">
        <?php if ( $primary ) : ?>
          <a href="<?php echo esc_url( $prim_url ); ?>"<?php echo ldw_link_target_attrs( $prim_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-final-cta-btn ldw-final-cta-btn--primary"><?php echo esc_html( $primary ); ?></a>
        <?php endif; ?>
        <?php if ( $secondary ) : ?>
          <a href="<?php echo esc_url( $sec_url ); ?>"<?php echo ldw_link_target_attrs( $sec_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-final-cta-btn ldw-final-cta-btn--ghost"><?php echo esc_html( $secondary ); ?></a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
