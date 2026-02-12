<?php

add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
    add_editor_style('dist/assets/tailwind.css');
});

add_filter('script_loader_tag', function ($tag, $handle) {
    if (in_array($handle, ['vite', 'vite-main'])) {
        return str_replace(' src', ' type="module" src', $tag);
    }
    return $tag;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {

    $is_dev = defined('WP_DEBUG') && WP_DEBUG;

    // Dev mode: load from Vite dev server (CSS is imported via main.js for HMR)
    if ($is_dev) {
        wp_enqueue_script(
            'vite',
            'http://localhost:5173/@vite/client',
            [],
            null,
            true
        );
        wp_enqueue_script(
            'vite-main',
            'http://localhost:5173/src/js/main.js',
            [],
            null,
            true
        );

    } else {
        // Production build: enqueue from manifest
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);

            if (isset($manifest['src/css/tailwind.css']['file'])) {
                wp_enqueue_style(
                    'theme-tailwind',
                    get_theme_file_uri('dist/' . $manifest['src/css/tailwind.css']['file']),
                    [],
                    null
                );
            }

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
    }
});
