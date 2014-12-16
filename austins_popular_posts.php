<?php 
/*
Plugin Name: Austin's Popular Posts
Text Domain: austins-popular-posts
Plugin URI: http://www.austinsoffice.com/popular-posts
Description: A plugin that generates post view data and uses it to create a widget for displaying a list of the most popular posts based on a number of parameters.
Version: 0.5.1
Author: Austin Gregory
Author URI: http://www.austinsoffice.com/
*/

include( plugin_dir_path( __FILE__ ) . 'popular_widget.php');

// Create the filter so that this is added at the_content
add_filter('the_content', 'popular_post_meta');


function popular_post_meta($content) 
{
    global $post;
    $view_count;
    // Condition to make sure we're doing this only on a single post page. We don't want to count views on archives, the index, or whatever.
    if (is_single()) 
    {
        /* add_post_meta creates the field in the database and sets the default value to 0
         * This is great because the "true" tells it that if this field already exists, don't do anything
         * So if it doesn't exist, it'll set it to 0. If it does exist, it'll remain whatever it already is!
        */
        add_post_meta($post->ID, 'post_views', 0, true);

        // This just grabs that data from the database, increments it by one, and stores it in a variable
        $view_count = get_post_meta($post->ID, 'post_views', true);

        // This updates that field with the newly incremented view_count. 
        update_post_meta($post->ID, 'post_views', $view_count);
    }
    return $content;
}

function get_popular_posts($time, $amount_to_list, $list_type = "ul", $class= "austins-popular-posts") {
    // Convert the $time string to a wordpress date parameter safe thing!
    if ($time != 'daily')
        $time = trim($time, 'ly');
    else
        $time = 'day';
    
    // Define the arguments for the popular posts_query
    $args = array( 
        'orderby' => 'meta_value_num', 
        'meta_key' => 'post_views',
        'date_query' => array(
            array(
                'after' => '1 '.$time.' ago',
            )
        ),
        'posts_per_page' => $amount_to_list,
    );
    
    // Gather the posts based on the arguments defined above
    $pop_posts = get_posts( $args );

    echo '<'.$list_type.' class="'.$class.'">';
    // Loop through each post and print a link to the screen generating a list
    foreach ( $pop_posts as $post ) {
        echo '<li><a href="'.get_permalink($post->ID).'" title="Permalink for'.get_the_title($post->ID).'">'.get_the_title($post->ID).'</a></li>';
    }
    echo '</'.$list_type.'>';
    // Reset the wordpress post data
    wp_reset_postdata();
}


add_action( 'wp_enqueue_scripts', 'load_css' );
function load_css() {
    wp_register_style( 'popular-posts', plugins_url( 'popular-posts.css', __FILE__ ) );
    wp_enqueue_style('popular-posts');
}

// This function prints the view count on screen
function get_view_count($id = " ") {
    global $post;
    if ($id == " ")
        $id = $post->ID;
    $count = get_post_meta($id, 'post_views', true);
    echo $count;
}

// This function just returns the view count so you can do stuff with it (?)
function view_count($id = " ") {
    global $post;
    if ($id == " ")
        $id = $post->ID;
    $count = get_post_meta($id, 'post_views', true);
    return $count;
}


?>
