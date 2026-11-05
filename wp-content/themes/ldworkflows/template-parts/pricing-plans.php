<?php
/**
 * "Choose monthly or annual" plan cards. Intro/footnote copy from ACF
 * Options (Theme Content > Pricing Plans); the cards from the Pricing
 * Plan CPT. The monthly/annual toggle is plain CSS + a checkbox input
 * (no JS needed) — see .ldw-plan-toggle-input in theme-components.css.
 */

$intro         = get_field( 'plans_intro', 'option' );
$monthly_label = get_field( 'plans_monthly_label', 'option' ) ?: 'Monthly';
$annual_label  = get_field( 'plans_annual_label', 'option' ) ?: 'Annual';
$annual_note   = get_field( 'plans_annual_badge', 'option' ) ?: '2 months free';
$note_monthly  = get_field( 'plans_price_note_monthly', 'option' ) ?: 'per month, billed monthly';
$note_annual   = get_field( 'plans_price_note_annual', 'option' ) ?: 'per month, billed annually · {badge}';
// {badge} lets the annual caption reuse the toggle badge, so changing the
// promo in one field can't leave the two contradicting each other.
$note_annual   = str_replace( '{badge}', $annual_note, $note_annual );
$footnote      = get_field( 'plans_footnote', 'option' );
$plans         = ldw_get_pricing_plans();

if ( ! $plans ) {
	return;
}
?>
<section id="plans" data-screen-label="Plans" class="ldw-plans">
  <div class="ldw-plans-inner">
    <?php if ( $intro ) : ?>
      <p class="ldw-plans-intro"><?php echo esc_html( $intro ); ?></p>
    <?php endif; ?>

    <?php /* Direct child of .ldw-plans-inner so the ~ sibling combinator below can reach both the toggle label and the plan grid. */ ?>
    <input type="checkbox" id="ldw-plan-billing" class="ldw-plan-toggle-input" checked>

    <div class="ldw-plan-toggle">
      <label for="ldw-plan-billing" class="ldw-plan-toggle-track">
        <span class="ldw-plan-toggle-option ldw-plan-toggle-option--monthly"><?php echo esc_html( $monthly_label ); ?></span>
        <span class="ldw-plan-toggle-option ldw-plan-toggle-option--annual"><?php echo esc_html( $annual_label ); ?> <span class="ldw-plan-toggle-badge"><?php echo esc_html( $annual_note ); ?></span></span>
      </label>
    </div>

    <div class="ldw-plan-grid">
      <?php foreach ( $plans as $plan ) : ?>
        <div class="ldw-plan-card<?php echo $plan['featured'] ? ' ldw-plan-card--featured' : ''; ?>">
          <?php if ( $plan['badge'] ) : ?>
            <span class="ldw-plan-badge"><?php echo esc_html( $plan['badge'] ); ?></span>
          <?php endif; ?>
          <h3 class="ldw-plan-name"><?php echo esc_html( $plan['title'] ); ?></h3>
          <?php if ( $plan['subtitle'] ) : ?>
            <p class="ldw-plan-subtitle"><?php echo esc_html( $plan['subtitle'] ); ?></p>
          <?php endif; ?>

          <div class="ldw-plan-price">
            <span class="ldw-plan-price-value ldw-plan-price-value--monthly"><?php echo esc_html( $plan['price_monthly'] ); ?></span>
            <span class="ldw-plan-price-value ldw-plan-price-value--annual"><?php echo esc_html( $plan['price_annual'] ); ?></span>
            <span class="ldw-plan-price-suffix">/mo</span>
          </div>
          <p class="ldw-plan-price-note">
            <span class="ldw-plan-price-note--monthly"><?php echo esc_html( $note_monthly ); ?></span>
            <span class="ldw-plan-price-note--annual"><?php echo esc_html( $note_annual ); ?></span>
          </p>

          <a href="<?php echo esc_url( $plan['cta_url'] ); ?>" class="ldw-plan-cta"><?php echo esc_html( $plan['cta_text'] ); ?></a>

          <?php if ( $plan['features'] ) : ?>
            <div class="ldw-plan-features">
              <?php foreach ( $plan['features'] as $feature ) : ?>
                <span class="ldw-plan-feature<?php echo $feature['excluded'] ? ' ldw-plan-feature--excluded' : ''; ?>">
                  <span class="ldw-plan-feature-mark" aria-hidden="true"><?php echo $feature['excluded'] ? '&#10005;' : '&#10003;'; ?></span>
                  <?php echo esc_html( $feature['label'] ); ?>
                </span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ( $footnote ) : ?>
      <p class="ldw-plans-footnote"><?php echo wp_kses( $footnote, array( 'strong' => array() ) ); ?></p>
    <?php endif; ?>
  </div>
</section>
