<?php  

    /*
        Plugin Name: WP Multi-Title
        Plugin URI: http://www.jacobward.co.uk
        Description: Give WordPress posts and pages a sitewide title. One to be used on single pages, another to be used in sitewide elements.
        Version: 1.0.0
        Author: jacobwarduk
        Author URI: http://www.jacobward.co.uk
    */


    // Adding the sitewide title input field under the main title input field
    add_action( 'edit_form_after_title', 'add_sitewide_input_field' );

    function add_sitewide_input_field( $post ) {

        $sitewide_title = get_post_meta( $post->ID, 'sitewide_title', true ); // Getting the value of the sitewide title

        echo '<input type="text" id="sitewide_title" name="sitewide_title" value="' . $sitewide_title . '" style="width: 100%; height: 37px; font-size: 22px; margin-top: 10px; padding-left: 10px; display: block;" placeholder="Single post/page title..." />'; // Showing the input field for the sitewide title

    }


    // Saving the sitewide title meta
    add_action( 'save_post', 'sitewide_title_metabox_save' );

    function sitewide_title_metabox_save( $post_id ) {

        // If the sitewide title field had an input
        if ( isset( $_POST['sitewide_title'] ) ) {

            update_post_meta( $post_id, 'sitewide_title', esc_html( $_POST['sitewide_title'] ) ); // Update the sitewide post title

        }

    }


    // Changing the input field placeholder text for sitewide title
    add_filter( 'enter_title_here', 'primary_name_title' );

    function primary_name_title( $input ) {

        return __('Sitewide title...');

    }


    // Changing the display of titles on the front end
    add_filter( 'the_title', 'sitewide_title_display', 10, 2 );

    function sitewide_title_display( $title, $post_ID ) {

        // It it's a single page
        if ( is_single() ) {

            $sitewide_title = get_post_meta( $post_ID, 'sitewide_title', true );  // Getting the value of the sitewide title

            // If the sitewide title is not empty
            if ( $sitewide_title != '' ) {

                return $sitewide_title; // Return the sitewide as title

            }

        }

        return $title;  // Return the title

    }


?>