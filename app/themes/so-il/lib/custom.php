<?php
/**
 * Custom functions
 */
 
require_once locate_template('/lib/vimeo.php');


define('VIMEO_APP_ID', '36837');
define('VIMEO_SECRET', '0f67fa94238a1590a9c69c103ea217097553e173');
define('VIMEO_TOKEN', 'e290b914fb37ec29c027aed686f8d7a8');
define('DEFAULT_DATE_FORMAT', 'F j, Y');

/*
define('VIMEO_APP_ID', '109621');
define('VIMEO_SECRET', 'UCw9I5rN2DNzTpH+LBnoe2aOzJTLXCoaaP6wNITgksu8Vy4qAwCQaPGrPlOcXocRE5ZvbIJliLUZX9sLogO7H/L9+Piufru9mY/PasWHnZI2acE5GnGXy3nljqXRq/y4');
define('VIMEO_TOKEN', 'a24637c07384218e2fd0a3766644c1eb');
define('DEFAULT_DATE_FORMAT', 'F j, Y');
*/

global $VIMEO;
$VIMEO = new Vimeo(VIMEO_APP_ID, VIMEO_SECRET, VIMEO_TOKEN);

add_action('init', 'add_project_rules');
function add_project_rules() { 
  add_rewrite_rule('^(archive|featured|projects)/([^/]+)/overview/?', 'index.php?project=$matches[2]&extra_classes=project-overview', 'top');
  add_rewrite_rule('^featured/([^/]+)/?', 'index.php?project=$matches[1]', 'top');
  add_rewrite_rule('^projects/type/([^/]*)/year/([^/]*)/?', 'index.php?post_type=project&category_name=$matches[1]&archive_year=$matches[2]', 'top');
  add_rewrite_rule('^projects/year/([^/]*)/?', 'index.php?post_type=project&archive_year=$matches[1]', 'top');
  add_rewrite_rule('^projects/type/([^/]*)/?', 'index.php?post_type=project&category_name=$matches[1]', 'top');
}

add_action('init', 'set_last_page_for_project_close');
function set_last_page_for_project_close() {
  if (!is_admin()) {
    session_start();

    if (is_outside_project() && is_outside_writing() && !is_login_form()) {
      $_SESSION['project_back'] = $_SERVER["REQUEST_URI"];
    }
  }
}

function is_login_form()
{
  $uri = $_SERVER["REQUEST_URI"];
  return preg_match('/^\/wp\/wp-login.php/', $uri);
}

function is_outside_project()
{
  $uri = $_SERVER["REQUEST_URI"];
  if($uri == '/projects/') {
    $_SESSION['project_back'] = '/projects/';
    return true;
  } else {
    return !preg_match('/^\/(featured|projects)\/.+?\/(images\/)?/', $uri) ||
         preg_match('/^\/(featured|projects)\/(type|year)\/?/', $uri);
  }
  
}

function is_outside_writing()
{
  $uri = $_SERVER["REQUEST_URI"];
  return !preg_match('/^\/writing/', $uri);
}

function wpdocs_custom_excerpt_length( $length ) {
    return 80;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );


add_filter('tiny_mce_before_init', 'myformatTinyMCE' );
function myformatTinyMCE($mce){
  $mce['paste_remove_styles'] = true;
  $mce['paste_remove_spans'] = true;
  $mce['paste_strip_class_attributes'] = 'none';
  return $mce;
}

add_filter('mce_buttons_2', 'add_sup_and_sub_buttons');
function add_sup_and_sub_buttons($buttons) {
  $buttons[] = 'superscript';
  $buttons[] = 'subscript';
  return $buttons;
}

add_filter('mce_buttons_2', 'remove_bad_buttons_2');
function remove_bad_buttons_2($buttons) {
  $remove = array('underline', 'justifyfull', 'indent', 'outdent', 
    'justify', 'forecolor');
  return array_diff($buttons, $remove);
}

