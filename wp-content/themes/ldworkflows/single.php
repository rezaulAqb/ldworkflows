<?php
/**
 * Single resource article.
 */

get_header();
?>
<div class="ldw-page">
  <div class="ldw-page-inner">
    <?php
    while ( have_posts() ) :
      the_post();
      $cats = get_the_category();
      ?>
      <article class="ldw-post">
        <header class="ldw-page-header">
          <?php if ( $cats ) : ?>
            <span class="ldw-res-card-kicker"><?php echo esc_html( $cats[0]->name ); ?></span>
          <?php endif; ?>
          <h1 class="ldw-page-title"><?php the_title(); ?></h1>
          <div class="ldw-post-meta"><?php echo esc_html( get_the_date() ); ?></div>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
          <div class="ldw-post-hero"><?php the_post_thumbnail( 'large' ); ?></div>
        <?php endif; ?>

        <div class="ldw-post-body"><?php the_content(); ?></div>

        <a class="ldw-post-back" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">
          <span aria-hidden="true">&larr;</span> All resources
        </a>
      </article>
    <?php endwhile; ?>
  </div>
</div>
<?php
get_footer();
