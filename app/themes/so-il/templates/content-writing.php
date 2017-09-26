<div class="writing block">
  <?php if (!is_single()): ?>
    <a href="<?php the_permalink() ?>" class="text">
      <div class="inner">
        <h1>
          <?php the_writing_title() ?><span class="for-mobile">.</span>
        </h1>

        <article class="short-excerpt">
          <?php the_excerpt() ?>
        </article>
        
        <article class="long-excerpt tablet-vertical">
          <p><?php the_truncated_excerpt(150) ?></p>
        </article>
        
        <article class="shorter-excerpt tablet-horizontal">
          <p><?php the_truncated_excerpt(50) ?></p>
        </article>
        
        <article class="tiny-excerpt phone-vertical">
          <p><?php the_truncated_excerpt(30) ?></p>
        </article>

        <article class="micro-excerpt phone-horizontal">
          <p><?php the_truncated_excerpt(15) ?></p>
        </article>
      </div>
    </a>
  <?php else: ?>
    <div class="text">
      <div class="inner">
        <h1>
          <?php the_writing_title() ?>
        </h1>

        <article>
          <?php the_content() ?>
        </article>
      </div>
    </div>
    
    <div class="sticky-container">
      <?= get_template_part('templates/related-posts') ?>
    </div>
  <?php endif ?>
</div>
