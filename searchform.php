<?php
/**
 * The template for displaying search form
 *
 * @package Cielos
 * @since   unomoon 1.0.0
 */

?>

<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>"
  class="widget-search">
  <label class="sr-only" for="s">
    <?php esc_attr_e('Search', 'cielos'); ?>
  </label>
  <input type="text" class="widget-search-input"
    value="" name="s" id="s" aria-label="Search" placeholder="<?php esc_attr_e('Search', 'cielos'); ?>">
  <button type="submit" id="searchsubmit" class="widget-search-button">
    <?php esc_attr_e('Search', 'cielos'); ?>
  </button>
</form>
