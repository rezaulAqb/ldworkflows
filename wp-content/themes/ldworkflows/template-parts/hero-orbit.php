<?php
/**
 * Hero section with the static "orbit" flow-card diagram.
 * Hero text/heading comes from ACF Options (Theme Content > Hero Section).
 * Orbit cards come from the "Flow Card" CPT (Theme Content links to it),
 * ordered by each post's manual Order field.
 */

$heading       = get_field( 'hero_heading', 'option' ) ?: 'One ERP at the centre. Every flow';
$highlight     = get_field( 'hero_heading_highlight', 'option' ) ?: 'around it';
$subtext       = get_field( 'hero_subtext', 'option' );
$cta_primary   = get_field( 'hero_cta_primary_text', 'option' ) ?: 'Book a demo';
$cta_primary_url = get_field( 'hero_cta_primary_url', 'option' ) ?: '#contact';
$cta_secondary = get_field( 'hero_cta_secondary_text', 'option' );
$cta_secondary_url = get_field( 'hero_cta_secondary_url', 'option' ) ?: '#';
$trust_items   = array_values( array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'hero_trust_items', 'option' ) ) ) ) );
$core_title    = get_field( 'orbit_core_title', 'option' ) ?: 'ERP';
$core_subtitle = get_field( 'orbit_core_subtitle', 'option' ) ?: 'One platform';
$cards         = ldw_get_flow_cards();
$total         = count( $cards );

$desktop_r     = 260;
$desktop_width = 161.6;
$mobile_r      = 84;
$mobile_width  = 64;
?>
<section data-screen-label="Hero" class="ldw-hero">
  <div class="ldw-hero-blobs" aria-hidden="true">
    <div class="ldw-blob ldw-blob-a"></div>
    <div class="ldw-blob ldw-blob-b"></div>
    <div class="ldw-blob ldw-blob-c"></div>
    <div class="ldw-blob ldw-blob-d"></div>
    <div class="ldw-hero-dots"></div>
  </div>

  <div class="ldw-hero-copy">
    <h1 class="ldw-hero-heading">
      <?php echo esc_html( $heading ); ?>
      <em class="ldw-hero-highlight"><?php echo esc_html( $highlight ); ?></em>.
    </h1>
    <?php if ( $subtext ) : ?>
      <p class="ldw-hero-subtext"><?php echo esc_html( $subtext ); ?></p>
    <?php endif; ?>

    <div class="ldw-cta-row">
      <a href="<?php echo esc_url( $cta_primary_url ); ?>"<?php echo ldw_link_target_attrs( $cta_primary_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-btn-primary"><?php echo esc_html( $cta_primary ); ?></a>
      <?php if ( $cta_secondary ) : ?>
        <a href="<?php echo esc_url( $cta_secondary_url ); ?>"<?php echo ldw_link_target_attrs( $cta_secondary_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped attribute string. ?> class="ldw-btn-text"><?php echo esc_html( $cta_secondary ); ?> <span>&rarr;</span></a>
      <?php endif; ?>
    </div>

    <?php if ( $trust_items ) : ?>
      <div class="ldw-trust-row">
        <?php foreach ( $trust_items as $i => $item ) : ?>
          <?php if ( $i > 0 ) : ?><span class="ldw-trust-sep"></span><?php endif; ?>
          <span><?php echo esc_html( $item ); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="ldw-orbit">
    <div class="ldw-orbit-circle">
      <div class="ldw-orbit-disc" aria-hidden="true"></div>
      <svg viewBox="0 0 660 660" preserveAspectRatio="xMidYMid meet" aria-hidden="true" class="ldw-orbit-rings">
        <circle cx="330" cy="330" r="150" fill="none" stroke="#234C5A" stroke-width="1.4" opacity="0.32" stroke-linecap="round" stroke-dasharray="2 9"></circle>
        <circle cx="330" cy="330" r="210" fill="none" stroke="#234C5A" stroke-width="1.4" opacity="0.26" stroke-linecap="round" stroke-dasharray="2 9"></circle>
        <circle cx="330" cy="330" r="262" fill="none" stroke="#234C5A" stroke-width="1.3" opacity="0.2" stroke-linecap="round" stroke-dasharray="2 9"></circle>
        <circle cx="330" cy="330" r="308" fill="none" stroke="#234C5A" stroke-width="1.2" opacity="0.16" stroke-linecap="round" stroke-dasharray="2 9"></circle>
        <circle cx="330" cy="330" r="150" fill="none" stroke="#E15A58" stroke-width="2.6" stroke-linecap="round" stroke-dasharray="150 793" style="animation: ldw-arc-a 14s linear infinite"></circle>
        <circle cx="330" cy="330" r="210" fill="none" stroke="#3E9994" stroke-width="2.6" stroke-linecap="round" stroke-dasharray="210 1110" style="animation: ldw-arc-b 22s linear infinite reverse"></circle>
        <circle cx="330" cy="330" r="262" fill="none" stroke="#EC956C" stroke-width="2.4" stroke-linecap="round" stroke-dasharray="260 1387" style="animation: ldw-arc-c 30s linear infinite"></circle>
        <circle cx="330" cy="330" r="308" fill="none" stroke="#65BB99" stroke-width="2.2" stroke-linecap="round" stroke-dasharray="300 1635" style="animation: ldw-arc-d 38s linear infinite reverse"></circle>
      </svg>

      <div class="ldw-orbit-halo" aria-hidden="true"></div>
      <div class="ldw-orbit-core">
        <div>
          <div class="ldw-orbit-core-title"><?php echo esc_html( $core_title ); ?></div>
          <div class="ldw-orbit-core-subtitle"><?php echo esc_html( $core_subtitle ); ?></div>
        </div>
      </div>

      <?php
      $duration = 48; // seconds for one full revolution
      foreach ( $cards as $i => $card ) :
        $delay = -1 * $duration * $i / max( 1, $total );
        ?>
        <div class="ldw-orbit-pivot" style="animation-delay: <?php echo esc_attr( $delay ); ?>s">
          <div class="ldw-orbit-arm">
            <div class="ldw-orbit-counter" style="animation-delay: <?php echo esc_attr( $delay ); ?>s">
              <div class="ldw-orbit-node"
                   style="
                     width: <?php echo esc_attr( $desktop_width ); ?>px;
                     --ldw-mobile-width: <?php echo esc_attr( $mobile_width ); ?>px;
                   ">
                <div class="ldw-orbit-node-row">
                  <span class="ldw-orbit-node-icon" style="background: <?php echo esc_attr( $card['tint'] ); ?>">
                    <?php ldw_the_orbit_icon( $card['icon'], 13 ); ?>
                  </span>
                  <span class="ldw-orbit-node-title"><?php echo esc_html( $card['title'] ); ?></span>
                </div>
                <div class="ldw-orbit-node-steps"><?php echo esc_html( $card['steps'] ); ?></div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="ldw-hero-bar" aria-hidden="true">
    <span style="background:#59ADA8"></span><span style="background:#65BB99"></span><span style="background:#F6CC9F"></span><span style="background:#EC956C"></span><span style="background:#E15A58"></span><span style="background:#F0C4B4"></span>
  </div>
</section>
