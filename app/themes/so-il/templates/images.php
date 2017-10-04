<?php $image_count = 0 ?>
<?php $set_count = 0 ?>
<?php $image_data_set = 0 ?>

<div class="images">
  <div class="container <?php if(!in_project_overview()):?>block-slideshow<?php endif; ?>">
    <?php while (have_rows('images')) : $row = the_row(); ?>
      <?php if (is_home() && $image_count > 3) { break; } ?>
      
     
      
      <?php if (get_sub_field('media_type') == 'video'): ?>
        <?php if (get_sub_field('vimeo_id')): ?>
          <?php $vimeo_id = get_sub_field('vimeo_id'); ?>
          <?php $data = vimeo_data($vimeo_id); ?>
          
          <!-- image -->
          <div class="image <?php if(!in_project_overview()):?>project excerpt<?php endif; ?> video image-<?= $orientation ?> block <?php if($image_count == 1): ?>block-init<?php endif; ?> <?= $slide_color ?> <?= caption_state_class(get_sub_field('hide_popup_caption')) ?>"
              data-unique-id="<?php the_sub_field('unique_id') ?>"
              data-unique-set="<?= $image_data_set ?>">
              
              <?php if(!in_project_overview()):?>
                <div class="block-inner">
                  <div class="text">
                    
                    <div class="caption">
                      <div class="caption-inner">
                        <h1 class="slideshow-caption">
                          <div class="counter">
                            <?php the_slideshow_nav() ?>
                            <?php //the_counter() ?>
                          </div>
                          <div class="description">
                            <span class="title"><?php the_title() ?>&mdash;</span><?php if (get_sub_field('caption')): ?><?php the_sub_field('caption') ?><?php endif ?>
                          </div>
                      </h1>
                      </div>
                    </div>
                    
                  </div>
                </div>
                
                <?php

      
                  video_player(array(
                    "sound" => false,
                    "full_bleed" => true,
                    "data" => $data
                  ));
                ?>
                
              </div><!-- /image -->
              <?php else: ?>
                
                  <div class="inner">
              
                      <?php

      
                        video_player(array(
                          "sound" => false,
                          "full_bleed" => true,
                          "data" => $data
                        ));
                      ?>
              
                    <div class="caption">
                      <div class="caption-inner">
                        <div class="slideshow-caption">
                        <div class="counter">
                          <?php the_slideshow_nav() ?>
                          <?php //the_counter() ?>
                        </div>
                        <div class="description">
                          <span class="title"><?php the_title() ?>&mdash;</span><?php if (get_sub_field('caption')): ?><?php the_sub_field('caption') ?><?php endif ?>
                        </div>
                      </div>
                      </div>
                    </div>
                    <?php if(!in_project_overview()):?>
                    </div><!-- /text -->
                    <?php endif; ?>
                  </div>
                </div>
                
              <?php endif; ?>
              
            
          
            
         
          
        <?php endif ?>
      <?php else: ?>
        
        
        
        
        <?php $image = get_sub_field('image'); ?>
        <?php if ($image): ?>
          <?php
            $image_size = 'project-image'; 
            $image_url = $image['sizes'][$image_size];
            $image_ratio = $image['sizes']["$image_size-width"] / $image['sizes']["$image_size-height"];
            $orientation = $image_ratio > 1 ? 'landscape' : 'portrait';
            $full_bleed = get_should_full_bleed(true) ? "true" : "false";
            if (get_sub_field('full_bleed') === false) {
              $slide_color = 'black';
            } else {
              $slide_color = get_sub_field('caption_color');
            }
          ?>
          <?php if(!in_project_overview()):?>
          
          <?php $image_count = $image_count + 1 ?>
          <div class="image  project excerpt block <?php if($image_count == 1): ?>block-init<?php endif; ?> <?= $slide_color ?> <?= caption_state_class(get_sub_field('hide_popup_caption')) ?>"
              data-unique-id="<?php the_sub_field('unique_id') ?>">
            <div class="block-inner">
              <div class="text">
                <div class="caption">
                  <div class="caption-inner">
          
                    <h1 class="slideshow-caption">
          
                      <div class="counter">
                        <?php the_slideshow_nav() ?>
                        <?php //the_counter() ?>
                      </div>
                      <div class="description">
                        <?php the_title() ?><?php if (get_sub_field('caption')): ?> &mdash; <?php the_sub_field('caption') ?><?php endif ?>
                      </div>
                    </h1>

                    <?php if ($style == "expanded"): ?>
          
                      <article>
                        <?php //the_excerpt() ?>
                      </article>
          
                    <?php endif ?>

                  </div>
                </div>
              </div><!-- text -->
              
              <img src="<?= $image_url ?>"
                data-full-bleed="<?= $full_bleed ?>"
                data-ratio="<?= $image_ratio ?>">
              <!--
              <div class="caption">
                <div class="caption-inner">
                  <div class="description">
                    <?php //the_title() ?><?php if (get_sub_field('caption')): ?><?php the_sub_field('caption') ?><?php endif ?>
                  </div>
                </div>
              </div>
              -->
            </div>
            
            <?php
              if (!is_home()) {
                echo "<div class='background' data-image='$image_url' " .
                       "data-full-bleed='$full_bleed' " .
                       "data-ratio='$image_ratio'> " .
                     "</div>";
              }
            ?>
          </div>
        <?php else:?>
          <?php $image_count = $image_count + 1 ?>
           <?php $set_count = $set_count + 1 ?>
            
          <?php if($orientation == 'portrait' && $image_count > 1 && $set_count != 1 ): ?>
            <?php $image_data_set = $image_data_set + 1; ?>
          <?php endif; ?>
          
          <!-- image -->
          <div class="image image-<?= $orientation ?> block <?php if($image_count == 1): ?>block-init<?php endif; ?> <?= $slide_color ?> <?= caption_state_class(get_sub_field('hide_popup_caption')) ?>"
              data-unique-id="<?php the_sub_field('unique_id') ?>"
              data-unique-set="<?= $image_data_set ?>">
            <div class="inner">
              <img src="<?= $image_url ?>"
                data-full-bleed="<?= $full_bleed ?>"
                data-ratio="<?= $image_ratio ?>">
              <div class="caption">
                <div class="caption-inner">
                  <div class="slideshow-caption">
                  <div class="counter">
                    <?php the_slideshow_nav() ?>
                    <?php //the_counter() ?>
                  </div>
                  <div class="description">
                    <span class="title"><?php the_title() ?>&mdash;</span><?php if (get_sub_field('caption')): ?><?php the_sub_field('caption') ?><?php endif ?>
                  </div>
                </div>
                </div>
              </div>
            </div>
            
            <?php
              if (!is_home()) {
                echo "<div class='background' data-image='$image_url' " .
                       "data-full-bleed='$full_bleed' " .
                       "data-ratio='$image_ratio'> " .
                     "</div>";
              }
            ?>
          </div>
          <!-- /image -->
        
          <?php if($set_count == 2 || $orientation == 'portrait' ): $set_count = 0; ?>
            <?php $image_data_set = $image_data_set + 1; ?>
          <?php endif; ?>
        
        <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>
</div>
