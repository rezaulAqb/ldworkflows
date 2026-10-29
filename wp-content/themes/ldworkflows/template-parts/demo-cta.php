<?php
/**
 * "See LD Workflows in action." demo CTA panel.
 * All content from ACF Options (Theme Content > Demo CTA Section).
 */

$heading   = (string) ( get_field( 'demo_heading', 'option' ) ?: 'See LD Workflows [in action].' );
$subtext   = get_field( 'demo_subtext', 'option' );
$primary   = get_field( 'demo_primary_text', 'option' );
$prim_url  = get_field( 'demo_primary_url', 'option' ) ?: '#';
$secondary = get_field( 'demo_secondary_text', 'option' );
$sec_url   = get_field( 'demo_secondary_url', 'option' ) ?: '#';

// Same bracket convention as the case study quote: escape first, then
// swap the markers, so the contents can't inject markup.
$heading_html = preg_replace( '/\[(.+?)\]/', '<em class="ldw-demo-em">$1</em>', esc_html( $heading ) );

$stats = array();
foreach ( explode( "\n", (string) get_field( 'demo_stats', 'option' ) ) as $line ) {
	$line = trim( $line );
	if ( '' === $line ) {
		continue;
	}
	$parts   = array_map( 'trim', explode( '|', $line, 2 ) );
	$stats[] = array(
		'value' => $parts[0],
		'label' => isset( $parts[1] ) ? $parts[1] : '',
	);
}
?>
<div class="ldw-demo-band">
  <section data-screen-label="Demo CTA" class="ldw-demo">
    <div class="ldw-demo-grid">
      <div class="ldw-demo-main">
        <h2 class="ldw-demo-heading"><?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above, then markers replaced. ?></h2>

        <?php if ( $subtext ) : ?>
          <p class="ldw-demo-subtext"><?php echo esc_html( $subtext ); ?></p>
        <?php endif; ?>

        <?php if ( $primary || $secondary ) : ?>
          <div class="ldw-demo-actions">
            <?php if ( $primary ) : ?>
              <a href="<?php echo esc_url( $prim_url ); ?>"<?php echo ldw_link_target_attrs( $prim_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-demo-btn ldw-demo-btn--primary"><?php echo esc_html( $primary ); ?></a>
            <?php endif; ?>
            <?php if ( $secondary ) : ?>
              <a href="<?php echo esc_url( $sec_url ); ?>"<?php echo ldw_link_target_attrs( $sec_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-demo-btn ldw-demo-btn--ghost"><?php echo esc_html( $secondary ); ?></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ( $stats ) : ?>
        <div class="ldw-demo-cards">
          <?php foreach ( $stats as $stat ) : ?>
            <div class="ldw-demo-card">
              <span class="ldw-demo-card-value"><?php echo esc_html( $stat['value'] ); ?></span>
              <span class="ldw-demo-card-label"><?php echo esc_html( $stat['label'] ); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>
