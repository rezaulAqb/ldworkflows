<?php
/**
 * "You vs NetSuite" two-card comparison. Heading/quote from ACF Options
 * (Theme Content > You vs NetSuite); the cards from the VS Card CPT.
 * Shares its card markup/classes with the CRM comparison cards
 * (template-parts/crm-comparison.php) since both sections use the same
 * badge/title/subtitle/rows card shape — only the grid column count and
 * band wrapper differ.
 */

// Distinguish "never set" (use the default) from "deliberately cleared"
// (hide the pill); ?: would collapse the two into one.
$eyebrow    = get_field( 'vs_eyebrow', 'option' );
if ( null === $eyebrow || false === $eyebrow ) {
	$eyebrow = 'You vs NetSuite';
}
$heading    = get_field( 'vs_heading', 'option' ) ?: 'Live in days, not months, for a fraction of the cost.';
$quote_text = get_field( 'vs_quote_text', 'option' );
$cards      = ldw_get_vs_cards();

if ( ! $cards ) {
	return;
}
?>
<section data-screen-label="You vs NetSuite" class="ldw-vs">
  <div class="ldw-vs-head">
    <?php if ( $eyebrow ) : ?>
      <span class="ldw-vs-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
    <?php endif; ?>
    <h2 class="ldw-vs-heading"><?php echo esc_html( $heading ); ?></h2>
  </div>

  <div class="ldw-crm-grid ldw-vs-grid">
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

  <?php if ( $quote_text ) : ?>
    <div class="ldw-vs-quote">
      <span class="ldw-crm-quote-mark" aria-hidden="true">&ldquo;</span>
      <p class="ldw-crm-quote-text"><?php echo wp_kses( $quote_text, array( 'strong' => array() ) ); ?></p>
    </div>
  <?php endif; ?>
</section>
