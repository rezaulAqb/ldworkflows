<?php
/**
 * Template Name: Legal page
 *
 * Long-form policy pages: Terms of Service, and the Privacy and Cookies
 * policies when they exist. Assign it in the page editor under Page
 * Attributes > Template.
 *
 * Unlike the marketing pages, the body is the page's own editor content
 * rather than ACF options. A policy is one continuous document that gets
 * replaced wholesale whenever it is revised, so the normal editor is a
 * better fit than two dozen option fields — and it keeps revision
 * history, which matters for a document with a version date on it.
 */

get_header();

$show_resources = false;

while ( have_posts() ) :
	the_post();
	$show_resources = (bool) get_field( 'legal_show_resources' );
	?>
  <section data-screen-label="Legal hero" class="ldw-legal-hero">
    <div class="ldw-legal-hero-inner">
      <h1 class="ldw-legal-hero-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <section data-screen-label="Legal body" class="ldw-legal-body">
    <div class="ldw-legal-inner">
      <?php the_content(); ?>
    </div>
  </section>
	<?php
endwhile;

// Read inside the loop above: by here the loop has ended and the global
// post is no longer a reliable context for get_field().
if ( $show_resources ) {
	get_template_part( 'template-parts/resources', null, array( 'label' => 'Resources' ) );
}

get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'legal_final_cta' ) );

get_footer();
