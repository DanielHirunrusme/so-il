<ul>
<?php
$menu = 'Projects Sub-navigation';
$args = array(
        'order'                  => 'ASC',
        'depth'                  => 0,
        'orderby'                => 'menu_order',
        'post_type'              => 'nav_menu_item',
        'post_status'            => 'publish',
        'output'                 => ARRAY_A,
        'output_key'             => 'menu_order',
        'nopaging'               => true,
        'update_post_term_cache' => false );
$items = wp_get_nav_menu_items( $menu, $args ); 

//print_r($items);

$host = $_SERVER['REQUEST_URI'];

foreach($items as $item):
  if ( $item->menu_item_parent == 0 ) :
    //print_r($item);
    //print $item->url;
    $base = $item->title != 'All' ? '/projects/type/'.strtolower($item->title) : '/projects/';
    $urlmatch = '/projects/type/'.strtolower($item->title);
?>
<li class="project-archive-section project-archive-categories <?php if($item->title == 'All' && $host == '/projects/'): ?>active<?php elseif($item->title != 'All' && strpos($host, $base) !== false): ?>active<?php endif; ?> <?php if($item->title == 'All'): ?>all-category<?php endif; ?>"><a href="<?= $base ?>"><?= $item->title; ?></a></li>
<?php endif; endforeach; ?>
</ul>

<?php $categories = get_project_archive_categories(); ?>
<?php $years = get_post_archive_years(); ?>
<!--
<ul>
  <?php if ($categories): ?>
    <li class="project-archive-section project-archive-categories">
      <ul>
        <?= project_archive_nav_link('Selected', array('category' => 'selected')) ?>
        <?= project_archive_nav_link('All', array('category' => null)) ?><br>
        <?php foreach ($categories as $category): ?>
          <?php if ($category[0] != 'uncategorized' && $category[0] != 'selected'): ?>
            <?= project_archive_nav_link($category[1], array(
              'category' => $category[0]
            )) ?>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </li>
  <?php endif ?>
  <?php
  /*
  <li class="project-archive-section project-archive-years">
    <ul>
      <?= project_archive_nav_link('All', array('year' => null)) ?>
      <?php if ($years): ?>
        <?php foreach ($years as $year): ?>
          <?= project_archive_nav_link($year, array('year' => $year)) ?>
        <?php endforeach ?>
      <?php elseif ($the_year = get_current_year()): ?>
        <?= project_archive_nav_link($the_year, array('year' => $the_year))?>
      <?php endif ?>
    </ul>
  </li>
  */
  ?>
</ul>
-->