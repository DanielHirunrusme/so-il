<?php

function the_writing_title($id = false)
{
  if (is_object($id)) {
    $post = $id;
  } else {
    $post = get_post($id);
  }
  
  $title = get_the_title($post);
  $publication = get_field('publication', $post->ID);
  $date = get_field('date', $post->ID);
  
  $parts = array();
  $parts[] = "&ldquo;" . $title . ($publication || $date ? ',' : '') . "&rdquo; ";
  if ($publication) {
    $parts[] = "<em>" . $publication . "</em>";
    if ($date) {
      $parts[] = ", ";
    }
  }
  if ($date) {
    $parts[] = get_date_field();
  }
  echo implode($parts);
}

function the_publication_title()
{
  $parts = array();
  $parts[] = "&ldquo;" . get_the_title() . (get_field('publisher') || get_field('date') ? ',' : '') . "&rdquo; ";
  if (get_field('publisher')) {
    $parts[] = get_field('publisher');
    if (get_field('date')) {
      $parts[] = ", ";
    }
  }
  if (get_field('date')) {
    $parts[] = get_date_field();
  }
  echo implode($parts);
}

function the_writeup_title($id = False)
{
  if (is_object($id)) {
    $post = $id;
  } else {
    $post = get_post($id);
  }
  
  $title = get_the_title($post);
  $publication = get_field('publication', $post->ID);
  $date = get_field('date', $post->ID);
  
  $parts = array();
  $parts[] = "&ldquo;" . $title . ($publication || $date ? ',' : '') . "&rdquo; ";
  if ($publication) {
    $parts[] = "<em>" . $publication . "</em>";
    if ($date) $parts[] = ", ";
  }
  if ($date) {
    $parts[] = get_date_field();
  }
  echo implode($parts);
}

function the_extended_project_title($id = false)
{
  if (is_object($id)) {
    $post = $id;
  } else {
    $post = get_post($id);
  }
  
  $parts = array();
  $parts[] = get_the_title($post->ID).', ';
  if (get_field('location', $post->ID)) {
    $parts[] = get_field('location', $post->ID);
  }
  
  //$parts[] = implode($parts, ", ");
  
  if (get_post_year($post)) {
    $parts[] = get_post_year($post);
  }
  echo implode($parts, "");
}

function get_date_field($format=DEFAULT_DATE_FORMAT, $key='date')
{
  $date = DateTime::createFromFormat('Ymd', get_field('date'));
  return ($date ? $date->format($format) : '');
}

function the_date_field($format=DEFAULT_DATE_FORMAT, $key='date')
{
  echo get_date_field($format, $key);
}

function page_in_navigation($location='primary_navigation')
{
  global $post;
  if (is_page() && ($locations = get_nav_menu_locations()) && isset($locations[$location])) {
    $menu = wp_get_nav_menu_object($locations[$location]);
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    foreach ($menu_items as $item) {
      if ($item->type_label === "Page" && intval($item->object_id) === $post->ID) 
        return true;
    }
  }
  return false;
}

/*
function nl2p($string, $line_breaks = true, $xml = true) {

$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

// It is conceivable that people might still want single line-breaks
// without breaking into a new paragraph.
if ($line_breaks == true)
    return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
else 
    return '<p>'.preg_replace(
    array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
    array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),

    trim($string)).'</p>'; 
}
*/

function nl2p($string)
{
    $paragraphs = '';

    foreach (explode("\n", $string) as $line) {
        if (trim($line)) {
            $paragraphs .= '<p>' . $line . '</p>';
        }
    }

    return $paragraphs;
}

function the_post_number()
{
  global $wp_query;
  $per_page = $wp_query->query_vars["posts_per_page"];
  $page = $wp_query->query_vars["paged"];
  if ($page === 0) $page = 1;
  echo ($page - 1) * $per_page + $wp_query->current_post + 1;
}

