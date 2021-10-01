<?php
// Enqueue Scripts and CSS Files
function enqueueFiles()
{
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.22');
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/custom.js',  array(), '1.22');
}
add_action('wp_enqueue_scripts', 'enqueueFiles');

// Enable Featured Images
add_theme_support('post-thumbnails');

//Register nav
register_nav_menus(array(
    'primarymenu' => __('Primary Menu', 'primarymenu'),
    'footermenu' => __('Footer Menu', 'footermenu'),
));

//Custom logo
add_theme_support('custom-logo');
