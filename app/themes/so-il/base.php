<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <div class="wrap">
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>

    <div class="content" role="document">
      <div class="content-inner">
        <?php include roots_template_path(); ?>
      </div>
    </div>

    <?php get_template_part('templates/footer'); ?>
  </div>
  
  <div id="body-padding"></div>
  
  <?php if (should_show_loader()): ?>
    <div id="loader">
      <div class="headline">
        <?= format_soil('SO-IL'); ?>
      </div>
    </div>
  <?php endif ?>
  
  <?php if (WP_ENV == 'development'): ?>
    <!-- <div class="back-link">
      <?php echo project_close_link() ?>
    </div> -->
  <?php endif; ?>
  
  
</body>
</html>
