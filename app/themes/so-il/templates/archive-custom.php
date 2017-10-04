<?php $display_count = 0; ?>
<?php $row = array(); ?>

           <?php if ( $items = wp_get_nav_menu_items( 'Projects Sub-navigation' )): ?>
             <?php 
               
               $host = $_SERVER['REQUEST_URI']; 
               $matchID = 4712; //default ALL projects
             ?>
             <?php 
             foreach($items as $item):
                //if($item->title == 'All'): print_r($item); endif;
                $base = $item->title != 'All' ? '/projects/type/' : '';
                $urlmatch = $base.strtolower($item->title);
                if(strpos($host, $urlmatch) !== false):
                  $matchID = $item->ID;
                  break;
                endif;
             endforeach; 
             
             foreach($items as $item):
               if($item->menu_item_parent == $matchID):
                 $ids[] = get_post_meta( $item->ID, '_menu_item_object_id', true );
               endif;
             endforeach; 
             
              ?>
           <?php endif; ?>
           
           <?php
         
           if ( isset( $ids ) ) :
               $args = array(
                   'posts_per_page' => 9999, // # of posts to appear
                   'post_type' => array( 'project', 'writing', 'lectures', 'publication' ), // Post types
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
                   
                   <?php endwhile;
               endif;
               wp_reset_query();
           endif;
           
           ?>

<table border="0" cellspacing="0" cellpadding="0" data-total-posts="">
  <?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php $type = get_template_type(); ?>
    
    <?php
    
      //update_post_meta( $post->ID, 'is_first_large', 1 );
      
    ?>
    
    <?php if (!$row): ?>
      <tr>
    <?php endif ?>
      
      <?php if ($type == 'writing'): ?>
        <?php $row_span = 2; ?>
      <?php else: ?>
        <?php $row_span = 1; ?>
      <?php endif ?>
      
      <td rowspan="<?= $row_span ?>">
        <?php get_template_part('templates/content', $type); ?>
      </td>
      
      <?php $display_count += $row_span ?>
      <?php $row[] = $row_span; ?>
    
    <?php if (end_row($row, $display_count)): ?>
      </tr>
      <?php if (array_sum($row) == 4): ?>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
      <?php endif ?>
      <?php $row = array() ?>
    <?php endif; ?>
  <?php endwhile; ?>
  <?php if (!end_row($row, $display_count)): ?>
    <td>&nbsp;</td></tr>
  <?php endif ?>
</table>
