# Shakeel Mureed Portfolio WordPress Theme

## Installation

1. In WordPress, open **Appearance → Themes → Add New → Upload Theme**.
2. Upload `shakeel-mureed-portfolio-theme.zip`, install it and activate it.
3. The theme automatically creates the included Projects, Services, Magento Modules and Experience items once. Existing content is never overwritten.
4. Open **Appearance → Customize → Portfolio Content** to edit the hero, About text, headings, contact information, portrait and footer.

Version 1.1 adds the EGO Shoes multi-store campaign case study and refreshed Magento/general résumé PDFs. Its bundled visual is an explanatory workflow diagram; the current third-party storefront is not represented as Shakeel's implementation.

## Editing content

- **Projects:** edit project cards, case-study content, tags, URLs, highlights and featured images.
- **Services:** add, reorder, edit or remove service cards.
- **Magento Modules:** maintain the Julefabrikken engineering section.
- **Experience:** maintain job history and descriptions.
- **Appearance → Customize:** edit global section headings, hero, proof points, About, contact and footer.
- **Media → Library:** upload a new portrait or project image; select it through the Customizer or Featured Image control.

Use the **Order** field in the Page Attributes panel to reorder repeatable cards. Lower values appear first.

## Elementor

Elementor is optional. The theme includes Elementor Full Width and Elementor Canvas page templates and registers Elementor theme locations. The portfolio homepage intentionally uses lightweight native templates for maximum speed and exact design consistency. Elementor can be used for new landing pages without changing the portfolio homepage.

## Performance

- No external fonts, icon libraries, page-builder scripts or frontend framework.
- One small stylesheet and one deferred JavaScript file.
- Local optimized project assets and résumé files.
- WordPress responsive featured images are supported when images are replaced through Media Library.
- Compatible with normal page caching, object caching and image optimization plugins.

## Contact form

The form uses WordPress `wp_mail()`, AJAX nonces, sanitization and a honeypot field. Configure a reliable SMTP plugin on production so messages are delivered consistently.

## Important

The theme requires PHP 8.0+ and WordPress 6.4+. Back up the current site before activating any new theme.
