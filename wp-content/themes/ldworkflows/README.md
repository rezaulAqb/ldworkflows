# LD Workflows theme

Custom WordPress theme for the LD Workflows marketing site, built from the
Design Composer mockups. Every piece of page copy is editable from wp-admin.

## Requirements

| | |
|---|---|
| WordPress | 6.0+ |
| PHP | 7.4+ |
| **Advanced Custom Fields Pro** | **required** |

ACF Pro is a hard dependency, not an enhancement. All section copy is read
with `get_field()`, so without it the pages render their markup with no text.
The plugin is not in this repository — it is third-party and licensed — so
install it separately. The theme shows an admin notice while it is missing.

## Install

1. Clone into `wp-content/themes/ldworkflows`.
2. Install and activate ACF Pro.
3. Activate the theme. On activation it seeds the primary and footer menus,
   pointing each item at the matching page where one exists.
4. Set a static front page (Settings > Reading) if the home page is not
   already the front page.

## Where the content lives

**Not in this repository.** Page copy is in the database, so a fresh clone
renders the templates with their seed defaults only. Moving the site means
migrating the database and `wp-content/uploads`, or re-entering the content.

| Content | Managed in |
|---|---|
| Section copy for every page | **Theme Content** menu (ACF options screens, one per section) |
| Repeating cards (benefits, plans, FAQs, comparison rows) | Their own custom post types |
| Resources / blog cards | Ordinary posts |
| Policy pages | The page editor, on the Legal page template |
| Navigation | Appearance > Menus (Primary and Footer locations) |

## Templates

Page templates follow WordPress's hierarchy: `page-{slug}.php` is picked up
automatically, so `page-crm.php` serves `/crm/`.

The templates are prefix-driven. One hero, checklist, benefits and CTA part
serve every page; `$args['prefix']` selects the ACF field set and
`$args['post_type']` the CPT behind the cards:

```php
get_template_part( 'template-parts/pricing-hero', null, array(
    'prefix' => 'o2c_hero',
    'label'  => 'Order to cash hero',
) );
```

Adding a page is mostly content entry, not new markup.

`template-legal.php` ("Legal page") is the exception: it renders the page's
own editor content rather than ACF fields, because a policy is one continuous
document. Assign it under Page Attributes > Template. It is used by Terms of
Service, Cookies Policy and Privacy Policy.

## Notes

- **Responsive rules are `@media`, not `@container`.** Container queries
  silently do nothing on Safari 15 / iOS 15 and older, which served those
  devices the full desktop layout at phone width. Keep new breakpoints as
  `@media`.
- **The contact form is proxied server-side** (`inc/contact-proxy.php`), not
  framed. The CRM's CSRF cookie is `SameSite=Lax`, so an iframe renders but
  can never submit. Set the form URL under Theme Content > Contact Form Embed.
