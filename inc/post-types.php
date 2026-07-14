<?php
if (!defined('ABSPATH')) { exit; }

function smp_register_content_types(): void {
    $types = [
        'smp_project' => ['Projects','Project','dashicons-portfolio',['title','editor','excerpt','thumbnail','page-attributes']],
        'smp_service' => ['Services','Service','dashicons-admin-tools',['title','editor','page-attributes']],
        'smp_module' => ['Magento Modules','Magento Module','dashicons-admin-plugins',['title','editor','page-attributes']],
        'smp_experience' => ['Experience','Experience Item','dashicons-businessperson',['title','editor','page-attributes']],
    ];
    foreach ($types as $slug => $data) register_post_type($slug, [
        'labels' => ['name' => $data[0], 'singular_name' => $data[1], 'add_new_item' => 'Add New ' . $data[1], 'edit_item' => 'Edit ' . $data[1]],
        'public' => $slug === 'smp_project', 'publicly_queryable' => $slug === 'smp_project', 'show_ui' => true,
        'show_in_rest' => true, 'menu_icon' => $data[2], 'supports' => $data[3], 'has_archive' => false,
        'rewrite' => $slug === 'smp_project' ? ['slug' => 'project'] : false,
    ]);
}
add_action('init', 'smp_register_content_types');

function smp_meta_boxes(): void {
    foreach (['smp_project','smp_service','smp_module','smp_experience'] as $type) add_meta_box('smp_details', __('Portfolio display details', 'shakeel-portfolio'), 'smp_meta_box', $type, 'normal', 'high');
}
add_action('add_meta_boxes', 'smp_meta_boxes');

function smp_meta_box(WP_Post $post): void {
    wp_nonce_field('smp_meta_save', 'smp_meta_nonce');
    $fields = ['subtitle' => 'Subtitle / company', 'period' => 'Period', 'tags' => 'Tags (comma separated)', 'website' => 'Website URL', 'asset' => 'Bundled image path', 'bullets' => 'Highlights (one per line)'];
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, '_smp_' . $key, true);
        echo '<p><label for="smp_' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label><br>';
        if ($key === 'bullets') echo '<textarea class="widefat" rows="5" id="smp_' . esc_attr($key) . '" name="smp_' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
        else echo '<input class="widefat" type="text" id="smp_' . esc_attr($key) . '" name="smp_' . esc_attr($key) . '" value="' . esc_attr($value) . '"></p>';
    }
    echo '<p>' . esc_html__('Use the main editor for the description or complete project case study. Use Featured Image to replace a bundled project image.', 'shakeel-portfolio') . '</p>';
}

function smp_save_meta(int $post_id): void {
    if (!isset($_POST['smp_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['smp_meta_nonce'])), 'smp_meta_save') || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !current_user_can('edit_post', $post_id)) return;
    foreach (['subtitle','period','tags','website','asset','bullets'] as $key) {
        $value = wp_unslash($_POST['smp_' . $key] ?? '');
        update_post_meta($post_id, '_smp_' . $key, $key === 'website' ? esc_url_raw($value) : sanitize_textarea_field($value));
    }
}
add_action('save_post', 'smp_save_meta');

function smp_items(string $type): WP_Query { return new WP_Query(['post_type' => $type, 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC']]); }

