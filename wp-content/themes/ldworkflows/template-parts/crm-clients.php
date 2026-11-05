<?php
/**
 * "Trusted and loved by the world's best teams" client logo strip.
 * Heading from ACF Options (Theme Content > CRM Social Proof); the logos
 * from the CRM Client CPT. Hidden entirely until a logo is uploaded, so
 * the page never shows a heading over an empty row.
 */

$heading = get_field( 'crm_clients_heading', 'option' );
$subtext = get_field( 'crm_clients_subtext', 'option' );
$clients = ldw_get_crm_clients();

if ( ! $clients ) {
	return;
}
?>
<section data-screen-label="CRM social proof" class="ldw-crmp-clients">
  <div class="ldw-crmp-clients-inner">
    <?php if ( $heading ) : ?>
      <h2 class="ldw-crmp-clients-heading"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>
    <?php if ( $subtext ) : ?>
      <p class="ldw-crmp-clients-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>

    <div class="ldw-crmp-clients-row">
      <?php foreach ( $clients as $client ) : ?>
        <div class="ldw-crmp-client">
          <img src="<?php echo esc_url( $client['url'] ); ?>" alt="<?php echo esc_attr( $client['name'] ); ?>" loading="lazy" decoding="async">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
