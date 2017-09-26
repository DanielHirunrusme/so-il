<?php
/*
Template Name: Contact
*/
?>

<div class="page-content">
  <div class="contact block">
    <div class="text">
      <div class="inner">
      
        <?= apply_filters('the_content', $post->post_content) ?>
        
    
        
        
        
        <div class="communications">
          <h1>Communications</h1>
          
          <div class="columns">
            
            <div>
              <a href="https://www.instagram.com/solidobjectives/" title="Instagram">Instagram</a><br>
              <a href="https://www.facebook.com/SolidObjectives/" title="Facebook">Facebook</a>
            </div>
            
            <div class="newsletter">
              <a class="show-newsletter-form">Newsletter</a>
              <form method="post" target="_blank" class="newsletter-form" action="http://so-il.us2.list-manage.com/subscribe/post?u=aabb4402aba8a410426a8fe2b&amp;id=064bfe0b3d">
                <div class="input-group">
                  <!--<label><?php _e('Email'); ?></label>-->
                  <input type="text" name="EMAIL" placeholder="Email:">
                </div>
                <div class="input-group">
                  <!--<label><?php _e('First Name'); ?></label>-->
                  <input type="text" name="FNAME"  placeholder="First Name:">
                </div>
                <div class="input-group">
                  <!--<label><?php _e('Last Name'); ?></label>-->
                  <input type="text" name="LNAME"  placeholder="Last Name:">
                </div>
                <a class="submit">Submit</a>
              </form>
            </div>
            
            
            
            
          </div>
          
        </div>
        
        <div class="contact-form">
          <h1>Contact Form</h1>
          <?php echo do_shortcode('[cscf-contact-form]'); ?>
        </div>
        
        <?php if (get_field('portfolio_pdf')): ?>
          <p>
            <a href="<?= get_field('portfolio_pdf') ?>" target="_blank">
              Download Portfolio
            </a>
          </p>
        <?php endif ?>
      
      </div>
    </div>
  </div>
</div>