function is_viewing_post_type($types)
{
  if (!is_array($types)) $types = array($types);
  $type = get_post_type();
  return in_array($type, $types) || is_post_type_archive($types);
}

function the_project_categories()
{
  $categories = get_the_category();
  foreach ($categories as $category) {
    echo '<span class="category">' . $category->name . '</span>';
  }
}

function caption_state_class($hide_caption)
{
  return $hide_caption ? "hide-caption" : "show-caption";
}
function the_project_classes()
{
  
  $classes = array(
    get_project_color(),
    get_project_display_style(),
    caption_state_class(get_field('hide_caption'))
  );
  echo implode(' ', $classes);
}

function get_project_color()
{
  if (get_field('full_bleed') === false || get_project_display_style() == 'expanded') {
    return 'black';
  } else {
    return get_field('featured_text_color');
  }
}

function get_project_display_style()
{
  $display_style = get_field('feature_display_style');
  if ($display_style) {
    return $display_style;
  } else {
    return 'excerpt';
  }
}

function the_related_post_links()
{
  $related = get_related_posts();
  foreach ($related as $index => $rproject) {
    $href = get_the_permalink($rproject);
    if (is_home()) {
      echo "<div class='related_post'>";
    } else {
      echo "<a href='$href' class='related_post'>";
    }
    switch ($rproject->post_type) {
      case 'project':
        the_extended_project_title($rproject);
        break;
      case 'writing':
        the_writing_title($rproject);
        break;
      default:
        echo get_the_title($rproject);
        break;
    }
    if (is_home()) {
      echo "</div>";
    } else {
      echo "</a>";
    }
  }
}

function get_related_posts()
{
  global $post;
  if ($post->post_type == 'project') {
    return get_field('related_projects');
  } else {
    return get_field('related_writings');
  }
}

function sort_the_projects($projects)
{
  @usort($projects, function($a, $b) {
    $a_year = get_field('year', $a->ID);
    $b_year = get_field('year', $b->ID);
    
    $exhcmp = $b_year - $a_year;
    if(!$exhcmp) return strcmp($a->post_title, $b->post_title);
    return $exhcmp;
  });
  return $projects;
}

function extract_image_ids(&$content)
{
  global $post;
  $ids = array();
  $getUniqueIDs = function($image){
    return $image['unique_id'];
  };
  $images = get_field('images', $post->ID);
  $valid_ids = array_map($getUniqueIDs, $images);
  
  while ($id = pop_id($content)) {
    if (in_array($id, $valid_ids)) {
      array_unshift($ids, intval($id));
    }
  }
  
  return $ids;
}

function has_id($footnote)
{
  return preg_match('/\s+\d+$/', $footnote);
}

function pop_id(&$footnote)
{
  if (has_id($footnote)) {
    $parts = preg_split('/\s+(?=\d+$)/', $footnote);
    $id = intval(end($parts));
    $footnote = $parts[0];
  } else {
    $id = false;
  }
  return $id;
}

function the_truncated_excerpt($length = 20)
{
  $content = apply_filters('the_content', get_the_content());
  $trimmed_content = wp_trim_words( $content, $length, ' [...]' );
  echo $trimmed_content;
}

function the_project_background()
{
  if (get_project_display_style() == "excerpt_video" && get_field('featured_vimeo_id')) {
    $vimeo_id = get_field('featured_vimeo_id');
    $data = vimeo_data($vimeo_id);
    
    video_player(array(
      "sound" => get_field('featured_play_sound'),
      "full_bleed" => get_should_full_bleed(),
      "data" => $data
    ));
  } else {
    $image = get_field('homepage_image');
    $image_url = $image['sizes']['project-image'];
    $image_ratio = $image['sizes']['project-image-width'] / $image['sizes']['project-image-height'];
    $full_bleed = get_should_full_bleed();

    background($image_url, $image_ratio, $full_bleed);
  }
}

