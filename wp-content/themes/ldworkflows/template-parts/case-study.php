<?php
/**
 * "Real teams, real results" case study panel.
 * All content from ACF Options (Theme Content > Case Study Section).
 */

$heading     = get_field( 'case_heading', 'option' ) ?: 'Real teams, real results';
$subtext     = get_field( 'case_subtext', 'option' );
$quote       = (string) get_field( 'case_quote', 'option' );
$attribution = get_field( 'case_attribution', 'option' );
$cta_text    = get_field( 'case_cta_text', 'option' );
$cta_url     = get_field( 'case_cta_url', 'option' ) ?: '#';

// Square brackets mark the highlighted figure, e.g. "...by [62%] and...".
// Escaping happens first, so bracket contents can't inject markup.
$quote_html = preg_replace(
	'/\[(.+?)\]/',
	'<em class="ldw-case-highlight">$1</em>',
	esc_html( $quote )
);

$stats = array();
foreach ( explode( "\n", (string) get_field( 'case_stats', 'option' ) ) as $line ) {
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
<div class="ldw-case-band">
  <section data-screen-label="Case study" class="ldw-case">
    <div class="ldw-case-head">
      <h2 class="ldw-case-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php if ( $subtext ) : ?>
        <p class="ldw-case-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>
    </div>

    <div class="ldw-case-grid">
      <div class="ldw-case-main">
        <?php if ( $quote ) : ?>
          <p class="ldw-case-quote"><?php echo $quote_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above, then markers replaced. ?></p>
        <?php endif; ?>

        <?php if ( $attribution ) : ?>
          <div class="ldw-case-author"><?php echo esc_html( $attribution ); ?></div>
        <?php endif; ?>

        <?php if ( $cta_text ) : ?>
          <a href="<?php echo esc_url( $cta_url ); ?>" class="ldw-case-cta">
            <?php echo esc_html( $cta_text ); ?>
            <span aria-hidden="true">&rarr;</span>
          </a>
        <?php endif; ?>
      </div>

      <?php if ( $stats ) : ?>
        <div class="ldw-case-stats">
          <?php foreach ( $stats as $stat ) : ?>
            <div class="ldw-case-stat">
              <div class="ldw-case-stat-value"><?php echo esc_html( $stat['value'] ); ?></div>
              <?php if ( $stat['label'] ) : ?>
                <div class="ldw-case-stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>
