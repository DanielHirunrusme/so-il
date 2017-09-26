<div class="news-post block">
  <header>
    <?php the_time('Y') ?>
  </header>
  
  <div class="text">
    <div class="inner">
      <div class="date">
        <?php the_time(DEFAULT_DATE_FORMAT) ?>
      </div>
    
      <h1><?php the_title() ?></h1>

      <article>
        <?php the_content() ?>
      </article>
    </div>
  </div>
</div>
