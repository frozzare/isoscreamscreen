<?php

include 'includes/url-page.php';

/**
 * Get images for page.
 *
 * @param int $post_id
 *
 * @return array
 */

function get_images ($post_id) {
  return array_map(function ($id) {
    return wp_get_attachment_url($id);
  }, dfi_get_post_attachment_ids($post_id));
}

/**
 * Get array of all pages.
 *
 * @return array
 */

function get_pages_array () {
  $posts = get_posts(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
  ));
  $posts = array_map(function ($post) {
    $obj = new stdClass();
    $obj->id = $post->ID;
    $obj->title = $post->post_title;
    $obj->content = $post->post_content;
    $obj->images = get_images($post->ID);
    $obj->urls = get_post_meta($post->ID, 'url_page_value', true);
    $obj->urls = explode("\n", $obj->urls);
    return $obj;
  }, $posts);
  return $posts;
}

function remove_page_meta_boxes () {
}

add_action( 'admin_menu', 'remove_post_meta_boxes' );