add_filter('mce_buttons', 'remove_bad_buttons');
function remove_bad_buttons($buttons) {
  $remove = array('justifyleft', 'justifycenter', 'justifyright', 'hr');
  return array_diff($buttons, $remove);
}

add_filter('the_generator', 'complete_version_removal');
function complete_version_removal() {
  return '';
}

add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
  remove_menu_page('edit.php');
  remove_menu_page('tools.php');
  remove_menu_page('edit-comments.php');
}

add_action( 'init', 'create_post_types' );
function create_post_types() {
  create_post_type( 'project', 'Project', 'Projects',
    array(
      'menu_icon' => 'dashicons-hammer',
      'taxonomies' => array('category'),
      'supports' => array('title', 'editor', 'revisions', 'page-attributes'),
      'rewrite' => array( 'slug' => 'projects' ),
      'hierachical' => true,
      'menu_position' => 5
    )
  );
  
  create_post_type( 'writing', 'Writing', 'Writings',
    array(
      'menu_icon' => 'dashicons-edit',
      'supports' => array('title', 'editor', 'revisions', 'page-attributes'),
      'menu_position' => 6
    )
  );
  
  create_post_type( 'publication', 'Publication', 'Publications',
    array(
      'menu_icon' => 'dashicons-book-alt',
      'supports' => array('title', 'revisions', 'page-attributes'),
      'rewrite' => array( 'slug' => 'publications' ),
      'menu_position' => 7
    )
  );
  
  create_post_type( 'news-post', 'News Post', 'News Posts',
    array(
      'supports' => array('title', 'editor', 'revisions', 'page-attributes'),
      'rewrite' => array( 'slug' => 'news' ),
      'menu_position' => 8
    )
  );
  
  create_post_type( 'writeup', 'Press Writeup', 'Press Writeups',
    array(
      'menu_icon' => 'dashicons-format-status',
      'supports' => array('title', 'revisions', 'page-attributes'),
      'rewrite' => array( 'slug' => 'press' ),
      'menu_position' => 9
    )
  );
  
  
  create_post_type( 'lecture', 'Lecture', 'Lectures',
    array(
      'menu_icon' => 'dashicons-welcome-learn-more',
      'supports' => array('revisions', 'page-attributes'),
      'rewrite' => array( 'slug' => 'lectures' ),
      'menu_position' => 10
    )
  );
  
}


function add_custom_rewrite_rule() {

    // First, try to load up the rewrite rules. We do this just in case
    // the default permalink structure is being used.
    if( ($current_rules = get_option('rewrite_rules')) ) {

        // Next, iterate through each custom rule adding a new rule
        // that replaces 'movies' with 'films' and give it a higher
        // priority than the existing rule.
        foreach($current_rules as $key => $val) {
            if(strpos($key, 'archive') !== false) {
                add_rewrite_rule(str_ireplace('archive', 'projects', $key), $val, 'top');   
            } // end if
        } // end foreach

    } // end if/else

    // ...and we flush the rules
    flush_rewrite_rules();

} // end add_custom_rewrite_rule
add_action('init', 'add_custom_rewrite_rule');

add_filter( 'wp_insert_post_data' , 'modify_lecture_post_title' , '99', 2 );
function modify_lecture_post_title( $data , $postarr )
{
  if($data['post_type'] == 'lecture') {
    $title = array();
    // Venue
    if (isset($_POST['fields']['field_532687a93d85e']) && $_POST['fields']['field_532687a93d85e'] != '') {
      $title[] = $_POST['fields']['field_532687a93d85e'];
    }
    // Title
    if (isset($_POST['fields']['field_532688583d860']) && $_POST['fields']['field_532688583d860'] != '') {
      $title[] = "\"" . $_POST['fields']['field_532688583d860'] . "\"";
    }
    // Location
    if (isset($_POST['fields']['field_5326883a3d85f']) && $_POST['fields']['field_5326883a3d85f'] != '') {
      $title[] = $_POST['fields']['field_5326883a3d85f'];
    }
    $data['post_title'] = implode(', ', $title);
  }
  return $data;
}

