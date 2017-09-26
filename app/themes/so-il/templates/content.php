<div class="<?php echo get_post_type() ?> block">
  <header>
    <?php the_date_field('F Y') ?>
  </header>
  
  <div class="text">
    <h1><?php the_title() ?></h1>

    <article>
      <?php the_content() ?>
    </article>
  </div>
</div>
