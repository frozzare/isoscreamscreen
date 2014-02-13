<?php

header('Content-type: application/json');

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

// echo json_encode($posts);

// var_dump(get_post_meta(10, '_my_meta_value_key'));
var_dump(get_images(10));