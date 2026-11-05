<?php
/**
 * Shared page hero (Pricing, CRM). Content from ACF Options; which set of
 * fields is read depends on $args['prefix'], so one markup/CSS definition
 * serves every page that needs this hero shape.
 */

$prefix = ! empty( $args['prefix'] ) ? $args['prefix'] : 'pricing_hero';

$is_pricing = ( 'pricing_hero' === $prefix );
$eyebrow   = get_field( "{$prefix}_eyebrow", 'option' ) ?: ( $is_pricing ? 'Pricing & plans' : '' );
$heading   = get_field( "{$prefix}_heading", 'option' ) ?: ( $is_pricing ? 'Everything from Shopify order to VAT return.' : '' );
$highlight = get_field( "{$prefix}_highlight", 'option' ) ?: ( $is_pricing ? 'No enterprise price tag.' : '' );
$subtext   = get_field( "{$prefix}_subtext", 'option' );
$primary   = get_field( "{$prefix}_primary_text", 'option' ) ?: ( $is_pricing ? 'Start free trial' : '' );
$prim_url  = get_field( "{$prefix}_primary_url", 'option' ) ?: '#plans';
$secondary = get_field( "{$prefix}_secondary_text", 'option' ) ?: ( $is_pricing ? 'Book a demo' : '' );
$hero_image = get_field( "{$prefix}_image", 'option' );
$sec_url   = get_field( "{$prefix}_secondary_url", 'option' ) ?: '#contact';
?>
<section data-screen-label="<?php echo esc_attr( ! empty( $args['label'] ) ? $args['label'] : 'Pricing hero' ); ?>" class="ldw-pricing-hero">
  <div class="ldw-hero-blobs" aria-hidden="true">
    <div class="ldw-blob ldw-blob-a"></div>
    <div class="ldw-blob ldw-blob-b"></div>
    <div class="ldw-blob ldw-blob-c"></div>
    <div class="ldw-blob ldw-blob-d"></div>
    <div class="ldw-hero-dots"></div>
  </div>

  <div class="ldw-pricing-hero-inner">
    <?php if ( $eyebrow ) : ?><span class="ldw-pricing-eyebrow"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
    <h1 class="ldw-pricing-heading"><?php echo esc_html( $heading ); ?></h1>
    <?php if ( $highlight ) : ?>
      <div class="ldw-pricing-highlight"><?php echo esc_html( $highlight ); ?></div>
    <?php endif; ?>
    <?php if ( $subtext ) : ?>
      <p class="ldw-pricing-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>
    <div class="ldw-cta-row">
      <?php if ( $primary ) : ?>
      <a href="<?php echo esc_url( $prim_url ); ?>"<?php echo ldw_link_target_attrs( $prim_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-btn-primary"><?php echo esc_html( $primary ); ?></a>
      <?php endif; ?>
      <?php if ( $secondary ) : ?>
        <a href="<?php echo esc_url( $sec_url ); ?>"<?php echo ldw_link_target_attrs( $sec_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-btn-ghost"><?php echo esc_html( $secondary ); ?></a>
      <?php endif; ?>
    </div>

    <?php if ( is_array( $hero_image ) && ! empty( $hero_image['url'] ) ) : ?>
      <div class="ldw-pricing-hero-media">
        <img src="<?php echo esc_url( $hero_image['url'] ); ?>"
             alt="<?php echo esc_attr( ! empty( $hero_image['alt'] ) ? $hero_image['alt'] : (string) $heading ); ?>"
             loading="eager" decoding="async">
      </div>
    <?php endif; ?>
  </div>
</section>
