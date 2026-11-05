<?php
/**
 * Pricing FAQ accordion. Heading from ACF Options (Theme Content > Pricing
 * FAQ); the questions from the Pricing FAQ CPT. Uses native <details> for
 * the open/close behaviour instead of JS.
 */

$heading = get_field( 'faq_heading', 'option' ) ?: 'Frequently asked questions';
$faqs    = ldw_get_pricing_faqs();

if ( ! $faqs ) {
	return;
}
?>
<section data-screen-label="FAQ" class="ldw-faq">
  <div class="ldw-faq-inner">
    <h2 class="ldw-faq-heading"><?php echo esc_html( $heading ); ?></h2>
    <div class="ldw-faq-list">
      <?php foreach ( $faqs as $faq ) : ?>
        <details class="ldw-faq-item">
          <summary class="ldw-faq-question">
            <span><?php echo esc_html( $faq['q'] ); ?></span>
            <span class="ldw-faq-icon" aria-hidden="true">+</span>
          </summary>
          <div class="ldw-faq-answer"><?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