function background($url, $ratio, $full_bleed)
{
  $full_bleed = $full_bleed ? "true" : "false";
  echo "<div class='background' data-image='$url' " .
         "data-full-bleed='$full_bleed' " .
         "data-ratio='$ratio'> " .
       "</div>";
}

function get_should_full_bleed($sub = false)
{
  if ($sub) {
    if (get_sub_field('full_bleed')) {
      return true;
    } else {
      return false;
    }
  } else {
    $bleed = get_field('full_bleed', false, false);
    if ($bleed === false || $bleed == '1') {
      // The value hasn't been set yet if === false
      return true;
    } else {
      return false;
    }
  }
}

function the_featured_permalink()
{
  $permalink = get_permalink();
  echo str_replace('/archive', '/featured', $permalink);
}

function the_project_permalink()
{
  global $post;
  if (get_field('is_featured', $post->ID)) {
    the_featured_permalink();
  } else {
    the_permalink();
  }
}

function the_stripped_content()
{
  echo wp_strip_all_tags(apply_filters("the_content", get_the_content()));
}

function vimeo_data($vimeo_id)
{
  global $VIMEO;
  $query_key = 'vimeo_request_' . md5($vimeo_id);
  
  $result = wp_cache_get($query_key, 'vimeo');
  if ($result !== false) return $result;
  
  $request = $VIMEO->request("/videos/" . $vimeo_id);
  $result = $request['body'];
  
  wp_cache_set($query_key, $result, 'vimeo');
  
  return $result;
}

function in_info_section()
{
  return is_viewing_info_resource() ||
    page_in_navigation('information_subnavigation');
}

function is_viewing_info_resource()
{
  return is_viewing_post_type(array('news-post', 'writeup', 'lecture')) &&
    !is_search();
}


class SoilWalker extends Walker_Nav_Menu {
  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $rows = get_field('sections', $item->object_id);
    if ($rows) {
      $post = get_post($item->object_id);
      $output .= '<ul class="controls">';
      foreach ($rows as $row) {
        $title = apply_filters('the_title', $row['subtitle']);
        $output .= 
          "<li class='control-item'>" .
            "<a class='control' href='" . get_the_permalink($post) . "#" . strtoid($row['subtitle']) . "'>" . 
              $title . 
            "</a>" . 
          "</li>";
      }
      $output .= '</ul>';
    }
    $output .= "</li>\n";
  }
}

function soil_nav_menu($name)
{
  wp_nav_menu(array('theme_location' => $name, 'walker' => new SoilWalker));
}

function strtoid($title)
{
  return preg_replace('/\W+/', '-', strtolower($title));
}

function get_template_type()
{
  if (is_home()) {
    return 'featured';
  } else {
    return get_post_type();
  }
}

function get_navigation()
{
  global $wp_query;
  $part = $wp_query->query_vars['post_type'];
  if (is_array($part)) $part = $part[0];
  if (is_post_type_archive($part) || is_home()) {
    $part .= '-archive';
  } else {
    $part .= '-single';
  }
  get_template_part('templates/navigation', $part);
}

function get_subnavigation()
{
  global $wp_query;
  $part = $wp_query->query_vars['post_type'];
  if (is_array($part)) $part = $part[0];
  if (is_post_type_archive($part)) {
    $part .= '-archive';
  } else {
    $part .= '-single';
  }
  get_template_part('templates/subnavigation', $part);
}

function get_subnavigation_string()
{
  ob_start(); 
  get_navigation();
  $alternate_header = ob_get_contents();
  ob_end_clean();
  return $alternate_header;
}

function get_post_archive_years()
{
  global $posts;
  $years = array_unique(array_map('get_post_year', $posts));
  rsort($years);
  return $years;
}

function get_post_year($post)
{
  if ($date = get_field('date', $post->ID)) {
    return '<date>, '.(int) substr($date, 0, 4).'</date>';
  } else if($year = get_field('year', $post->ID)) {
    return '<date>, '.(int) $year.'</date>';
  }
}

