<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'show-social-profiles' ) || 'on' === xbox_get_field_value( 'wpst-options', 'enable-membership' ) ) : ?>
	<div class="top-bar <?php if ( 'boxed' === xbox_get_field_value( 'wpst-options', 'layout' ) ) : ?>br-top-10<?php endif; ?>">
		<div class="top-bar-content row">
			<div class="social-share">
				<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'show-social-profiles' ) ) : ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'social-profiles-text' ) ) : ?>
						<small><?php echo esc_html( xbox_get_field_value( 'wpst-options', 'social-profiles-text' ) ); ?></small>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'facebook-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'facebook-profile' ) ); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'google-plus-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'google-plus-profile' ) ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'instagram-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'instagram-profile' ) ); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'reddit-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'reddit-profile' ) ); ?>" target="_blank"><i class="fa fa-reddit"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'tumblr-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'tumblr-profile' ) ); ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'twitter-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'twitter-profile' ) ); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
					<?php endif; ?>
					<?php if ( '' !== xbox_get_field_value( 'wpst-options', 'youtube-profile' ) ) : ?>
						<a href="<?php echo esc_url( xbox_get_field_value( 'wpst-options', 'youtube-profile' ) ); ?>" target="_blank"><i class="fa fa-youtube"></i></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'enable-membership' ) ) : ?>
				<div class="membership">
					<?php if ( is_user_logged_in() ) : ?>
						<span class="welcome"><i class="fa fa-user"></i> <?php echo esc_html( wp_get_current_user()->display_name ); ?></span>
						<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'display-video-submit-link' ) ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>submit-a-video"><i class="fa fa-upload"></i> <span class="topbar-item-text"><?php esc_html_e( 'Submit a Video', 'wpst' ); ?></span></a>
						<?php endif; ?>
						<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'display-my-channel-link' ) ) : ?>
							<a href="<?php echo esc_url( get_author_posts_url( get_current_user_id() ) ); ?>"><i class="fa fa-video-camera"></i> <span class="topbar-item-text"><?php esc_html_e( 'My Channel', 'wpst' ); ?></span></a>
						<?php endif; ?>
						<?php if ( 'on' === xbox_get_field_value( 'wpst-options', 'display-my-profile-link' ) ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>my-profile"><i class="fa fa-user"></i> <span class="topbar-item-text"><?php esc_html_e( 'My Profile', 'wpst' ); ?></span></a>
						<?php endif; ?>
						<a href="<?php echo esc_url( wp_logout_url( is_home() ? home_url() : get_permalink() ) ); ?>"><i class="fa fa-power-off"></i> <span class="topbar-item-text"><?php esc_html_e( 'Logout', 'wpst' ); ?></span></a>
					<?php else : ?>
						<span class="welcome"><i class="fa fa-user"></i> <span><?php esc_html_e( 'Welcome Guest', 'wpst' ); ?></span></span>
						<span class="login"><a href="#wpst-login"><?php esc_html_e( 'Login', 'wpst' ); ?></a></span>
						<span class="or"><?php esc_html_e( 'Or', 'wpst' ); ?></span>
						<span class="login"><a href="#wpst-register"><?php esc_html_e( 'Register', 'wpst' ); ?></a></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php
endif;

