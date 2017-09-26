
<div class="archive-posts test">
  <div class="archive-posts-inner">
    <div class="block-slideshow page-slideshow init-slideshow">
      <?php if (have_posts()): ?>
        <?php if (is_post_type_archive('project')): ?>
           <?php get_template_part('templates/archive-custom', get_template_type()); ?>
          
    
          <?php //get_template_part('templates/archive'); ?>
        <?php else: ?>
          <?php if ( is_front_page() ): ?>
            
            <?php if (has_nav_menu('home_featured_projects')): ?>
              
              <?php
             
                  // Get post ids of items in the menu
                  $items = wp_get_nav_menu_items( 'Home Featured Projects' );

                  
                  foreach ( $items as $item ) {
             
                      $ids[] = get_post_meta( $item->ID, '_menu_item_object_id', true );
                  }
                  
             
                  
                  // var_dump( $ids );
                  if ( isset( $ids ) ) :
                      $args = array(
                          'posts_per_page' => 20, // # of posts to appear
                          'post_type' => array( 'project' ), // Post types
                          'post__in' => $ids,
                          'no_found_rows'  => true, 
                          'orderby' => 'post__in',
                          'order' => 'ASC',
                          'suppress_filters' => true,
                      );
                      
                      remove_all_actions( 'pre_get_posts' );
                      
                      $query = new WP_Query( $args );
                      
       
                      if ( $query->have_posts() ) :
                          while ( $query->have_posts() ) : $query->the_post(); ?>
                          <?php get_template_part('templates/content', get_template_type()); ?>
                          <?php endwhile;
                      endif;
                      wp_reset_query();
                  endif;
         
              ?>
            <?php endif; ?>
            
          <?php else: ?>
            <?php while (have_posts()) : the_post(); ?>
              <?php //echo get_template_type(); ?>
              <?php get_template_part('templates/content', get_template_type()); ?>
            <?php endwhile; ?>
          <?php endif; ?>
        <?php endif ?>
      <?php else: ?>
        <?= get_template_part('templates/none')?>
      <?php endif ?>
    </div>
  </div>
</div>

  <div class="sticky-container">
    <?= get_template_part('templates/archive-images') ?>
  </div>
 