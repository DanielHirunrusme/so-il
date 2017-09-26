<div class="writing block" data-href="<?php the_permalink() ?>">
  <div class="block-inner">
  
    <div class="text black">
      <div class="inner">
        <h1>
          <span class="for-mobile">Writing:</span>
          <?php the_writing_title() ?>
        </h1>

        <article>
          <?php the_content() ?>
        </article>
      </div>
    </div>

    <?= get_template_part('templates/related-posts') ?>
    <?= get_template_part('templates/counter') ?>
  
  </div>
</div>
