<div class="block search-form">
  <div class="text">
    <div class="inner">
      <form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
        <div class="input-group">
          <label class="hide"><?php _e('Search'); ?></label>
          <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s">
        </div>
      </form>
    </div>
  </div>
</div>
