<?php
// Enable post thumbnails
function mytheme_setup()
{
    add_theme_support('post-thumbnails', array('post'));
}
add_action('after_setup_theme', 'mytheme_setup');

// Enqueue Google Fonts (Roboto)
function mytheme_enqueue_fonts()
{
    wp_enqueue_style(
        'nunito-font',
        'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_fonts');

// Enqueue CSS & JS
function mytheme_enqueue_assets()
{
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_stylesheet_directory() . '/style.css') // cache-busting
    );
    wp_enqueue_script(
        'mytheme-script',
        get_template_directory_uri() . '/script.js',
        array(),
        filemtime(get_template_directory() . '/script.js'), // cache-busting
        true // load in footer
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');
