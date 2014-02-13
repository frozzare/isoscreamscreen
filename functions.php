<?php

include 'includes/url-page.php';

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
    $obj->urls = get_post_meta($post->ID, 'url_page', true);
    return $obj;
  }, $posts);
  return $posts;
}

function get_transitions () {
  return array('katt', 'mus', 'hund');
}