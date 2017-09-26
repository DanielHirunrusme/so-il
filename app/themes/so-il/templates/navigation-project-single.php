<ul id="menu-primary-navigation" class="menu">
  <?php if (has_content($post)): ?>
    
    <li class="menu-images <?php if (!in_project_overview() || !has_content($post)) echo 'active'; ?>">
      <a href="<?php the_project_permalink() ?>">Images</a>
    </li>
    
    <li class="menu-overview <?php if (in_project_overview()) echo 'active'; ?>">
      <a href="<?php the_project_permalink() ?>overview/">Overview</a>
    </li>
    
  <?php else: ?>
    <li class="menu-images active">
      <a>Images</a>
    </li>
  <?php endif ?>

  <?php if ($pdf = get_field('pdf')): ?>
    <li class="menu-download-pdf">
      <a href="<?= $pdf ?>" target="_blank" onclick=”_gaq.push([‘_trackEvent’,’Download’,’PDF’,this.href]);”>Download PDF</a>
    </li>
  <?php endif ?>
  <a class="close" href="<?= project_close_link() ?>"><i></i></a>
</ul>
