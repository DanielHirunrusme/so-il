<?php $image_count = 0 ?>
<?php //print_r(get_the_content()); ?>
<?php //preg_match_all('/(https?:\/\/\S+\.(?:jpg|png|gif))\s+/', get_the_content(), $results); ?>

<?php
//print_r($results);
$doc = new DOMDocument();
$doc->loadHTML( utf8_decode(get_the_content()) );
$imageTags = $doc->getElementsByTagName('img');

foreach($imageTags as $tag) {
    $src = $tag->getAttribute('src');
    $alt = $tag->getAttribute('alt');
    $srcArr[] = $src;
    $altArr[] = $alt;
}

?>

<div class="images">
  <div class="container <?php if(!in_project_overview()):?>block-slideshow<?php endif; ?>">
    <?php foreach($srcArr as $image): ?>
      <?php
        
      $image_size = 'project-image'; 
      $image_url = $srcArr[$image_count];
      //$image_ratio = $image['sizes']["$image_size-width"] / $image['sizes']["$image_size-height"];
      ?>
      <div class="image project excerpt block <?php if($image_count == 0):?> active <?php endif; ?>" data-unique-id="<?php the_sub_field('unique_id') ?>">
        <div class="block-inner">
          <div class="text">
            <div class="caption">
              <div class="caption-inner">
                <h1 class="slideshow-caption">
      
                  <div class="counter">
                    <?php the_slideshow_nav() ?>
                  </div>
                  <div class="description">
                    <?= $altArr[$image_count] ?>
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
          
          <img class="slideshow-image" src="<?= $image_url ?>" />
            
          
        </div>
        <div class="background" style="background-image:url(<?= $image_url ?>)" data-src="<?= $image_url ?>"></div>
      </div>

    
    <?php $image_count++; ?>
    <?php //echo $image; ?>
    <?php
    /*
      <?php if (is_home() && $image_count > 3) { break; } ?>
      <?php $image_count = $image_count + 1 ?>
      
      <?php if (get_sub_field('media_type') == 'video'): ?>
        <?php if (get_sub_field('vimeo_id')): ?>
          <?php $vimeo_id = get_sub_field('vimeo_id'); ?>
          <?php $data = vimeo_data($vimeo_id); ?>

          
        <?php endif ?>
      <?php else: ?>
        <?php $image = get_sub_field('image'); ?>
        <?php if ($image): ?>
          <?php
            $image_size = 'project-image'; 
            $image_url = $image['sizes'][$image_size];
            $image_ratio = $image['sizes']["$image_size-width"] / $image['sizes']["$image_size-height"];
            $full_bleed = get_should_full_bleed(true) ? "true" : "false";
            if (get_sub_field('full_bleed') === false) {
              $slide_color = 'black';
            } else {
              $slide_color = get_sub_field('caption_color');
            }
          ?>
          <?php if(!in_project_overview()):?>

          <div class="image project excerpt block <?= $slide_color ?> <?= caption_state_class(get_sub_field('hide_popup_caption')) ?>"
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
                        <?php the_title() ?>&mdash;<?php if (get_sub_field('caption')): ?><?php the_sub_field('caption') ?><?php endif ?>
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
                       "data-full-bleed='true' " .
                       "data-ratio='$image_ratio'> " .
                     "</div>";
              }
            ?>
          </div>
        <?php else:?>
          <div class="image block <?= $slide_color ?> <?= caption_state_class(get_sub_field('hide_popup_caption')) ?>"
              data-unique-id="<?php the_sub_field('unique_id') ?>">
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
                       "data-full-bleed='true' " .
                       "data-ratio='$image_ratio'> " .
                     "</div>";
              }
            ?>
          </div>
        <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    */
    ?>
    <?php endforeach; ?>
  </div>
</div>
