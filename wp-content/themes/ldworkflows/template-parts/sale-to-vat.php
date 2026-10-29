<?php
/**
 * "From a sale to a VAT return" animated timeline.
 * Content from ACF Options (Theme Content > Sale to VAT Section).
 * The 5 steps alternate label position above/below the track and each
 * has its own fixed-index CSS keyframe (ldw-rev{i} / ldw-dot{i}) driving
 * a single 17s loop shared with the travelling pulse on the track.
 */

$heading = get_field( 'vat_heading', 'option' ) ?: 'From a sale to a VAT return, with no human intervention';
$subtext = get_field( 'vat_subtext', 'option' );
$steps   = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$label = get_field( "vat_step_{$i}", 'option' );
	if ( $label ) {
		$steps[] = $label;
	}
}
?>
<section id="sale-to-vat" data-screen-label="Sale to VAT" class="ldw-vat-section">
  <div class="ldw-vat-inner">
    <div class="ldw-vat-head">
      <h2 class="ldw-vat-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php if ( $subtext ) : ?>
        <p class="ldw-vat-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>
    </div>

    <div class="ldw-vat-wrap">
      <div class="ldw-vat-track">
        <div class="ldw-vat-fill"></div>
        <span class="ldw-vat-pulse-trail"></span>
        <span class="ldw-vat-pulse-dot"></span>
      </div>
      <div class="ldw-vat-grid">
        <?php foreach ( $steps as $i => $label ) :
          $above = 0 === ( $i % 2 );
          ?>
          <div class="ldw-vat-step <?php echo $above ? 'ldw-vat-step--above' : 'ldw-vat-step--below'; ?>">
            <div class="ldw-vat-step-label" style="animation: ldw-rev<?php echo (int) $i; ?> 17s linear infinite">
              <div class="ldw-vat-step-label-text"><?php echo esc_html( $label ); ?></div>
            </div>
            <div class="ldw-vat-step-connector"></div>
            <div class="ldw-vat-step-dot" style="animation: ldw-dot<?php echo (int) $i; ?> 17s linear infinite"></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
