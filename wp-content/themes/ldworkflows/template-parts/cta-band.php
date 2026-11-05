<?php
/**
 * Dark "Don't just take our word for it" CTA band.
 * Content from ACF Options (Theme Content > CTA Band Section).
 * Carries id="contact" — the nav's "Contact" link points to this anchor.
 */

$badge       = get_field( 'cta_badge', 'option' );
$heading     = get_field( 'cta_heading', 'option' ) ?: "Don't just take our word for it.";
$subtext     = get_field( 'cta_subtext', 'option' );
$button_text = get_field( 'cta_button_text', 'option' ) ?: 'Book a demo';
$button_url  = get_field( 'cta_button_url', 'option' ) ?: '#';
$trust_items = array_values( array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'cta_trust_items', 'option' ) ) ) ) );
?>
<section id="contact" data-screen-label="CTA" class="ldw-cta-band">
  <div class="ldw-cta-band-grid" aria-hidden="true"></div>
  <div class="ldw-cta-band-ring ldw-cta-band-ring--a" aria-hidden="true"></div>
  <div class="ldw-cta-band-ring ldw-cta-band-ring--b" aria-hidden="true"></div>
  <div class="ldw-cta-band-glow" aria-hidden="true"></div>

  <div class="ldw-cta-band-inner">
    <?php if ( $badge ) : ?>
      <div class="ldw-cta-band-badge"><span class="ldw-cta-band-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span> <?php echo esc_html( $badge ); ?></div>
    <?php endif; ?>

    <h2 class="ldw-cta-band-heading"><?php echo esc_html( $heading ); ?></h2>
    <?php if ( $subtext ) : ?>
      <p class="ldw-cta-band-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>

    <div class="ldw-cta-row">
      <a href="<?php echo esc_url( $button_url ); ?>"<?php echo ldw_link_target_attrs( $button_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-cta-band-button">
        <?php echo esc_html( $button_text ); ?>
        <span class="ldw-cta-band-button-arrow" aria-hidden="true">&rarr;</span>
      </a>
    </div>

    <?php if ( $trust_items ) : ?>
      <div class="ldw-cta-band-trust-row">
        <?php foreach ( $trust_items as $item ) : ?>
          <span class="ldw-cta-band-trust-item"><span class="ldw-cta-band-check">&#10003;</span> <?php echo esc_html( $item ); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
