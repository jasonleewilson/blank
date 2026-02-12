<?php

add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
    add_editor_style('dist/assets/tailwind.css');
});

add_action('wp_enqueue_scripts', function () {

    $is_dev = defined('WP_DEBUG') && WP_DEBUG;

    // Dev mode: load directly from Vite dev server
    if ($is_dev) {
        wp_enqueue_script(
            'vite',
            'http://localhost:5173/src/js/main.js',
            [],
            null,
            true
        );
        wp_enqueue_style(
            'vite-tailwind',
            'http://localhost:5173/src/css/tailwind.css',
            [],
            null
        );

    } else {
        // Build mode: read manifest.json safely
        $manifest_path = get_template_directory() . '/dist/manifest.json';

        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
        } else {
            $manifest = [];
        }

        // Enqueue CSS
        if (isset($manifest['src/css/tailwind.css']['file'])) {
            wp_enqueue_style(
                'theme',
                get_theme_file_uri('dist/' . $manifest['src/css/tailwind.css']['file']),
                [],
                null
            );
        }

        // Enqueue JS
        if (isset($manifest['src/js/main.js']['file'])) {
            wp_enqueue_script(
                'theme',
                get_theme_file_uri('dist/' . $manifest['src/js/main.js']['file']),
                [],
                null,
                true
            );
        }
    }
});
