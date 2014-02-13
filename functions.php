<?php

include 'includes/image-page.php';

/**
 * Get the page.
 *
 * @param int $id
 * @param string $meta_key
 * @param bool $single
 * @return null|object
 */

function get_the_page ($id = 0, $meta_key = '', $single = true) {
  if (!is_numeric($id)) $meta_key = $id;
  $id = $id > 0 && is_numeric($id) ? $id : get_the_ID();
  $post = get_post($id);
  $post = is_object($post) ? (array)$post : $post;
  $meta = get_post_meta($id, $meta_key, $single);
  if (!is_null($meta) && !empty($meta)) $post = array_merge($post, $meta);
  return is_array($post) ? (object)$post : null;
}


function get_images ($post_id) {
  return array_map(function ($id) {
    return wp_get_attachment_url($id);
  }, dfi_get_post_attachment_ids($post_id));
}

function get_pages () {
  $posts = get_posts(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
  ));
  $posts = array_map(function ($post) {
    $obj = new stdClass();
    $obj->id = $post->id;
    $obj->title = $post->post_title;
    $obj->content = $post->post_content;
    return $obj;
  }, $posts);
}