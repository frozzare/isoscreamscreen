<?php

header('Content-type: application/json');

$pages = get_pages_array();

// echo json_encode($posts);

// var_dump(get_post_meta(10, '_my_meta_value_key'));
// var_dump(get_images(10));

echo json_encode($pages);