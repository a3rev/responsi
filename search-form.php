<div class="search_main">
    <form method="get" class="searchform" action="<?php echo esc_url(home_url('/')); ?>" >
        <input type="text" class="field s" name="s" value="<?php esc_attr_e(__('Search...', 'responsi')); ?>" onfocus="if (this.value == '<?php esc_attr_e(__('Search...', 'responsi')); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_attr_e(__('Search...', 'responsi')); ?>';}" />
        <input type="image" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/ico-search.png" alt="<?php esc_attr_e(__('Search', 'responsi')); ?>" class="submit" name="submit" />
    </form>
    <div class="clear"></div>
</div>