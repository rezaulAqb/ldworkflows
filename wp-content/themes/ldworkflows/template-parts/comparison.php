<?php
/**
 * "NetSuite capability. Xero-level price." comparison table.
 * Heading, column names and summary from ACF Options; rows from the
 * Comparison Feature CPT, so the row count is admin-controlled.
 *
 * Column 1 is the site's own plan — it carries the dark header cell and
 * the tinted body cells throughout.
 */

// The home page design has no eyebrow here, so callers opt in explicitly
// rather than this shared part guessing from the current page.
$show_eyebrow = ! empty( $args['show_eyebrow'] );
$eyebrow   = '';
if ( $show_eyebrow ) {
	// Distinguish "never set" (fall back to the default) from "deliberately
	// cleared" (hide the pill) — ?: would collapse the two into one.
	$eyebrow = get_field( 'compare_eyebrow', 'option' );
	if ( null === $eyebrow || false === $eyebrow ) {
		$eyebrow = 'How the platforms compare';
	}
}
$heading   = get_field( 'compare_heading', 'option' ) ?: 'NetSuite capability. Xero-level price.';
$col_label = get_field( 'compare_col_label', 'option' ) ?: 'Feature coverage';
$plans     = array(
	get_field( 'compare_plan_1_name', 'option' ) ?: 'LD Workflows',
	get_field( 'compare_plan_2_name', 'option' ),
	get_field( 'compare_plan_3_name', 'option' ),
);
$rows = ldw_get_compare_features();

$summary_label     = get_field( 'compare_summary_label', 'option' );
$summary_text      = get_field( 'compare_summary_text', 'option' );
$summary_highlight = get_field( 'compare_summary_highlight', 'option' );
?>
<div class="ldw-compare-band">
  <section id="pricing" data-screen-label="Comparison" class="ldw-compare">
    <div class="ldw-compare-inner">
      <div class="ldw-compare-head">
        <?php if ( $eyebrow ) : ?>
          <span class="ldw-compare-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
        <?php endif; ?>
        <h2 class="ldw-compare-heading"><?php echo esc_html( $heading ); ?></h2>
      </div>

      <?php if ( $rows ) : ?>
        <div class="ldw-compare-table">
          <div class="ldw-compare-row ldw-compare-row--head">
            <div class="ldw-compare-cell ldw-compare-cell--label"><?php echo esc_html( $col_label ); ?></div>
            <?php foreach ( $plans as $i => $plan ) : ?>
              <div class="ldw-compare-cell ldw-compare-cell--planhead<?php echo 0 === $i ? ' ldw-compare-cell--own' : ''; ?>">
                <span><?php echo esc_html( $plan ); ?></span>
              </div>
            <?php endforeach; ?>
          </div>

          <?php foreach ( $rows as $row ) : ?>
            <div class="ldw-compare-row">
              <div class="ldw-compare-cell ldw-compare-cell--feature"><?php echo esc_html( $row['label'] ); ?></div>
              <?php foreach ( $row['values'] as $i => $value ) : ?>
                <?php // data-plan feeds the stacked mobile layout's row label via CSS content: attr(). ?>
                <div class="ldw-compare-cell ldw-compare-cell--value<?php echo 0 === $i ? ' ldw-compare-cell--own' : ''; ?>" data-plan="<?php echo esc_attr( $plans[ $i ] ); ?>">
                  <?php if ( ldw_compare_is_tick( $value ) ) : ?>
                    <span class="ldw-compare-tick" aria-label="Included">&#10003;</span>
                  <?php else : ?>
                    <?php echo esc_html( $value ); ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ( $summary_text || $summary_highlight ) : ?>
        <div class="ldw-compare-summary">
          <?php if ( $summary_label ) : ?>
            <div class="ldw-compare-summary-label"><?php echo esc_html( $summary_label ); ?></div>
          <?php endif; ?>
          <p class="ldw-compare-summary-text">
            <?php echo esc_html( $summary_text ); ?>
            <?php if ( $summary_highlight ) : ?>
              <span class="ldw-compare-summary-highlight"><?php echo esc_html( $summary_highlight ); ?></span>
            <?php endif; ?>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>
