<?php
/* Template Name: Profile */

/* Get user info. */
global $current_user, $wp_roles;

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( home_url() );
	exit;
}

$error   = array();
$referer = '';
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

	/* Update user password. */
	if ( ! empty( $_POST['pass1'] ) && ! empty( $_POST['pass2'] ) ) {
		if ( $_POST['pass1'] == $_POST['pass2'] ) {
			wp_update_user(
				array(
					'ID'        => $current_user->ID,
					'user_pass' => esc_attr( $_POST['pass1'] ),
				)
			);
		} else {
			$error[] = esc_html__( 'The passwords you entered do not match. Your password was not updated.', 'wpst' );
		}
	}

	/* Update user information. */
	if ( ! empty( $_POST['url'] ) ) {
		wp_update_user(
			array(
				'ID'       => $current_user->ID,
				'user_url' => esc_attr( $_POST['url'] ),
			)
		);
	}
	if ( ! empty( $_POST['email'] ) ) {
		if ( ! is_email( esc_attr( $_POST['email'] ) ) ) {
			$error[] = esc_html__( 'The Email you entered is not valid. Please try again.', 'wpst' );
		} elseif ( email_exists( esc_attr( $_POST['email'] ) ) != $current_user->ID ) {
			$error[] = esc_html__( 'This email is already used by another user. Try a different one.', 'wpst' );
		} else {
			wp_update_user(
				array(
					'ID'         => $current_user->ID,
					'user_email' => esc_attr( $_POST['email'] ),
				)
			);
		}
	}

	if ( ! empty( $_POST['first-name'] ) ) {
		update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
	}
	if ( ! empty( $_POST['last-name'] ) ) {
		update_user_meta( $current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
	}
	if ( ! empty( $_POST['display_name'] ) ) {
		wp_update_user(
			array(
				'ID'           => $current_user->ID,
				'display_name' => esc_attr( $_POST['display_name'] ),
			)
		);
	}
	  update_user_meta( $current_user->ID, 'display_name', esc_attr( $_POST['display_name'] ) );
	if ( ! empty( $_POST['description'] ) ) {
		update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
	}

	/*
	 Redirect so the page will show updated info.*/
	/*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */

	if ( count( $error ) == 0 ) {
		// action hook for plugins and extra fields saving
		do_action( 'edit_user_profile_update', $current_user->ID );
		wp_redirect( get_permalink() . '?updated=true' );
		exit;
	}
}
get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
	<div id="primary" class="content-area <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>">
		<main id="main" class="site-main <?php echo esc_attr( wpst_get_sidebar_position_class() ); ?>" role="main">

			<header class="entry-header">
				<?php the_title( '<h1 class="widget-title"><i class="fa fa-user"></i>', '</h1>' ); ?>
			</header>

			<?php if ( is_user_logged_in() ) : ?>

				<?php
				if ( isset( $_GET['updated'] ) && $_GET['updated'] == true ) :
					?>
					 <div id="message" class="alert alert-success"><i class="fa fa-check"></i> <?php esc_html_e( 'Your profile has been updated.', 'wpst' ); ?></div> <?php endif; ?>
				<?php
				if ( count( $error ) > 0 ) {
					echo '<p class="error">' . implode( '<br />', $error ) . '</p>';}
				?>
				<form method="post" id="edit-user" action="<?php the_permalink(); ?>">
					<div class="form-username col-3">
						<label for="first-name"><?php esc_html_e( 'First Name', 'wpst' ); ?></label>
						<input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
					</div><!-- .form-username -->
					<div class="form-username col-3">
						<label for="last-name"><?php esc_html_e( 'Last Name', 'wpst' ); ?></label>
						<input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
					</div><!-- .form-username -->
					<!-- .form-display_name -->
					<div class="form-display_name col-3"><label for="display_name"><?php esc_html_e( 'Display Name as', 'wpst' ); ?></label>
						<select name="display_name" id="display_name"><br/>
						<?php
							$public_display                     = array();
							$public_display['display_nickname'] = $current_user->nickname;
							$public_display['display_username'] = $current_user->user_login;

						if ( ! empty( $current_user->first_name ) ) {
							$public_display['display_firstname'] = $current_user->first_name;
						}

						if ( ! empty( $current_user->last_name ) ) {
							$public_display['display_lastname'] = $current_user->last_name;
						}

						if ( ! empty( $current_user->first_name ) && ! empty( $current_user->last_name ) ) {
							$public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
							$public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
						}

						if ( ! in_array( $current_user->display_name, $public_display ) ) { // Only add this if it isn't duplicated elsewhere
							$public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;
						}

							$public_display = array_map( 'trim', $public_display );
							$public_display = array_unique( $public_display );

						foreach ( $public_display as $id => $item ) {
							?>
							<option <?php selected( $current_user->display_name, $item ); ?>><?php echo $item; ?></option>
							<?php
						}
						?>
						</select>
					</div><!-- .form-display_name -->
					<div class="clear"></div>
					<div class="form-email col-1">
						<label for="email"><?php esc_html_e( 'Email', 'wpst' ); ?> <span class="required">*</span></label>
						<input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'useresc_html_email', $current_user->ID ); ?>" />
					</div><!-- .form-email -->
					<div class="form-url col-2">
						<label for="url"><?php esc_html_e( 'Website', 'wpst' ); ?></label>
						<input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
					</div><!-- .form-url -->
					<div class="form-password col-1">
						<label for="pass1"><?php esc_html_e( 'Password', 'wpst' ); ?> <span class="required">*</span></label>
						<input class="text-input" name="pass1" type="password" id="pass1" />
					</div><!-- .form-password -->
					<div class="form-password col-2">
						<label for="pass2"><?php esc_html_e( 'Repeat Password', 'wpst' ); ?> <span class="required">*</span></label>
						<input class="text-input" name="pass2" type="password" id="pass2" />
					</div><!-- .form-password -->
					<div class="form-textarea">
						<label for="description"><?php esc_html_e( 'Biographical Information', 'wpst' ); ?></label>
						<textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
					</div><!-- .form-textarea -->

					<?php
						// action hook for plugin and extra fields
						do_action( 'edit_user_profile', $current_user );
					?>
					<p class="form-submit">
						<?php echo $referer; ?>
						<?php echo apply_filters( 'update_button', '<input name="updateuser" type="submit" id="updateuser" class="margin-top-1 margin-bottom-1 submit button" value="' . __( 'Update your profile', 'wpst' ) . '" />', 'profile' ); ?>
						<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
						<input name="action" type="hidden" id="action" value="update-user" />
					</p><!-- .form-submit -->
				</form><!-- #adduser -->

			<?php else : ?>

				<div class="alert alert-info"><?php printf( __( 'You must be logged to submit a video. Please <a href="%1$s">login</a> or <a href="%2$s">register</a> a new account.', 'wpst' ), '#wpst-login', '#wpst-register' ); ?></div>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

			<?php
endwhile;
endif;
get_sidebar();
get_footer();
