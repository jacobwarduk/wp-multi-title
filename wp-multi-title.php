<?php  

    /*
        Plugin Name: WP Multi-Title
        Plugin URI: http://www.jacobward.co.uk
        Description: Give WordPress posts and pages a secondary title. One to be used on single pages, another to be used in sitewide elements.
        Version: 1.0.0
        Author: jacobwarduk
        Author URI: http://www.jacobward.co.uk
    */


    // Adding the secondary title input after the main title input
    add_action( 'edit_form_after_title', 'add_secondary_input_field' );

    function add_secondary_input_field( $post ) {

        $secondary_title = get_post_meta( $post->ID, 'secondary_title', true ); // Gettting the value of the secondary title

        echo '<input type="text" id="secondary_title" name="secondary_title" value="' . $secondary_title . '" style="width: 100%; height: 37px; font-size: 22px; margin-top: 10px; padding-left: 10px; display: block;" placeholder="Single page title..." />'; // Showing the input field for the secondary title

    }


    // Saving the secondary title
    add_action( 'save_post', 'secondary_title_metabox_save' );

    function secondary_title_metabox_save( $post_id ) {

        // If the secondary title field had an input
        if ( isset( $_POST['secondary_title'] ) ) {

            update_post_meta( $post_id, 'secondary_title', esc_html( $_POST['secondary_title'] ) ); // Update the secondary post title

        }

    }


    // Changing input form text for sitewide title
    add_filter( 'enter_title_here', 'short_name_title' );

    function short_name_title( $input ) {

        return __('Sitewide title...');

    }


    // Changing the display of titles on the front end
    add_filter( 'the_title', 'secondary_title_display', 10, 2 );

    function secondary_title_display( $title, $post_ID ) {

        // It it's a single page
        if ( is_single() ) {

            $secondary_title = get_post_meta( $post_ID, 'secondary_title', true );  // Getting the value of the secondary title

            // If the secondary title is not empty
            if ( $secondary_title != '' ) {

                return $secondary_title; // Return the secondary as title

            }

        }

        return $title;  // Return the title

    }


?>