<header class="banner container" role="banner">
  <div class="banner-inner">
  
    <nav class="main-nav" role="navigation">
      <div class="inner">
        <?php $alternate_header = get_subnavigation_string(); ?>
        <?php if ($alternate_header !== ""): ?>
          <?= $alternate_header ?>
        <?php else: ?>
          <?php if (has_nav_menu('primary_navigation')): ?>
            <?php wp_nav_menu(array('theme_location' => 'primary_navigation')); ?>
          <?php endif; ?>
        <?php endif ?>
      </div>
    </nav>
    

    <?php if(!is_page(1304)):?>
    <div class="sticky-container">
      <nav class="subnav">
        <div class="container">
          <div class="inner">
            <?php if (in_info_section()): ?>
              <?php soil_nav_menu('information_subnavigation') ?>
            <?php endif; ?>
        
            <?= get_subnavigation() ?>
          </div>
        </div>
      </nav>
    </div>
    <?php endif; ?>
  
  </div>
</header>

