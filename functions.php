<?php

// Enqueue Scripts and CSS Files
function enqueueFiles() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'style-css', get_template_directory_uri() . '/src/css/styles.css');
}
add_action( 'wp_enqueue_scripts', 'enqueueFiles' );

// Enable Featured Images
add_theme_support( 'post-thumbnails' );

// Add custom widgets to the dashboard.
function milo_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'milo_documentation_widget', // Widget slug.
		'Website Documentation', // Title.
		'milo_documentation_dashboard_widget' // Display function.
	);
	wp_add_dashboard_widget(
		'milo_contact_widget', // Widget slug.
		'Technical Support', // Title.
		'milo_contact_dashboard_widget' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'milo_add_dashboard_widgets' );

// Create Documentation admin widget
function milo_documentation_dashboard_widget() {
	echo "
  <a target='_blank' href='https://docs.google.com/document/d/1fgOr3NEM_V0p6sdZhvzCieJHtaANIuDTRAm1QfH5_9s/edit?usp=sharing'>Google Doc</a> (only editable by Milo Media)
  <br>
  <a target='_blank' href='https://drive.google.com/file/d/1KGrgKyR5gTX6s7VEjlLAukzYET4Y9pQo/view?usp=sharing'>PDF</a>
  ";
}

// Create Site Contact admin widget
function milo_contact_dashboard_widget() {
	echo "
  For technical assistance with this website, please contact:<br>
  <br>
	Michael Lopetrone<br>
	Milo Media<br>
	<a href='https://www.milomedia.co'>https://www.milomedia.co</a><br>
	313-327-2820
  ";
}

// Custom Milo Media Admin Footer
function milo_remove_footer_admin () {
	echo '<span id="footer-thankyou">Built by <a href="https://www.milomedia.co" target="_blank">Milo Media</a></span>';
}
add_filter( 'admin_footer_text', 'milo_remove_footer_admin' );

// Custom Admin Logo Header
function milo_custom_login_logo()
{
    echo '<style  type="text/css"> h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/img/tpf-logo-color.png)  !important;     background-size: 250px !important;     height: 130px !important;     width: 250px !important;} </style>';
}
add_action('login_head',  'milo_custom_login_logo');

/**
 * Adds a column in the admin dashboard to show the active page template
 * @link https://www.isitwp.com/custom-column-with-currently-active-page-template/
 */
add_filter( 'manage_pages_columns', 'page_column_views' );
add_action( 'manage_pages_custom_column', 'page_custom_column_views', 5, 2 );
function page_column_views( $defaults )
{
   $defaults['page-layout'] = __('Template');
   return $defaults;
}
function page_custom_column_views( $column_name, $id )
{
   if ( $column_name === 'page-layout' ) {
       $set_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
       if ( $set_template == 'default' ) {
           echo 'Default';
       }
       $templates = get_page_templates();
       ksort( $templates );
       foreach ( array_keys( $templates ) as $template ) :
           if ( $set_template == $templates[$template] ) echo $template;
       endforeach;
   }
}

//Disable Comments
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
?>
