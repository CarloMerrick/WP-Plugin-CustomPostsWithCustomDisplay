<?php
/**
 * Plugin Name: Webinars-Custom-Output
 * Plugin URI: https://github.com/CarloMerrick/WP-Plugin-CustomPostsWithCustomDisplay
 * Description: Webinars Dashboard posts with display shortcode output of custom fiels
 * Version: 1.0
 * Author: Friendlywebsites.net
 * Author URI: http://www.friendlywebsites.net
 */

 //function for all the standard fields for a WP post
function cw_post_type_webinars() {
    $supports = array(
    'title', // post title
    'editor', // post content
    'author', // post author
    'thumbnail', // featured images
    'excerpt', // post excerpt
    'custom-fields', // custom fields
    'comments', // post comments
    'revisions', // post revisions
    'post-formats', // post formats
    );
    $labels = array(
    'name' => _x('webinars', 'plural'),
    'singular_name' => _x('webinars', 'singular'),
    'menu_name' => _x('Webinars', 'admin menu'),
    'name_admin_bar' => _x('webinars', 'admin bar'),
    'add_new' => _x('Add New', 'add new'),
    'add_new_item' => __('Add New Webinars'),
    'new_item' => __('New Webinars'),
    'edit_item' => __('Edit Webinars'),
    'view_item' => __('View Webinars'),
    'all_items' => __('All Webinars'),
    'search_items' => __('Search Webinars'),
    'not_found' => __('No Webinars found.'),
    );
    $args = array(
    'supports' => $supports,
    'labels' => $labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'webinars'),
    'has_archive' => true,
    'hierarchical' => false,
    );
    register_post_type('webinars', $args);
    }
    add_action('init', 'cw_post_type_webinars');
    /*Custom Post type end*/
    //Shortcode function
    if ( ! function_exists('webinars_shortcode') ) {
    
        function webinars_shortcode() {
            $args   =   array(
                        'post_type'         =>  'webinars',
                        'post_status'       =>  'publish',
                        'order' => 'ASC',
                        'posts_per_page' => 10,
                        );
                        
            $postslist = new WP_Query( $args );
            global $post; 
            //put all the custom fields into variable to output to shortcode
            if ( $postslist->have_posts() ) :
            $webinars   .= '<div class="webinars-lists">';
            
                while ( $postslist->have_posts() ) : $postslist->the_post();         
                    $webinars    .= '<div class="short_style">'; 
                    $webinars    .= "<h2>" . get_the_title() ."<br/></h2>";
                    $webinars    .= "Location :". get_field('location') . "<br/>";   
                    $webinars    .= "Speaker :". get_field('speaker').  "<br/>";
                    $webinars    .= "Date :". get_field('date').  "<br/>";	
                    $webinars    .= "Time :". get_field('time').  "<br/>";
                    $webinars    .= "Registration Link :". '<a href="'. get_permalink() .'">'. get_field('registration-link') . '</a>' .  "<br/>";
                    $webinars    .= "Promo-Video :<br/>". get_field('promo_video').  "<br/>";
                    $webinars    .= '</div>';      
                    
                endwhile;
                wp_reset_postdata();
                $webinars  .= '</div>';			
            endif;    
            return $webinars;
            
        }
        //short code works with 'webinars'
        add_shortcode( 'webinars', 'webinars_shortcode' );    
    }