function project_archive_nav_link($content='', $params=array())
{
  $href = '/projects/';
  $classes = array('control-item');
  
  $current_category = get_current_category();
  $current_year = get_current_year();
  
  if (array_key_exists('category', $params)) {
    if ($params['category'] != null){
      $href .= 'type/' . $params['category'] . "/";
    }
  } elseif ($current_category) {
    $href .= 'type/' . $current_category . "/";
  }
  
  if (array_key_exists('year', $params)) {
    if ($params['year'] !== null){
      $href .= 'year/' . $params['year'] . '/';
    }
  } elseif ($current_year) {
    $href .= 'year/' . $current_year . '/';
  }
  
  if ($href == $_SERVER['REQUEST_URI']) {
    $classes[] = 'active';
  }
  
  echo "<li class=\"control-item " . implode($classes, ' ') . "\">" .
    "<a href=\"$href\">$content</a>" .
  "</li>";
}


function get_current_category()
{
  global $wp_query;
  if ($wp_query->get('project_category_filter')) {
    return urldecode($wp_query->get('project_category_filter'));
  }
  if(isset($wp_query->query_vars['category_name'])) {
     return urldecode($wp_query->query_vars['category_name']);
  }
  return false;
}

function get_current_year()
{
  global $wp_query;
  if(isset($wp_query->query_vars['archive_year'])) {
    return urldecode($wp_query->query_vars['archive_year']);
  }
  return false;
}

/*
function project_close_link()
{
  if (isset($_SESSION['project_back'])) {
    //return '/projects/type/selected';
    return $_SESSION['project_back'];
  } else if (preg_match('/^\/featured/', $_SERVER["REQUEST_URI"])) {
    return '/';
  } else {
    return '/projects/type/selected';
  }
}

function in_project_overview()
{
  return preg_match('/(overview)\/?$/', $_SERVER["REQUEST_URI"]);
}
*/

function project_close_link()
{
  if (isset($_SESSION['project_back'])) {
    return $_SESSION['project_back'];
  } else if (preg_match('/^\/featured/', $_SERVER["REQUEST_URI"])) {
    return '/';
  } else {
    return '/projects/type/selected';
  }
}

function in_project_overview()
{
  return preg_match('/(overview)\/?$/', $_SERVER["REQUEST_URI"]);
}

function get_project_archive_categories()
{
  $categories = get_categories();
  $faux = array_map(function($cat){
    return [$cat->slug, $cat->name];
  }, $categories);
  $faux[] = ['writing', 'Writing'];
  $faux[] = ['publication', 'Publication'];
  sort($faux);
  return $faux;
}


function end_row($row, $display_count)
{
  return has_filled_row($row) || balances_row($row, $display_count);
}

function has_filled_row($row)
{
  return count($row) == 2;
}

function balances_row($row, $display_count)
{
  return ($display_count - array_sum($row)) % 2 != 0;
}

function the_first_image()
{
  $images = get_field('images');
  //print_r($images);
  if ($images):
    $image = archive_thumbnail_or_first($images);
    if (!$image) return;
    if ($image['vimeo_id']) {
      $data = vimeo_data($image['vimeo_id']);
      
      video_player(array(
        "sound" => false,
        "full_bleed" => true,
        "data" => $data
      ));
    } else {
  
      $thumb = $image['image']['sizes']['thumbnail'];
      $image = $image['image'];
      $image_size = 'project-thumb';
      $image_url = $image['sizes'][$image_size];
      $image_ratio = $image['sizes']["$image_size-width"] / $image['sizes']["$image_size-height"];
      $image_orientation = $image_ratio < 1 ? 'vertical' : 'horizontal';
      //style='background-image:url($image_url)'
      echo "<div class='image' style='background-image:url(".$image_url.")'>" .
              "<img src='$image_url' class='$image_orientation'>" .
           "</div>";
    
      // "<img data-src='$image_url' class='$image_orientation'>" . for lazy loading
    }
  endif;
}

