<?php if ( !wp_is_mobile() && xbox_get_field_value( 'wpst-options', 'logo-watermark-video-player' ) == 'on' ) : ?>  
	<div id="logo-watermark">
		<?php if ( xbox_get_field_value( 'wpst-options', 'image-logo-watermark-file' ) != '' ) : ?>
            <img class="logo-watermark-img <?php echo xbox_get_field_value( 'wpst-options', 'logo-position-video-player' ); ?> <?php if( xbox_get_field_value( 'wpst-options', 'logo-watermark-grayscale' ) == 'on' ) : ?>grayscale<?php endif; ?>" src='<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'image-logo-watermark-file' ) ); ?>'/>
        <?php elseif( xbox_get_field_value( 'wpst-options', 'image-logo-file' ) != '' ) : ?>
            <img class="logo-watermark-img <?php echo xbox_get_field_value( 'wpst-options', 'logo-position-video-player' ); ?> <?php if( xbox_get_field_value( 'wpst-options', 'logo-watermark-grayscale' ) == 'on' ) : ?>grayscale<?php endif; ?>" src='<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'image-logo-file' ) ); ?>'/>			
		<?php endif; ?>
	</div>
<?php endif;