add_filter( 'wp_insert_post_data' , 'make_page_content' , '99', 2 );
function make_page_content( $data , $postarr )
{
  $exceptions = array('page-contact.php', 'page-simple.php');
  if($data['post_type'] == 'page') {
    if (!in_array($postarr['page_template'], $exceptions)) {
      $subsections = [];
      // Subsections
      if (isset($postarr['fields']['field_533f189398313'])) {
        foreach ($postarr['fields']['field_533f189398313'] as $section) {
          array_push($subsections, $section['field_533f18c898315']);
        }
      }
      $data['post_content'] = implode("\n\n", $subsections);
    } else {
      $postarr['fields']['field_533f189398313'] = array();
    }
  }
  return $data;
}

function create_post_type($type, $singular, $plural, $options)
{
  $labels = array(
    'name' => __( $plural ),
    'singular_name' => __( $singular ),
    'add_new_item' => __( 'Add New ' . $singular ),
    'new_item' => __( 'New ' . $singular ),
    'edit_item' => __( 'Edit ' . $singular ),
    'view_item' => __( 'View ' . $singular ),
    'all_items' => __( 'All ' . $plural ),
    'search_items' => __( 'Search ' . $plural )
  );
  $options['labels'] = $labels;
  $options['public'] = true;
  $options['has_archive'] = true;
  
  register_post_type($type, $options);
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
function remove_dashboard_widgets () {
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}

add_action( 'pre_get_posts', 'modify_main_query' );
function modify_main_query( $query ) {
  
  if ( is_admin() && $query->is_main_query() ) {
    if (is_post_type_archive('project')) {
      $query->set( 'posts_per_page', 9999 );
    }
  }
  
  if ( !is_admin() && $query->is_main_query() ) {
    
    if (is_home()) {
      $post_types = array( 'project', 'writing' );
      
      $query->set( 'post_type', $post_types );
      $query->set( 'meta_query', array(
              array(
                 'key' => 'is_featured',
                 'value' => true
              )
          )
      );
      #$query->set( 'orderby', 'title' );
      #$query->set( 'order', 'DESC' );
      $query->set( 'meta_key', 'featured_position' );
      $query->set( 'posts_per_page', 9999 );
    }
    
    if (is_post_type_archive('lecture')) {
      $query->set( 'orderby', 'menu_order' );
      $query->set( 'order', 'DESC' );
      $query->set( 'meta_key', 'date' );
      $query->set( 'posts_per_page', 9999 );
    }
    
    if (is_post_type_archive('writeup')) {
      $query->set( 'orderby', 'menu_order' );
      $query->set( 'order', 'DESC' );
      $query->set( 'meta_key', 'date' );
      $query->set( 'posts_per_page', 9999 );
    }
    
    if (is_post_type_archive('news-post')) {
      $query->set( 'orderby', 'date' );
      $query->set( 'order', 'DESC' );
      $query->set( 'posts_per_page', 9999 );
    }
    
    if (is_post_type_archive('project')) {
      
      $post_types = array( 'project', 'writing', 'publication' );
      $query->set( 'post_type', $post_types );
      $query->set( 'posts_per_page', 9999 );
      
      // Also sorted in the the_posts filter but this filters out 
      // posts without dates set
      #$query->set( 'orderby', 'menu_order title' );
      //$query->set( 'meta_key', 'date' );
      
      if ($query->get('category_name') == 'publication' ||
          $query->get('category_name') == 'writing') {
        $query->set( 'project_category_filter', $query->get('category_name') );
        $query->set( 'category_name', '' );
      }
    }
    
    if ($query->is_search) {
      $query->set( 'post_type', array( 'news-post', 'project', 'writing' ) );
    };
    
  }
}

function project_page_columns($columns)
{
  //'boost'      => 'Boost',
  //'featured'   => 'Featured',
  $columns = array(
    'cb'         => '<input type="checkbox" />',
    'title'      => 'Title',
    'author'     => 'Author',
    'date'       => 'Date'
  );
  return $columns;
}

function project_custom_columns($column)
{
  global $post;
  if($column == 'featured') {
    if(get_field('is_featured')) {
      echo '&#10003;';
    } else {
      echo '--';
    }
  } elseif ($column == 'boost') {
    if(get_field('featured_position')) {
      echo get_field('featured_position');
    } else {
      echo '--';
    }
  }
}


add_action("manage_project_posts_custom_column", "project_custom_columns");
add_filter("manage_edit-project_columns", "project_page_columns");
add_action("manage_writing_posts_custom_column", "project_custom_columns");
add_filter("manage_edit-writing_columns", "project_page_columns");

add_action('wp_enqueue_scripts', 'soil_styles', 50);
function soil_styles() {
  wp_enqueue_style('soil_fonts', get_template_directory_uri() . '/assets/css/fonts.css', false, '9880649384aea9f1ee166331c0a30daa');
}

add_action('wp_enqueue_scripts', 'soil_scripts', 150);
function soil_scripts() {
  // wp_enqueue_script('videojs', get_template_directory_uri() . '/assets/js/vendor/video.dev.js', array(), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('videojs', get_template_directory_uri() . '/assets/js/vendor/video.js', array(), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('jquery.cookie', get_template_directory_uri() . '/assets/js/vendor/jquery.cookie.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('raf', get_template_directory_uri() . '/assets/js/vendor/request_animation_frame.js', array(), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/js/vendor/imagesloaded.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('browserdetect', get_template_directory_uri() . '/assets/js/vendor/jquery.browserdetect.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('jqueryMousewheel', get_template_directory_uri() . '/assets/js/vendor/jquery.mousewheel.min.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30dasa');
  wp_enqueue_script('dotdotdot', get_template_directory_uri() . '/assets/js/vendor/jquery.dotdotdot.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30dasa');
  wp_enqueue_script('lazyload', get_template_directory_uri() . '/assets/js/vendor/jquery.lazyloadxt.extra.min.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/vendor/slick.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('jquery.hypher', get_template_directory_uri() . '/assets/js/vendor/jquery.hypher.min.js', array('jquery'), '9880649384aea9f1ee166331c0a30daa');
  wp_enqueue_script('en-us', get_template_directory_uri() . '/assets/js/vendor/en-us.js', array('jquery.hypher'), '9880649384aea9f1ee166331c0a30daa');
}

add_filter('the_content', 'insert_footnotes');
function insert_footnotes($content) {
  $type = get_post_type();
  if ($type == 'project' || $type == 'page') {
    $footnotePattern = '/\[(.*?)\]/s';
    $insertFootnote = function($matches){
      $content = $matches[1];
      $image_ids = extract_image_ids($content);
      if (count($image_ids)) {
        $front = "<span class='footnote' data-images='" . 
          json_encode($image_ids) . "'>";
        $back = "</span>";
        
        // yeah yeah don't parse HTML with Regex :\
        $content = str_replace('</p>', $back . '</p>', $content);
        $content = preg_replace('/(<p[^>]*>)/', '$1' . $front, $content);
        
        $footnote = $front . $content . $back;
        
        return $footnote;
      } elseif ($content !== $matches[1]) {
        // If no ids existed to be extracted
        return $content;
      } else {
        // Keep original in place
        return $matches[0];
      }
    };
    
    $content = preg_replace_callback(
      $footnotePattern,
      $insertFootnote,
      $content
    );
  }
  return $content;
}

add_filter('the_content', 'strip_content_tags');
function strip_content_tags($content)
{
  if (!is_admin() && is_home()) {
    return strip_tags($content, '<p><sup><sub>');
  }
  return $content;
}

add_filter('the_content', 'sub_sub_sup_tags');
function sub_sub_sup_tags($content)
{
  if (!is_admin()) {
    return preg_replace('/<sup>([123])<\/sup>/', '&sup$1;', $content);
  }
  return $content;
}

add_filter('the_content', 'format_soil');
add_filter('the_title', 'format_soil');
function format_soil($content) {
  if (!is_admin()) {
    // Match SO-IL with various hyphens between word boundries
    $content = replace_naked_soil($content);
    $content = replace_soil_in_tags($content);
  }
  return $content;
}

function replace_naked_soil($content)
{
  // http://www.phpliveregex.com/p/6FG
  $pattern = '/\bSO\s?[\-\x{2013}\x{2014}]\s?IL(?!\.org)(?![\-_])\b/u';
  $replacement = '<span class="wordmark">SO<span class="hyphen">&ndash;</span>IL</span>';
  return preg_replace($pattern, $replacement, $content);
}

function replace_soil_in_tags($content)
{
  $antipattern = '/(<[^>]*)(<span class="wordmark">SO<span class="hyphen">&ndash;<\/span>IL<\/span>)/';
  return preg_replace($antipattern, '$1SO-IL', $content);
}

add_action('admin_menu','my_admin_menu');
function my_admin_menu() {
  require_once('wp-admin-menu-classes.php');
  global $menu;
  $media = get_admin_menu_section('Media');
  $m = $menu[$media->index];
  unset($menu[$media->index]);
  $menu[21] = $m;
}

add_filter( 'gettext_with_context', 'fix_primes', null, 4 );
function fix_primes($translation, $text, $context, $domain) {
  switch ($context) {
    case 'double prime':
      return '&quot;';
      break;
    case 'prime':
      return '&#39;';
      break;
  }
  return $translation;
}

add_filter('request', 'set_feed_post_types');
function set_feed_post_types($qv) {
  if (isset($qv['feed']) && !isset($qv['post_type'])) {
    $args = array(
        'public'   => true,
        '_builtin' => false
    );
    $qv['post_type'] = get_post_types($args);
    array_push($qv['post_type'], 'post'); 
  }
  return $qv;
}

add_filter('query_vars', 'add_query_vars');
function add_query_vars($v) {
  $v[] = "archive_year";
  $v[] = "project_category_filter";
  $v[] = "extra_classes";
  return $v;
}

//add_filter('the_posts', 'filter_posts_by_year');
function filter_posts_by_year($posts)
{
  global $wp_query;
  if (is_post_type_archive('project')) {
    if ($year = (int) get_current_year()) {
      $posts = array_values(array_filter($posts, function($post) use (&$year) {
        return get_post_year($post) == $year;
      }));
    }
    
    if ($filter = $wp_query->get('project_category_filter')) {
      $posts = array_values(array_filter($posts, function($post) use (&$filter) {
        return $post->post_type == $filter;
      }));
    }
    
    array_map(function($p) {
      $p->date = get_field('date', $p->ID);
    }, $posts);
    
    usort($posts, function($a, $b) {
      if ($a->date == $b->date) {
        return strcmp(mb_strtolower($a->post_title,'UTF-8'), mb_strtolower($b->post_title,'UTF-8'));
      } else if ($a->date > $b->date) {
        return -1;
      } else {
        return 1;
      }
    });
    
  }
  
  return $posts;
}

add_filter('body_class', 'extra_body_classes');
function extra_body_classes($classes) {
  if (get_query_var('extra_classes')) {
    $extras = explode(',', get_query_var('extra_classes'));
    foreach ($extras as $c) {
      $classes[] = $c;
    }
  }

  if (in_array('single-project', $classes) && !in_array('project-overview', $classes)) {
    global $post;
    if (has_content($post)) {
      $classes[] = 'project-images';
    } else {
      $classes[] = 'project-images';
    }
  }

  global $posts;
  if (is_home() && count($posts)) {
    $display_style = get_field('feature_display_style', $posts[0]->ID);
    if ($posts[0]->post_type == 'writing' || $display_style == 'expanded') {
      $classes[] = 'writing-block-first';
    }
  }

  return $classes;
}

function should_show_loader()
{
  return !is_admin() && is_home() && get_field('show_loader', 'option');
}
