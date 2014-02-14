<?php

/**
 * Add our custom meta box for urls.
 */

function url_page_add_custom_box () {
  add_meta_box('url_page_id', __('URLs to fetch content from', 'isoscreamscreen'), 'url_page_custom_box', 'page');
}

add_action('add_meta_boxes', 'url_page_add_custom_box');

function url_page_admin_head () {
  ?>
  <style type="text/css">
    .url-page {}
    .url-page-right { float: right; }
    .url-page-list { }
    .url-page-list li { float: left; width: 100%; }
    .url-page-list-delete { color: red; text-decoration: underline; }
    .clearfix { clear: both; }
  </style>
  <?
}

add_action('admin_head', 'url_page_admin_head');

function url_page_admin_footer () {
  echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/js/admin.js"></script>';
}

add_action('admin_footer', 'url_page_admin_footer');

/**
 * Meta box output.
 *
 * @param $post
 */

function url_page_custom_box ($post) {
  wp_nonce_field( 'url_page_custom_box', 'url_page_custom_box_nonce' );
  $value = get_post_meta($post->ID, 'url_page', true);
  if (!is_array($value) || empty($value) && is_array($value)) $value = array('link' => '');
  ?>
  <div id="url-page-list-template" class="hidden">
    <label>Länk</label>
    <input type="text" name="url-page[][link]" class="url-page-tmpl-link" />
    <input type="button" class="mediauploader" value="Välj bild" />
    <label>Template</label>
    <select name="url-page[][template]" class="url-page-tmpl-template">
      <?php foreach (get_templates() as $t): ?>
        <option value="<?= $t; ?>"><?= $t; ?></option>
      <?php endforeach; ?>
    </select>
    <label>Bakgrundsbild</label>
    <input type="text" name="url-page[][bgUrl]" class="url-page-tmpl-bgurl" />
    <input type="button" class="mediauploader" value="Välj bild" />
    <label>Transition</label>
    <select name="url-page[][transition]" class="url-page-tmpl-transition">
      <?php foreach (get_transitions() as $t): ?>
        <option value="<?= $t; ?>"><?= $t; ?></option>
      <?php endforeach; ?>
    </select>
    <label>Timer</label>
    <input type="text" name="url-page[][timer]" value="5" class="url-page-tmpl-timer" />
    <label>Title</label>
    <input type="text" name="url-page[][title]" class="url-page-tmpl-title" />
    <a href="#" class="url-page-list-delete">X</a>
  </div>
  <a href="#" class="url-page-right add-new-url">Lägg till ny länk</a>
  <ul class="url-page-list">
    <?php $i = 0; foreach ($value as $v): ?>
      <?php if ((isset($v['link']) && !empty($v['link'])) || count($value) === 1): ?>
      <li>
        <label>Länk</label>
        <input type="text" name="url-page[<?= $i; ?>][link]" value="<?= $v['link']; ?>" />
        <input type="button" class="mediauploader" value="Välj bild" />
        <label>Template</label>
        <select name="url-page[<?= $i; ?>][template]">
          <?php foreach (get_templates() as $t): ?>
            <option value="<?= $t; ?>" <?= isset($v['template']) && $t == $v['template'] ? 'selected="selected"' : ''; ?>><?= $t; ?></option>
          <?php endforeach; ?>
        </select>
        <label>Bakgrundsbild</label>
        <input type="text" name="url-page[<?= $i; ?>][bgUrl]" value="<?= $v['bgUrl']; ?>" />
        <input type="button" class="mediauploader" value="Välj bild" />
        <label>Transition</label>
        <select name="url-page[<?= $i; ?>][transition]">
          <?php foreach (get_transitions() as $t): ?>
            <option value="<?= $t; ?>" <?= isset($v['transition']) && $t == $v['transition'] ? 'selected="selected"' : ''; ?>><?= $t; ?></option>
          <?php endforeach; ?>
        </select>
        <label>Timer</label>
        <input type="text" name="url-page[<?= $i; ?>][timer]" value="<?= empty($v['timer']) ? 5 : $v['timer'];  ?>" />
        <label>Title</label>
        <input type="text" name="url-page[<?= $i; ?>][title]" class="url-page-tmpl-title" value="<?= $v['title'];  ?>"  />
        <a href="#" class="url-page-list-delete">X</a>
      </li>
      <?php endif; $i++; ?>
    <?php endforeach; ?>
  </ul>
  <div class="clearfix"></div>

  <?php
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
  if ( ! isset( $_POST['url_page_custom_box_nonce'] ))
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
  $value = $_POST['url-page'];

  // Update the meta field in the database.

  $value = array_filter($value, function ($v) {
    return !empty($v['link']);
  });

  update_post_meta( $post_id, 'url_page', $value );
}
add_action( 'save_post', 'url_page_save_postdata' );