<div class="page-content">
  <?php if (post_password_required() || is_page_template('page-simple.php')): ?>
    <div class="block">
      <div class="text">
        <div class="inner">
          <article class="page-slideshow">
            <?php the_content() ?>
          </article>
        </div>
      </div>
    </div>
  <?php else: ?>
    <?php while (have_rows('sections')) : the_row(); ?>
      <div class="subsection block" id="<?= strtoid(get_sub_field('subtitle')) ?>">
        <header>
          <?= apply_filters('the_title', get_sub_field('subtitle')) ?>
        </header>

        <div class="text">
          <div class="inner">
            <article>
              <?= apply_filters('the_content', get_sub_field('text')) ?>
            </article>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif ?>
  
  <div class="sticky-container">
    <?= get_template_part('templates/page-images') ?>
  </div>
</div>
