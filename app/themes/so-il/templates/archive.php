<?php $display_count = 0; ?>
<?php $row = array(); ?>

<table border="0" cellspacing="0" cellpadding="0" data-total-posts="">
  <?php while (have_posts()) : the_post(); ?>
    <?php $type = get_template_type(); ?>
    
    
    
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
