<?php
if (!defined('ABSPATH')) { exit; }

function smp_customize(WP_Customize_Manager $wp): void {
    $wp->add_panel('smp_portfolio', ['title' => __('Portfolio Content', 'shakeel-portfolio'), 'priority' => 20]);
    $groups = [
        'hero' => ['Hero', ['hero_eyebrow','hero_title','hero_highlight','hero_lead','hero_primary_label','hero_secondary_label','proof_one','proof_two','proof_three']],
        'about' => ['About', ['about_heading','about_lead','about_body']],
        'sections' => ['Section Headings', ['services_heading','services_intro','portfolio_heading','portfolio_intro','modules_heading','modules_intro','experience_heading','experience_intro']],
        'contact' => ['Contact & Footer', ['contact_heading','contact_intro','contact_email','contact_phone','contact_location','linkedin_url','footer_text']],
    ];
    $defaults = smp_theme_defaults();
    foreach ($groups as $id => [$title, $fields]) {
        $wp->add_section('smp_' . $id, ['title' => $title, 'panel' => 'smp_portfolio']);
        foreach ($fields as $field) {
            $wp->add_setting($field, ['default' => $defaults[$field], 'sanitize_callback' => in_array($field, ['about_body'], true) ? 'sanitize_textarea_field' : ($field === 'contact_email' ? 'sanitize_email' : ($field === 'linkedin_url' ? 'esc_url_raw' : 'sanitize_text_field')), 'transport' => 'refresh']);
            $wp->add_control($field, ['section' => 'smp_' . $id, 'label' => ucwords(str_replace('_', ' ', $field)), 'type' => in_array($field, ['hero_lead','about_body','services_intro','portfolio_intro','modules_intro','experience_intro','contact_intro','footer_text'], true) ? 'textarea' : 'text']);
        }
    }
    $wp->add_setting('hero_portrait', ['sanitize_callback' => 'absint']);
    $wp->add_control(new WP_Customize_Media_Control($wp, 'hero_portrait', ['section' => 'smp_hero', 'label' => __('Hero portrait', 'shakeel-portfolio'), 'mime_type' => 'image']));
}
add_action('customize_register', 'smp_customize');
