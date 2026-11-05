<?php
/**
 * "A CRM that can actually see your money." plan cards.
 * Heading and closing quote from ACF Options; the cards (and each card's
 * rows) from the CRM Card CPT.
 */

// The home page design has no eyebrow here, so callers opt in explicitly
// rather than this shared part guessing from the current page.
$show_eyebrow = ! empty( $args['show_eyebrow'] );
$eyebrow    = '';
if ( $show_eyebrow ) {
	// "Never set" falls back to the default; "deliberately cleared" hides it.
	$eyebrow = get_field( 'crm_eyebrow', 'option' );
	if ( null === $eyebrow || false === $eyebrow ) {
		$eyebrow = 'CRM: you vs HubSpot & Pipedrive';
	}
}
$heading    = get_field( 'crm_heading', 'option' ) ?: 'A CRM that can actually see your money.';
$quote_lead = get_field( 'crm_quote_lead', 'option' );
$quote_text = get_field( 'crm_quote_text', 'option' );
$cards      = ldw_get_crm_cards();

if ( ! $cards ) {
	return;
}
?>
<div class="ldw-crm-band">
  <section data-screen-label="CRM comparison" class="ldw-crm">
    <div class="ldw-crm-head">
      <?php if ( $eyebrow ) : ?>
        <span class="ldw-crm-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
      <?php endif; ?>
      <h2 class="ldw-crm-heading"><?php echo esc_html( $heading ); ?></h2>
    </div>

    <div class="ldw-crm-grid">
      <?php foreach ( $cards as $card ) : ?>
        <div class="ldw-crm-card ldw-crm-card--<?php echo esc_attr( $card['theme'] ); ?>">
          <?php if ( $card['badge'] ) : ?>
            <span class="ldw-crm-badge"><?php echo esc_html( $card['badge'] ); ?></span>
          <?php endif; ?>

          <h3 class="ldw-crm-title"><?php echo esc_html( $card['title'] ); ?></h3>

          <?php if ( $card['subtitle'] ) : ?>
            <p class="ldw-crm-subtitle"><?php echo esc_html( $card['subtitle'] ); ?></p>
          <?php endif; ?>

          <?php if ( $card['rows'] ) : ?>
            <div class="ldw-crm-rows">
              <?php foreach ( $card['rows'] as $row ) : ?>
                <div class="ldw-crm-row">
                  <span class="ldw-crm-row-label"><?php echo esc_html( $row['label'] ); ?></span>
                  <span class="ldw-crm-row-value"><?php echo esc_html( $row['value'] ); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ( $quote_lead || $quote_text ) : ?>
      <div class="ldw-crm-quote">
        <span class="ldw-crm-quote-mark" aria-hidden="true">&ldquo;</span>
        <p class="ldw-crm-quote-text">
          <?php if ( $quote_lead ) : ?><strong><?php echo esc_html( $quote_lead ); ?></strong> <?php endif; ?>
          <?php echo esc_html( $quote_text ); ?>
        </p>
      </div>
    <?php endif; ?>
  </section>
</div>
