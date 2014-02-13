<?php


function image_page_custom_box () {}


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_custom_box() {

    $screens = array( 'post', 'page' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'myplugin_sectionid',
            __( 'My Post Section Title', 'myplugin_textdomain' ),
            'myplugin_inner_custom_box',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_inner_custom_box( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );

  echo '<label for="myplugin_new_field">';
       _e( "Description for this field", 'myplugin_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_postdata( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['myplugin_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;

  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  $mydata = sanitize_text_field( $_POST['myplugin_new_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_my_meta_value_key', $mydata );
}
add_action( 'save_post', 'myplugin_save_postdata' );