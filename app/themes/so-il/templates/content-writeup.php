<div class="writeup block">
  <header>
    <?php the_date_field('Y') ?>
  </header>
  
  <?php if (get_field('link_type') == 'url'): ?>
    <a class="text" href="<?php the_field('url') ?>" target="_blank">
      <div class="inner">
        <h1><?php the_writeup_title() ?></h1>
      </div>
    </a>
  <?php elseif (get_field('link_type') == 'pdf'): ?>
    <a class="text" href="<?php the_field('pdf') ?>" onclick=”_gaq.push([‘_trackEvent’,’Download’,’PDF’,this.href]);” target="_blank">
      <div class="inner">
        <h1><?php the_writeup_title() ?> [PDF]</h1>
      </div>
    </a>
  <?php else: ?>
    <div class="text">
      <div class="inner">
        <h1><?php the_writeup_title() ?></h1>
      </div>
    </div>
  <?php endif; ?>
      
</div>
