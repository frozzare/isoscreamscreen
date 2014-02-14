<?php

require_once('includes/url-page.php');

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
    $obj = new stdClass;
    // $obj->id = $post->ID;
    // $obj->title = $post->post_title;
    // $obj->text = $post->post_content;
    $meta = get_post_meta($post->ID, 'url_page', true);
    if (!is_array($meta)) $meta = array();
    $post = array_map(function ($url) {
      $obj = new stdClass;
      if (preg_match('/(\.jpg|\.png|\.bmp)$/', $url['link'])) {
        $obj->imgUrl = $url['link'];
      } else {
        $obj->url = $url['link'];
      }
      $obj->bgUrl = $url['bgUrl'];
      $obj->timer = is_null($url['timer']) ? 5 : $url['timer'];
      $obj->template = $url['template'];
      $obj->backgroundTransition = $url['transition'];
      $obj->title = $url['title'];
      return $obj;
    }, $meta);
    $res = array();
    foreach ($post as $p) $res[] = $p;
    $obj->items = $res;
    return $obj;
  }, $posts));
  $obj = new stdClass;
  $obj->content = $posts;
  return (object)$obj;
}

/**
 * Get array of which transitions to use.
 *
 * @return array
 */

function get_transitions () {
  return array('default', 'cube', 'page', 'concave', 'zoom', 'linear', 'fade', 'none');
}

/**
 * Get array of which templates to use.
 *
 * @return array
 */

function get_templates () {
  return array('img', 'url', 'mov');
}