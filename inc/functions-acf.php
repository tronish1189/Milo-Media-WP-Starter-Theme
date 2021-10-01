<?php
//Add ACF Options page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

//Register blocks
add_action('acf/init', 'my_acf_blocks_init');
function my_acf_blocks_init()
{

    // Check function exists.
    if (function_exists('acf_register_block_type')) {

        // Register block
        acf_register_block_type(array(
            'name'              => '[BLOCK NAME]',
            'title'             => __('[BLOCK NAME]'),
            'description'       => __('[BLOCK DESCRIPTION]'),
            'render_template'   => 'inc/blocks/video-cards.php',
            'category'          => 'hc-custom-blocks',
            'icon'                => 'admin-users'
        ));
    }
}
