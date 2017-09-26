<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>

  <?php wp_head(); ?>

  <script type="text/javascript">
    videojs.options.flash.swf = "<?php echo get_template_directory_uri() ?>/assets/js/vendor/video-js.swf"
  </script>

  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
  
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon.png">
  
  <?php if (is_post_type_archive('project') ||
            is_post_type_archive('news-post') ||
            is_post_type_archive('lecture') ||
            is_post_type_archive('writeup') ||
            is_home() ||
            is_page()): ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <?php else: ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php endif ?>
  
  <?php if (WP_ENV == 'production'): ?>
    <!-- Google Analytics -->
    <script type="text/javascript">
       var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-19487039-1']);
      _gaq.push(['_trackPageview']);

      (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })(); 
    </script>
  <?php endif ?>
  
</head>
