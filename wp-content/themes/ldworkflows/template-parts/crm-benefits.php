<?php
/**
 * "Key benefits" numbered card list, used by the CRM and ERP pages.
 * Section copy from ACF Options under the prefix in $args['prefix'];
 * the cards from the CPT named in $args['post_type'], so the count is
 * admin-controlled and each page keeps its own set.
 */

$prefix = ! empty( $args['prefix'] ) ? $args['prefix'] : 'crm_benefits';
$cpt    = ! empty( $args['post_type'] ) ? $args['post_type'] : 'crm_benefit';

$heading = get_field( "{$prefix}_heading", 'option' );
$subtext = get_field( "{$prefix}_subtext", 'option' );
$cards   = ldw_get_benefit_cards( $cpt );

if ( ! $heading && ! $cards ) {
	return;
}
?>
<div class="ldw-crmp-benefits-band">
  <section data-screen-label="<?php echo esc_attr( ! empty( $args['label'] ) ? $args['label'] : 'CRM benefits' ); ?>" class="ldw-crmp-benefits">
    <div class="ldw-crmp-benefits-head">
      <?php if ( $heading ) : ?>
        <h2 class="ldw-crmp-benefits-heading"><?php echo esc_html( $heading ); ?></h2>
      <?php endif; ?>
      <?php if ( $subtext ) : ?>
        <p class="ldw-crmp-benefits-subtext"><?php echo esc_html( $subtext ); ?></p>
      <?php endif; ?>
    </div>

    <?php if ( $cards ) : ?>
      <div class="ldw-crmp-benefits-grid">
        <?php foreach ( $cards as $i => $card ) : ?>
          <?php $img = $card['image']; $has = ( is_array( $img ) && ! empty( $img['url'] ) ); ?>
          <div class="ldw-crmp-benefit<?php echo $has ? ' ldw-crmp-benefit--split' : ''; ?><?php echo ( $i % 2 ) ? ' ldw-crmp-benefit--flip' : ''; ?>">
            <?php if ( $has ) : ?>
              <div class="ldw-crmp-benefit-media">
                <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( (string) ( $i + 1 ) ); ?>" loading="lazy" decoding="async">
              </div>
            <?php else : ?>
              <span class="ldw-crmp-benefit-num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
            <?php endif; ?>
            <div class="ldw-crmp-benefit-copy">
              <h3 class="ldw-crmp-benefit-title"><?php echo esc_html( ( $i + 1 ) . '. ' . $card['title'] ); ?></h3>
              <?php if ( $card['text'] ) : ?>
                <p class="ldw-crmp-benefit-text"><?php echo esc_html( $card['text'] ); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</div>
