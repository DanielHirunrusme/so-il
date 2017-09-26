<?php
/**
 * Roots initial setup and constants
 */
function roots_setup() {
  // Make theme available for translation
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
    'home_featured_projects' => __('Home Featured Projects', 'roots'),
    'projects_subnavigation' => __('Projects Sub-navigation', 'roots'),
    'research_subnavigation' => __('Research Sub-navigation', 'roots'),
    'information_subnavigation' => __('Information Sub-navigation', 'roots')
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 9999);
  add_image_size( 'project-thumb', 700, 9999 );
  add_image_size( 'project-thumb@2x', 1400, 9999 );
  add_image_size( 'project-image', 1400, 9999 );
  add_image_size( 'project-image@2x', 2800, 9999 );
  // add_image_size('category-thumb', 300, 9999); // 300px wide (and unlimited height)

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Tell the TinyMCE editor to use a custom stylesheet
  // add_editor_style('/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'roots_setup');
