<div class="project block image <?php if($wp_query->current_post == 0): ?>block-init<?php endif; ?> post-num-<?php echo $wp_query->current_post +1; ?>  <?php the_project_classes() ?>"
    data-href="<?php the_featured_permalink() ?>">
  <div class="block-inner">
  
    <?php $style = get_project_display_style(); ?>
    
    <div class="text">
      <div class="inner">
          
        <h1 class="slideshow-caption">
          
          <div class="counter">
            <?php the_slideshow_nav() ?>
            <?php //the_counter() ?>
          </div>
          <div class="description">
            <?php the_title() ?>
          </div>
        </h1>

        <?php if ($style == "expanded"): ?>
          
          <article>
            <?php //the_excerpt() ?>
          </article>
          
        <?php endif ?>

      </div>
    </div>
    
    <?php if ($style == "expanded"): ?>
      <?= get_template_part('templates/images') ?>
      <?= get_template_part('templates/related-posts') ?>
      <?= get_template_part('templates/counter') ?>
    <?php else: ?>
      <?php the_project_background() ?>
    <?php endif ?>
  
  </div>
</div>
