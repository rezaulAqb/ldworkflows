<?php
/**
 * Blog archive — the full Resources listing. Reuses the same bento card
 * styling as the homepage section so the two read as one library.
 */

get_header();
?>
<div class="ldw-page">
  <div class="ldw-page-inner">
    <header class="ldw-page-header">
      <h1 class="ldw-page-title">
        <?php
        if ( is_category() || is_tag() || is_archive() ) {
          the_archive_title();
        } elseif ( is_search() ) {
          printf( 'Search: %s', esc_html( get_search_query() ) );
        } else {
          echo esc_html( get_field( 'res_heading', 'option' ) ?: 'Resources' );
        }
        ?>
      </h1>
      <?php $sub = get_field( 'res_subtext', 'option' ); ?>
      <?php if ( $sub && ! is_archive() && ! is_search() ) : ?>
        <p class="ldw-page-sub"><?php echo esc_html( $sub ); ?></p>
      <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>
      <div class="ldw-res-grid">
        <?php
        while ( have_posts() ) :
          the_post();
          $tint  = get_field( 'resource_tint' ) ?: '#FDF3E8';
          $cats  = get_the_category();
          $tag   = $cats ? $cats[0]->name : '';
          ?>
          <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>" class="ldw-res-card ldw-res-card--image" style="--cols:1;--rows:1;--band:42%;">
              <div class="ldw-res-card-media"><?php the_post_thumbnail( 'ldw-resource', array( 'alt' => '' ) ); ?></div>
              <div class="ldw-res-card-veil" aria-hidden="true"></div>
              <?php if ( $tag ) : ?><span class="ldw-res-tag"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
              <div class="ldw-res-card-body">
                <h2 class="ldw-res-card-title"><?php the_title(); ?></h2>
                <span class="ldw-res-card-cta">Read more <span aria-hidden="true">&rarr;</span></span>
              </div>
            </a>
          <?php else : ?>
            <a href="<?php the_permalink(); ?>" class="ldw-res-card ldw-res-card--text" style="--cols:1;--rows:1;background:<?php echo esc_attr( $tint ); ?>;">
              <?php if ( $tag ) : ?><span class="ldw-res-card-kicker"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
              <h2 class="ldw-res-card-heading"><?php the_title(); ?></h2>
              <p class="ldw-res-card-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
              <span class="ldw-res-card-arrow" aria-hidden="true">&rarr;</span>
            </a>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>

      <div class="ldw-pagination"><?php echo wp_kses_post( paginate_links( array( 'type' => 'list' ) ) ?: '' ); ?></div>
    <?php else : ?>
      <p class="ldw-page-sub">No resources published yet.</p>
    <?php endif; ?>
  </div>
</div>
<?php
get_footer();
