<?php

/**
 * Add our custom meta box for urls.
 */

function url_page_add_custom_box () {
  add_meta_box('url_page_id', __('URLs to fetch from', 'isoscreamscreen'), 'url_page_custom_box', 'page');
}

add_action('add_meta_boxes', 'url_page_add_custom_box');

/**
 * Meta box output.
 *
 * @param $post
 */

function url_page_custom_box ($post) {

  wp_nonce_field( 'url_page_custom_box', 'url_page_custom_box_nonce' );
  $value = get_post_meta($post->ID, 'url_page_value', true);
  $value = str_replace(' ', "\n", $value);

  echo '<p><label for="url_page_field">';
  _e( 'One url per line', 'isoscreamscreen' );
  echo '</label></p>';

  echo '<textarea class="textarea" id="url_page_field" name="url_page_field" style="width:100%;height:250px;">' . esc_attr($value) . '</textarea>';
}

/**
 * Save meta box value.
 *
 * @param $post_id
 * @return mixed
 */

function url_page_save_postdata( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['url_page_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['url_page_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'url_page_custom_box' ) )
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
  $value = sanitize_text_field( $_POST['url_page_field'] );
  $value = str_replace(' ', "\n", $value);

  // Update the meta field in the database.
  update_post_meta( $post_id, 'url_page_value', $value );
}
add_action( 'save_post', 'url_page_save_postdata' );