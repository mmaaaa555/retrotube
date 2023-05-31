<?php if(!is_single() && !is_page()) : ?>
    <div id="filters">        
        <div class="filters-select"><?php if( !wp_is_mobile() ) : ?><?php echo wpst_get_filter_title(); ?><?php else : ?><i class="fa fa-filter"></i><?php endif; ?>
            <div class="filters-options">
                <?php $paged = get_query_var( 'paged', 1 ); ?>
                <?php if( $paged === 0 ) : ?>	
                    <span><a class="<?php echo wpst_selected_filter('latest'); ?>" href="<?php echo add_query_arg('filter', 'latest'); ?>"><?php esc_html_e('Latest videos', 'wpst'); ?></a></span>
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-views-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('most-viewed'); ?>" href="<?php echo add_query_arg('filter', 'most-viewed'); ?>"><?php esc_html_e('Most viewed videos', 'wpst'); ?></a></span><?php endif; ?>
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-duration-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('longest'); ?>" href="<?php echo add_query_arg('filter', 'longest'); ?>"><?php esc_html_e('Longest videos', 'wpst'); ?></a></span><?php endif; ?>			
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('popular'); ?>" href="<?php echo add_query_arg('filter', 'popular'); ?>"><?php esc_html_e('Popular videos', 'wpst'); ?></a></span><?php endif; ?>			
                    <span><a class="<?php echo wpst_selected_filter('random'); ?>" href="<?php echo add_query_arg('filter', 'random'); ?>"><?php esc_html_e('Random videos', 'wpst'); ?></a></span>	
                <?php else : ?>
                    <span><a class="<?php echo wpst_selected_filter('latest'); ?>" href="<?php echo wpst_get_nopaging_url(); ?>?filter=latest"><?php esc_html_e('Latest videos', 'wpst'); ?></a></span>
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-views-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('most-viewed'); ?>" href="<?php echo wpst_get_nopaging_url(); ?>?filter=most-viewed"><?php esc_html_e('Most viewed videos', 'wpst'); ?></a></span><?php endif; ?>				
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-duration-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('longest'); ?>" href="<?php echo wpst_get_nopaging_url(); ?>?filter=longest"><?php esc_html_e('Longest videos', 'wpst'); ?></a></span><?php endif; ?>				
                    <?php if( xbox_get_field_value( 'wpst-options', 'enable-rating-system' ) == 'on' ) : ?><span><a class="<?php echo wpst_selected_filter('popular'); ?>" href="<?php echo wpst_get_nopaging_url(); ?>?filter=popular"><?php esc_html_e('Popular videos', 'wpst'); ?></a></span><?php endif; ?>			
                    <span><a class="<?php echo wpst_selected_filter('random'); ?>" href="<?php echo wpst_get_nopaging_url(); ?>?filter=random"><?php esc_html_e('Random videos', 'wpst'); ?></a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>