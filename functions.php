<?php
if (!defined('ABSPATH')) { exit; }

define('SMP_VERSION', '1.1.0');
define('SMP_DIR', get_template_directory());
define('SMP_URI', get_template_directory_uri());

require_once SMP_DIR . '/inc/defaults.php';
require_once SMP_DIR . '/inc/post-types.php';
require_once SMP_DIR . '/inc/customizer.php';
require_once SMP_DIR . '/inc/seed-content.php';

function smp_setup(): void {
    load_theme_textdomain('shakeel-portfolio', SMP_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', ['height' => 80, 'width' => 80, 'flex-height' => true, 'flex-width' => true]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('elementor');
    register_nav_menus(['primary' => __('Primary navigation', 'shakeel-portfolio')]);
}
add_action('after_setup_theme', 'smp_setup');

function smp_assets(): void {
    wp_enqueue_style('smp-theme', SMP_URI . '/assets/css/theme.css', [], SMP_VERSION);
    wp_enqueue_script('smp-theme', SMP_URI . '/assets/js/theme.js', [], SMP_VERSION, true);
    wp_localize_script('smp-theme', 'smpData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('smp_contact'),
        'messages' => [
            'sending' => __('Sending…', 'shakeel-portfolio'),
            'success' => __('Thank you. Your message has been sent.', 'shakeel-portfolio'),
            'error' => __('The message could not be sent. Please email me directly.', 'shakeel-portfolio'),
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'smp_assets');

function smp_asset(string $path): string { return esc_url(SMP_URI . '/assets/' . ltrim($path, '/')); }
function smp_mod(string $key): string { $d = smp_theme_defaults(); return (string) get_theme_mod($key, $d[$key] ?? ''); }

function smp_primary_menu_fallback(): void {
    $links = ['about' => 'About', 'services' => 'Services', 'portfolio' => 'Portfolio', 'julefabrikken' => 'Magento Modules', 'experience' => 'Experience', 'resumes' => 'Resumes'];
    echo '<div id="main-nav" class="nav-links" aria-label="' . esc_attr__('Main navigation', 'shakeel-portfolio') . '">';
    foreach ($links as $id => $label) echo '<a href="#' . esc_attr($id) . '">' . esc_html($label) . '</a>';
    echo '<a class="button button-small" href="#contact">' . esc_html__('Hire Me', 'shakeel-portfolio') . '</a></div>';
}

function smp_contact_submit(): void {
    check_ajax_referer('smp_contact', 'nonce');
    if (!empty($_POST['website'])) wp_send_json_error();
    $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $project = sanitize_text_field(wp_unslash($_POST['project'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
    if (!$name || !is_email($email) || !$message) wp_send_json_error();
    $to = sanitize_email(smp_mod('contact_email')) ?: get_option('admin_email');
    $subject = sprintf(__('Portfolio enquiry from %s', 'shakeel-portfolio'), $name);
    $body = "Name: {$name}\nEmail: {$email}\nProject: {$project}\n\n{$message}";
    $headers = ['Reply-To: ' . $name . ' <' . $email . '>'];
    wp_mail($to, $subject, $body, $headers) ? wp_send_json_success() : wp_send_json_error();
}
add_action('wp_ajax_smp_contact', 'smp_contact_submit');
add_action('wp_ajax_nopriv_smp_contact', 'smp_contact_submit');

function smp_elementor_locations($manager): void {
    if (is_object($manager) && method_exists($manager, 'register_all_core_location')) $manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'smp_elementor_locations');
