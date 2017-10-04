<?php if (is_single()): ?>
  
  <?php if (has_content($post) && !in_project_overview()): ?>
    
    <?= get_template_part('templates/images') ?>
  <?php elseif(in_project_overview()): ?>
    
    <div class="<?= get_post_type() ?> block overview-block">
      <div class="text">
        <div class="inner">
          <h1><?php the_extended_project_title() ?></h1>
          
          <article>
            
            <?php if (get_field('is_first_large') == 1): ?>
              <?php $content = get_the_content(); ?>
              <h1><?php the_content_deck($content); ?></h1>
              <?php the_content_remaining($content); ?>
            <?php else: ?>
            <?php the_content() ?>
            <?php endif; ?>
            
            <?= get_template_part('templates/related-posts') ?>
            
            
          </article>
        </div>
      </div>
      
      <div class="sticky-container">
        <?= get_template_part('templates/images') ?>
        
        
        
      </div>
      
      
      <div class="related-right">
        <div class="inner">
        <?php project_field('Client', 'client') ?>
        <?php project_field('Location', 'location') ?>
        <?php project_field('Program', 'program') ?>
        
        <?php if (get_field('area_meters') || get_field('area_feet')): ?>
          <p>
            <em>Area</em><br>
            <?php if (get_field('area_meters')): ?>
              <?php the_field('area_meters') ?> m&sup2; 
            <?php endif ?>
            
            <?php if (get_field('area_meters') || get_field('area_feet')): ?>
              / 
            <?php endif; ?>
            
            <?php if (get_field('area_feet')): ?>
              <?php the_field('area_feet') ?> sf
            <?php endif ?>
          </p>
        <?php endif ?>
        
        <?php project_field('Status', 'status') ?>
        <?php project_field('Team', 'team') ?>
        <?php project_field('Collaborators', 'collaborators') ?>
        
        <?php if (get_field('press')): ?>
          <p>
            Press<br>
            <?php foreach (get_field('press') as $writeup): ?>
              <?php the_writeup_title($writeup->ID) ?>
            <?php endforeach ?>
          </p>
        <?php endif ?>
        
        <?php if (get_field('miscellaneous')): ?>
          <?php while (have_rows('miscellaneous')) : the_row(); ?>
            <p>
              <?= apply_filters('the_title', get_sub_field('misc_title')) ?><br>
              <?= apply_filters('the_title', get_sub_field('misc_text')) ?>
            </p>
          <?php endwhile; ?>
        <?php endif ?>
      </div>
      </div>
      
      
    </div>
    <?php else: ?>
      <div class="images single-image active popup">
        <a href="<?php the_permalink() ?>" class="<?= get_post_type() ?> image block">
          <div class="block-inner">
            <div class="caption">
              <div class="caption-inner">
                <div class="slideshow-caption">
                  
                  <div class="text">
                    <h1>
                      <?php the_extended_project_title() ?>
                    </h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <?php the_first_image() ?>
          
        </a>
      </div>
    <?php endif; ?>
    <?php else: ?>

        <a href="<?php the_permalink() ?>" class="<?= get_post_type() ?> block">
          <div class="inner">
        
            <?php the_first_image() ?>
                  <div class="text">
                    <h1>
                      <?php the_extended_project_title() ?>
                    </h1>
                  </div>
                
          </div>
        </a>
 

  <?php endif; ?>
  
 

