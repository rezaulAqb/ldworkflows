<?php
/**
 * "Check out more" workflow cross-link cards.
 * Section copy from ACF Options (Theme Content > CRM Workflow Links);
 * the cards from the CRM Workflow Card CPT.
 */

$heading = get_field( 'crm_flows_heading', 'option' );
$subtext = get_field( 'crm_flows_subtext', 'option' );
$cards   = ldw_get_crm_flow_cards();

if ( ! $cards ) {
	return;
}
?>
<section data-screen-label="CRM workflow links" class="ldw-crmp-flows">
  <div class="ldw-crmp-flows-head">
    <?php if ( $heading ) : ?>
      <h2 class="ldw-crmp-flows-heading"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>
    <?php if ( $subtext ) : ?>
      <p class="ldw-crmp-flows-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>
  </div>

  <div class="ldw-crmp-flows-grid">
    <?php foreach ( $cards as $card ) : ?>
      <div class="ldw-crmp-flow">
        <?php if ( is_array( $card['image'] ) && ! empty( $card['image']['url'] ) ) : ?>
          <div class="ldw-crmp-flow-media">
            <img src="<?php echo esc_url( $card['image']['url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy" decoding="async">
          </div>
        <?php endif; ?>
        <h3 class="ldw-crmp-flow-title"><?php echo esc_html( $card['title'] ); ?></h3>
        <?php if ( $card['text'] ) : ?>
          <p class="ldw-crmp-flow-text"><?php echo esc_html( $card['text'] ); ?></p>
        <?php endif; ?>
        <?php if ( $card['cta_text'] && $card['cta_url'] ) : ?>
          <a href="<?php echo esc_url( $card['cta_url'] ); ?>"<?php echo ldw_link_target_attrs( $card['cta_url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-crmp-flow-cta">
            <?php echo esc_html( $card['cta_text'] ); ?>
            <span aria-hidden="true">&rarr;</span>
          </a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
