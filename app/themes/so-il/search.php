<div class="search-results-content">
  <?php get_search_form(); ?>

  <?php if (have_posts()) : ?>
  
    <?php while (have_posts()) : the_post(); ?>
      <div class="block search-result">
        <a href="<?php the_permalink() ?>" class="text">
          <div class="inner">
            <h1>
              <?php 
                switch ($post->post_type) {
                  case 'project':
                    $categories = get_the_category();
                    if (count($categories) > 0) {
                      echo $categories[0]->name;
                      break;
                    }
                  case 'news-post':
                    echo 'News';
                    break;
                  default: 
                    echo ucfirst($post->post_type);
                }
              ?>: <?php the_title() ?>
            </h1>
        
            <article>
              <?php the_truncated_excerpt(20); ?>
            </article>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  
  <?php else: ?>
  
    <div class="block">
      <div class="text">
        <div class="inner">
          There are no posts matching your search term.
        </div>
      </div>
    </div>
  
  <?php endif; ?>
</div>
