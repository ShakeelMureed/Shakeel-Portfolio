<?php
if (!defined('ABSPATH')) { exit; }

function smp_insert_item(string $type, string $title, string $content, int $order, array $meta = []): void {
    $existing = get_page_by_title($title, OBJECT, $type);
    if ($existing) return;
    $id = wp_insert_post(['post_type' => $type, 'post_status' => 'publish', 'post_title' => $title, 'post_content' => $content, 'post_excerpt' => wp_trim_words(wp_strip_all_tags($content), 28), 'menu_order' => $order]);
    if (!is_wp_error($id)) foreach ($meta as $key => $value) update_post_meta($id, '_smp_' . $key, $value);
}

function smp_seed_content(): void {
    smp_register_content_types();
    foreach (smp_default_services() as $i => $x) smp_insert_item('smp_service', $x[0], $x[1], $i, ['bullets' => $x[2]]);
    foreach (smp_default_modules() as $i => $x) smp_insert_item('smp_module', $x[1], $x[2], $i, ['subtitle' => $x[0], 'bullets' => $x[3]]);
    foreach (smp_default_experience() as $i => $x) smp_insert_item('smp_experience', $x[0], $x[3], $i, ['period' => $x[1], 'subtitle' => $x[2]]);
    foreach (smp_default_projects() as $i => $x) smp_insert_item('smp_project', $x[0], '<p>' . esc_html($x[4]) . '</p><h2>Project highlights</h2><ul><li>' . implode('</li><li>', array_map('esc_html', explode("\n", $x[5]))) . '</li></ul>', $i, ['tags' => $x[1], 'website' => $x[2], 'asset' => $x[3], 'bullets' => $x[5]]);
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'smp_seed_content');

function smp_seed_theme_updates(): void {
    if (get_option('smp_content_version') === SMP_VERSION) return;
    smp_seed_content();
    update_option('smp_content_version', SMP_VERSION, false);
}
add_action('admin_init', 'smp_seed_theme_updates');
