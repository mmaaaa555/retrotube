<div class="header-search <?php if(xbox_get_field_value( 'wpst-options', 'header-ad-desktop' ) != '') : ?>small-search<?php endif; ?>">
    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">        
        <?php if( get_search_query() ): ?>
            <input class="input-group-field" type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
        <?php else: ?>
            <input class="input-group-field" value="<?php esc_html_e('Search...', 'wpst'); ?>" name="s" id="s" onfocus="if (this.value == '<?php esc_html_e('Search...', 'wpst'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_html_e('Search...', 'wpst'); ?>';}" type="text" />
        <?php endif; ?>
        
        <input class="button fa-input" type="submit" id="searchsubmit" value="&#xf002;" />        
    </form>
</div>