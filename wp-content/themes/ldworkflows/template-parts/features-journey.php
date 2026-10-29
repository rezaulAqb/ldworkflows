<?php
/**
 * "Tailored flows for every part of your teams' day" journey section.
 * Content from ACF Options (Theme Content > Features Journey Section).
 *
 * Three cards, not a variable list: the dashed SVG path's node positions
 * and the per-card offsets/rotations are a fixed three-column
 * choreography, so a CPT or repeater would let a 4th card silently break
 * the layout.
 */

$heading = get_field( 'journey_heading', 'option' ) ?: "Tailored flows for every part\nof your teams' day";
$subtext = get_field( 'journey_subtext', 'option' );

// Subject hints carried over from the source design's image-slot
// placeholders, shown until a real image is uploaded.
$slot_hints = array( 1 => 'Dashboard screenshot', 2 => 'Mobile app in use', 3 => 'Secure platform image' );

$cards = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$title = get_field( "journey_card_{$i}_title", 'option' );
	if ( ! $title ) {
		continue;
	}
	$cards[] = array(
		'label' => get_field( "journey_card_{$i}_label", 'option' ),
		'title' => $title,
		'image' => get_field( "journey_card_{$i}_image", 'option' ),
		'text'  => get_field( "journey_card_{$i}_text", 'option' ),
		'theme' => get_field( "journey_card_{$i}_theme", 'option' ) ?: 'peach',
		'hint'  => $slot_hints[ $i ],
		'items' => array_values( array_filter( array_map( 'trim', explode( "\n", (string) get_field( "journey_card_{$i}_items", 'option' ) ) ) ) ),
	);
}
?>
<div class="ldw-journey-band">
  <section data-screen-label="Features" class="ldw-journey">
    <h2 class="ldw-journey-heading"><?php echo nl2br( esc_html( $heading ) ); ?></h2>
    <?php if ( $subtext ) : ?>
      <p class="ldw-journey-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>

    <div class="ldw-journey-stage">
      <svg class="ldw-journey-line" viewBox="0 0 1176 320" preserveAspectRatio="none" aria-hidden="true">
        <path class="ldw-journey-path" d="M 60 88 C 280 0, 400 250, 588 200 C 750 158, 900 40, 1116 152" fill="none" stroke="#59ADA8" stroke-width="2.5" stroke-dasharray="10 9" stroke-linecap="round"></path>
        <circle cx="60" cy="88" r="7" fill="#59ADA8"></circle>
        <circle cx="588" cy="200" r="7" fill="#59ADA8"></circle>
        <circle cx="1116" cy="152" r="7" fill="#59ADA8"></circle>
      </svg>

      <div class="ldw-journey-grid">
        <?php foreach ( $cards as $card ) : ?>
          <div class="ldw-journey-card ldw-journey-card--<?php echo esc_attr( $card['theme'] ); ?>">
            <?php if ( $card['label'] ) : ?>
              <span class="ldw-journey-step"><?php echo esc_html( $card['label'] ); ?></span>
            <?php endif; ?>

            <h3 class="ldw-journey-title"><?php echo esc_html( $card['title'] ); ?></h3>

            <?php if ( $card['image'] ) : ?>
              <div class="ldw-journey-media">
                <?php echo wp_get_attachment_image( $card['image'], 'large' ); ?>
              </div>
            <?php else : ?>
              <div class="ldw-journey-media ldw-journey-media--empty"><?php echo esc_html( $card['hint'] ); ?></div>
            <?php endif; ?>

            <?php if ( $card['text'] ) : ?>
              <p class="ldw-journey-text"><?php echo esc_html( $card['text'] ); ?></p>
            <?php endif; ?>

            <?php if ( $card['items'] ) : ?>
              <div class="ldw-journey-list">
                <?php foreach ( $card['items'] as $item ) : ?>
                  <span class="ldw-journey-list-item"><span class="ldw-journey-check">&#10003;</span> <?php echo esc_html( $item ); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</div>
