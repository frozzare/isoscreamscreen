<?php

require_once 'includes/url-page.php';

function remove_http ($url) {
  $disallowed = array('http://', 'https://');
  foreach($disallowed as $d) {
    if(strpos($url, $d) === 0) {
      return str_replace($d, '', $url);
    }
  }
  return $url;
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
  $posts = array_filter(array_map(function ($post) {
    $obj = array();
    // $obj->id = $post->ID;
    // $obj->title = $post->post_title;
    // $obj->text = $post->post_content;
    $meta = get_post_meta($post->ID, 'url_page', true);
    if (!is_array($meta)) $meta = array();
    return array_map(function ($url) {
      $obj = new stdClass;
      if (preg_match('/(\.jpg|\.png|\.bmp)$/', $url['link'])) {
        $obj->bgUrl = $url['link'];
      } else {
        $obj->url = $url['link'];
      }
      $obj->backgroundTransition = $url['transition'];
      return $obj;
    }, array_filter($meta));
  }, $posts));
  $obj = new stdClass;
  $obj->content = $posts;
  return (object)$obj;
}

function get_transitions () {
  return array('katt', 'mus', 'hund');
}

function get_file_extension ($file_name) {
  return substr(strrchr($file_name,'.'),1);
}