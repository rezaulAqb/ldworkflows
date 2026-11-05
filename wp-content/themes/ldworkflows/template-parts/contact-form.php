<?php
/**
 * The CRM enquiry form, rendered inline by inc/contact-proxy.php.
 *
 * See that file for why this is proxied rather than framed.
 *
 * The wrapper carries .ldcf-page as well as our own class because the
 * CRM's rules are mostly descendant selectors off .ldcf-page, and the
 * fragment we render is the inside of that element.
 *
 * The two small behaviours below are reimplemented from the CRM page's own
 * script, which is stripped on the way through: it also carried that
 * site's Google Analytics, which should not run on this domain.
 */

$state = ldw_contact_state();

if ( ! $state['fragment'] && ! $state['error'] ) {
	return;
}
?>
<section data-screen-label="<?php echo esc_attr( ! empty( $args['label'] ) ? $args['label'] : 'Contact form' ); ?>" class="ldw-contact-form ldcf-page">
  <?php if ( $state['error'] ) : ?>
    <p class="ldw-contact-error"><?php echo esc_html( $state['error'] ); ?></p>
  <?php endif; ?>

  <?php
  // The CRM's own markup. Not escaped on purpose: it is fetched from the
  // configured CRM URL and already stripped of scripts in
  // ldw_contact_fragment().
  echo $state['fragment']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  ?>
</section>
<?php if ( $state['fragment'] ) : ?>
<script>
(function () {
  ['id_telephone_0', 'id_telephone_1'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) { el.classList.remove('tel-area'); el.classList.add('ldcf-input'); }
  });

  var message = document.getElementById('id_enquiry');
  var counter = document.getElementById('ldcf-message-counter');
  if (message && counter) {
    var max = message.getAttribute('maxlength') || 2000;
    var update = function () { counter.textContent = message.value.length + '/' + max; };
    message.addEventListener('input', update);
    update();
  }
})();
</script>
<?php endif; ?>
