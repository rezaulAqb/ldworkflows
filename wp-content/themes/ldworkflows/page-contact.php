<?php
/**
 * Contact page template — WP's template hierarchy auto-selects this file
 * for the page with slug "contact".
 *
 * The page is this site's header and footer wrapped around the enquiry
 * form that already lives in the CRM, so enquiries land where the team
 * already works rather than in a second inbox. The form is fetched and
 * forwarded server-side — see inc/contact-proxy.php for why it cannot be
 * an iframe.
 */

get_header();

get_template_part( 'template-parts/contact-form', null, array( 'label' => 'Contact form' ) );

get_footer();