//add_filter("the_content", "the_content_deck");

function the_content_deck($content)
{
  // Take the existing content and return a subset of it
  $sentence = preg_split( '/(\.|!|\?)\s/', $content, 2, PREG_SPLIT_DELIM_CAPTURE );
  $sentence = $sentence['0'] . $sentence['1'];
  
  $temp = wp_strip_all_tags($sentence);
  //echo $temp;
  if(substr($temp, 0, 1) == '[') {
     list($a, $b) = explode('[', $sentence);
     echo $b;
  } else {
     echo $sentence;
  }
  
}



function the_content_remaining($content)
{
  // Take the existing content and return a subset of it
  $sentence = preg_split( '/(\.|!|\?)\s/', $content, 2, PREG_SPLIT_DELIM_CAPTURE );
  $sentence = $sentence['0'] . $sentence['1'];
  
  $sentences = explode( '.', $sentence );

  $new_string = str_replace($sentence, '', $content);
  $new_string = '['.$new_string;
  
  $new_string = nl2p($new_string, false);
  $new_string = preg_replace("#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#", "", $new_string);
  
  echo insert_footnotes($new_string);
  
}

function video_player($options)
{ 
  $full_bleed = $options['full_bleed'];
  $sounds = $options['sound'];
  $data = $options['data'];
  
  if (!isset($data['pictures'])) {
    return;
  }
  
  $poster = $data['pictures'][0]['link'];
  $ratio = $data['width'] / $data['height'];
  $sources = $data['files'];
  
  ?>
  <div class="video-player <?= $full_bleed ? "full-bleed" : "no-full-bleed" ?>"
      data-play-sound="<?= $sounds ? "true" : "false" ?>">
    <div class="video-positioner"
        data-full-bleed="<?= $full_bleed ? "true" : "false" ?>"
        data-poster="<?= $poster ?>"
        data-ratio="<?= $ratio ?>" style="background:url(<?= $poster ?>) no-repeat center center cover">
      <video data-poster="<?= $poster ?>" preload="none" loop>
        <?php foreach ($sources as $source): ?>
          <?php if ($source['quality'] !== 'hls'): ?>
            <source src="<?= $source['link'] ?>" type='video/mp4'>
          <?php endif ?>
        <?php endforeach ?>
      </video>
      <img class="for-mobile for-flash-video video-poster" data-src="<?= $poster ?>">
      <div class="for-mobile play-button"></div>
    </div>
  </div>
  
<?php }

function archive_thumbnail_or_first($images)
{
  $id = get_field('archive_thumbnail_id');
  if (!$id) {
    return $images[0];
  } else {
    foreach ($images as $image) {
      if ($image['unique_id'] == $id) return $image;
    }
  }
  return $images[0];
}

function project_field($label, $field_name)
{
  $field = apply_filters('the_title', get_field($field_name));
  if ($field) {
    echo "<h4>$label</h4>";
    $field = strip_tags(get_field($field_name));
    
    echo '<div class="field-container-'.$field_name.'">';
    echo nl2p($field);
    echo '</div>';
  }
}

function has_content($post)
{
  return !preg_match('/^\s*$/', $post->post_content);
}

function the_counter()
{
  global $wp_query;
  echo $wp_query->current_post + 1 . "/" . $wp_query->found_posts;
}

function the_slideshow_nav()
{
  global $wp_query;
  echo "<button class='prev-image slideshow-nav'>Prev</button>, <button class='next-image slideshow-nav'>Next</button>";
}

function the_lecture_notes()
{
  $notes = get_field('extra_notes');
  if ($notes) {
    echo ', ' . apply_filters('the_title', strip_tags($notes, '<a>'));
  }
}
