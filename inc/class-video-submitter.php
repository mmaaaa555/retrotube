<?php

if ( ! class_exists( 'WPST_Video_Submitter' ) ) {
	/**
	 * Video Submitter Class.
	 */
	class WPST_Video_Submitter {

		/**
		 * Class constructor.
		 */
		public function __construct() {
			$this->recaptcha_site_key = xbox_get_field_value( 'wpst-options', 'recaptcha-site-key' );
			$this->recaptcha_secret   = xbox_get_field_value( 'wpst-options', 'recaptcha-secret-key' );
			$this->recaptcha_enabled  = 'on' === xbox_get_field_value( 'wpst-options', 'enable-recaptcha' );
			$this->error_message      = '';
			$this->success_message    = '';
			$this->upload_limit       = $this->get_upload_max_file_size();
		}

		/**
		 * Get upload_max_filesize.
		 *
		 * @return array The minimum filesize config with string and bytes data.
		 */
		private function get_upload_max_file_size() {
			$upload_max_filesize = array(
				'text'  => ini_get( 'upload_max_filesize' ),
				'bytes' => $this->convert_php_size_to_bytes( ini_get( 'upload_max_filesize' ) ),
			);
			$post_max_size       = array(
				'text'  => ini_get( 'post_max_size' ),
				'bytes' => $this->convert_php_size_to_bytes( ini_get( 'post_max_size' ) ),
			);
			if ( $upload_max_filesize['bytes'] > $post_max_size['bytes'] ) {
				return $post_max_size;
			}
			return $upload_max_filesize;
		}

		/**
		 * Transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
		 *
		 * @param string $size The size from php.ini config file.
		 * @return integer The value in bytes.
		 */
		private function convert_php_size_to_bytes( $size ) {
			$suffix = strtoupper( substr( $size, -1 ) );
			if ( ! in_array( $suffix, array( 'P', 'T', 'G', 'M', 'K' ) ) ) {
				return (int) $size;
			}
			$value = substr( $size, 0, -1 );
			switch ( $suffix ) {
				case 'P':
					$value *= 1024;
					// Fallthrough intended.
				case 'T':
					$value *= 1024;
					// Fallthrough intended.
				case 'G':
					$value *= 1024;
					// Fallthrough intended.
				case 'M':
					$value *= 1024;
					// Fallthrough intended.
				case 'K':
					$value *= 1024;
					break;
			}
			return (int) $value;
		}

		/**
		 * Function to render the form.
		 *
		 * @return string The HTML form (it won't print anything).
		 */
		public function render_form() {
			if ( 'on' !== xbox_get_field_value( 'wpst-options', 'enable-video-submission' ) ) {
				return '<div class="alert alert-info">' . __( 'Video submission is disabled.', 'wpst' ) . '</div>';
			}
			if ( ! is_user_logged_in() ) {
				// translators: %1$s is the anchor link to login. %2$s is the anchor link to register.
				return '<div class="alert alert-info">' . sprintf( __( 'You must be logged to submit a video. Please <a href="%1$s">login</a> or <a href="%2$s">register</a> a new account.', 'wpst' ), '#wpst-login', '#wpst-register' ) . '</div>';
			}
			if ( $this->recaptcha_enabled &&
				( empty( $this->recaptcha_site_key ) || empty( $this->recaptcha_secret ) ) ) {
				return '<div class="alert alert-info">' . __( 'The captcha is activated but it must be configured in the Theme Options', 'wpst' ) . '</div>';
			}
			if ( isset( $_POST['wpst-submitted'] ) && isset( $_POST['wpst-post_nonce_field'] ) && wp_verify_nonce( $_POST['wpst-post_nonce_field'], 'post_nonce' ) ) {
				try {
					$this->process_form();
					$this->success_message = __( 'Thanks for submitting a video! Your submission is being moderated.', 'wpst' );
				} catch ( Exception $exception ) {
					$this->error_message = $exception->getMessage();
				}
			}
			// Put all the following output into memory.
			ob_start();
			echo $this->render_messages();
			?>
			<form data-abide action="" id="SubmitVideo" method="post" enctype="multipart/form-data">
				<div id="html_element"></div>
				<?php wp_nonce_field( 'post_nonce', 'wpst-post_nonce_field' ); ?>
				<input type="hidden" name="wpst-submitted" id="submitted" value="true" />
				<?php echo $this->render_fieldset( 'video_infos' ); ?>
				<?php echo $this->render_fieldset( 'video_type' ); ?>
				<?php echo $this->render_fieldset( 'video_details' ); ?>
				<?php if ( $this->recaptcha_enabled ) : ?>
					<div class="g-recaptcha" data-sitekey="<?php echo $this->recaptcha_site_key; ?>" data-theme="dark"></div>
				<?php endif; ?>

				<!-- Submit Form -->
				<?php echo apply_filters( 'update_button', '<button id="submit-video" class="large" type="submit">' . __( 'Submit a video', 'wpst' ) . '</button>', 'submit_video' ); ?>
			</form>
			<script type="text/javascript">
				jQuery(document).ready((function(){
					jQuery('#video_file').change(function(){
						checkFileOnChange(this, uploadRules('video'));
					});
					jQuery('#thumb_file').change(function(){
						checkFileOnChange(this, uploadRules('thumb'));
					});
					function uploadRules(fileType){
						var uploadLimit = <?php echo intval( $this->upload_limit['bytes'] ); ?>;
						var uploadRules = {
							'video': {
								'uploadLimit': uploadLimit,
								'fileTypes': ['video/mp4']
							},
							'thumb': {
								'uploadLimit': uploadLimit,
								'fileTypes': ['image/png', 'image/gif', 'image/jpg', 'image/jpeg']
							}
						};
						return uploadRules[fileType];
					}
					function checkFileOnChange(domFileInput, rules) {
						jQuery(domFileInput).nextAll('.file-check').remove();
						disableSubmitButton(false);
						if ( domFileInput.length < 1 ) return;
						var file = domFileInput.files[0];
console.log(file);
						// check size.
						if ( file.size > rules.uploadLimit ) {
							jQuery(domFileInput).after('<div class="file-check file-check--error alert alert-danger"><?php echo esc_html__( 'This file is too big.', 'wpst' ); ?></div>');
							disableSubmitButton(true);
						}
						// check type.
						if ( ! rules.fileTypes.includes(file.type) ) {
							jQuery(domFileInput).after('<div class="file-check file-check-error alert alert-danger"><?php echo esc_html__( 'This file type is not accepted.', 'wpst' ); ?></div>');
							disableSubmitButton(true);
						}
					}
					function disableSubmitButton( disabled = true ) {
						var button = jQuery('#submit-video');
						button.attr('disabled', disabled);
					}
				})());
			</script>
			<?php
			// return the output in memory.
			return ob_get_clean();
		}

		/**
		 * Get options or a fieldset, given it's key.
		 *
		 * @param string $key The field key to get options from ('video_infos'|'video_type'|'video_details').
		 *
		 * @throws Exception If the $key doesn't exists.
		 *
		 * @return array An array of options for each field of the fieldset wanted.
		 */
		private function get_options( $key ) {
			$options['video_infos']   = array(
				'title'       => array(
					'enabled'  => $this->is_on( 'video-submit-title-enabled' ),
					'required' => $this->is_on( 'video-submit-title-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-video_title' ),
				),
				'description' => array(
					'enabled'  => $this->is_on( 'video-submit-description-enabled' ),
					'required' => $this->is_on( 'video-submit-description-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-video_description' ),
				),
			);
			$options['video_type']    = array(
				'video_link'  => array(
					'enabled'  => $this->is_on( 'video-submit-video-link-enabled' ),
					'required' => $this->is_on( 'video-submit-video-link-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-video_link' ),
				),
				'video_embed' => array(
					'enabled'  => $this->is_on( 'video-submit-video-embed-enabled' ),
					'required' => $this->is_on( 'video-submit-video-embed-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-video_embed' ),
				),
				'video_file'  => array(
					'enabled'  => $this->is_on( 'video-submit-video-file-enabled' ),
					'required' => $this->is_on( 'video-submit-video-file-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-video_file' ),
				),
			);
			$options['video_details'] = array(
				'thumb_link' => array(
					'enabled'  => $this->is_on( 'video-submit-thumbnail-link-enabled' ),
					'required' => $this->is_on( 'video-submit-thumbnail-link-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-thumb_link' ),
				),
				'thumb_file' => array(
					'enabled'  => $this->is_on( 'video-submit-thumbnail-file-enabled' ),
					'required' => $this->is_on( 'video-submit-thumbnail-file-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-thumb_file' ),
				),
				'category'   => array(
					'enabled'  => $this->is_on( 'video-submit-category-enabled' ),
					'required' => $this->is_on( 'video-submit-category-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-category' ),
				),
				'tags'       => array(
					'enabled'  => $this->is_on( 'video-submit-tags-enabled' ),
					'required' => $this->is_on( 'video-submit-tags-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-tags' ),
				),
				'actors'     => array(
					'enabled'  => $this->is_on( 'video-submit-actors-enabled' ),
					'required' => $this->is_on( 'video-submit-actors-required' ),
					'default'  => $this->set_default_whith_post( 'wpst-actors' ),
				),
				'duration'   => array(
					'enabled'  => $this->is_on( 'video-submit-duration-enabled' ),
					'required' => $this->is_on( 'video-submit-duration-required' ),
					'default'  => array(
						'hh' => $this->set_default_whith_post( 'wpst-duration_hh' ),
						'mm' => $this->set_default_whith_post( 'wpst-duration_mm' ),
						'ss' => $this->set_default_whith_post( 'wpst-duration_ss' ),
					),
				),
			);
			if ( ! isset( $options[ $key ] ) ) {
				throw new Exception( "The key $key in options doesn't exist." );
			}
			return $options[ $key ];
		}

		/**
		 * Prepare and render fieldset given its id.
		 *
		 * @param string $fieldset_id The field id to render.
		 *
		 * @return string The fieldset html. Empty string of all fieldset tags are disabled.
		 */
		private function render_fieldset( $fieldset_id ) {
			if ( $this->are_all_options_disabled( $fieldset_id ) ) {
				return '';
			}
			$output = '<fieldset class="fieldset">';
			switch ( $fieldset_id ) {
				case 'video_infos':
					$output .= $this->render_legend( __( 'Video infos', 'wpst' ) );
					$output .= $this->render_fields_video_infos();
					break;
				case 'video_type':
					$output .= $this->render_legend( __( 'Video type', 'wpst' ) );
					$output .= $this->render_fields_video_type();
					break;
				case 'video_details':
					$output .= $this->render_legend( __( 'Video details', 'wpst' ) );
					$output .= $this->render_fields_video_details();
					break;
			}
			$output .= '</fieldset>';
			return $output;
		}

		/**
		 * Render Video infos fields.
		 *
		 * @return string the html specific for this fieldset.
		 */
		private function render_fields_video_infos() {
			$options = $this->get_options( 'video_infos' );
			$output  = '';
			if ( $options['title']['enabled'] ) {
				$output .= $this->render_label( __( 'Title', 'wpst' ), 'wpst-video_title', $options['title']['required'] );
				$output .= '<input type="text" name="wpst-video_title" id="video_title" value="' . $options['title']['default'] . '" ' . $this->render_required( $options['title']['required'] ) . '>';
			}
			if ( $options['description']['enabled'] ) {
				$output .= $this->render_label( __( 'Description', 'wpst' ), 'wpst-video_description', $options['description']['required'] );
				$output .= '<textarea name="wpst-video_description" id="video_description" rows="6" cols="30" ' . $this->render_required( $options['description']['required'] ) . '>' . sanitize_textarea_field( $options['description']['default'] ) . '</textarea>';
			}
			return $output;
		}

		/**
		 * Render Video infos field.
		 *
		 * @return string the html specific for this fieldset.
		 */
		private function render_fields_video_type() {
			$options = $this->get_options( 'video_type' );
			$output  = '';
			if ( $options['video_link']['enabled'] ) {
				$output .= $this->render_label( __( 'Video URL', 'wpst' ), 'wpst-video_link', $options['video_link']['required'] );
				$output .= '<input type="text" name="wpst-video_link" id="video_link" value="' . $options['video_link']['default'] . '"' . $this->render_required( $options['video_link']['required'] ) . '>';
			}
			if ( $options['video_embed']['enabled'] ) {
				$output .= $this->render_label( __( 'Iframe / Embed code', 'wpst' ), 'wpst-video_embed', $options['video_embed']['required'] );
				$output .= '<textarea name="wpst-video_embed" id="video_embed" rows="4" cols="30" ' . $this->render_required( $options['video_embed']['required'] ) . '>' . $options['video_embed']['default'] . '</textarea>';
			}
			if ( $options['video_file']['enabled'] ) {
				// translators: %s: The upload max filesize.
				$output .= $this->render_label( __( 'Video file', 'wpst' ) . ' <small>(' . sprintf( __( 'max. %s' ), $this->upload_limit['text'] ) . ')</small>', 'wpst-video_file', $options['video_file']['required'] );
				$output .= '<input type="file" accept=".mp4"  name="wpst-video_file" id="video_file" value="' . $options['video_file']['default'] . '"' . $this->render_required( $options['video_file']['required'] ) . '>';
			}
			return $output;
		}

		/**
		 * Render Video infos fields.
		 *
		 * @return string the html specific for this fieldset.
		 */
		private function render_fields_video_details() {
			$options = $this->get_options( 'video_details' );
			$output  = '';
			if ( $options['thumb_link']['enabled'] ) {
				$output .= $this->render_label( __( 'Thumbnail URL', 'wpst' ), 'wpst-thumb_link', $options['thumb_link']['required'] );
				$output .= '<input type="text" name="wpst-thumb_link" id="thumb_link" value="' . $options['thumb_link']['default'] . '"' . $this->render_required( $options['thumb_link']['required'] ) . '>';
			}
			if ( $options['thumb_file']['enabled'] ) {
				// translators: %s: The upload max filesize.
				$output .= $this->render_label( __( 'Thumbnail file', 'wpst' ) . ' <small>(' . sprintf( __( 'max. %s' ), $this->upload_limit['text'] ) . ')</small>', 'wpst-thumb_file', $options['thumb_file']['required'] );
				$output .= '<input type="file" accept=".jpg,.jpeg,.gif,.png" name="wpst-thumb_file" id="thumb_file" value="' . $options['thumb_file']['default'] . '"' . $this->render_required( $options['thumb_file']['required'] ) . '>';
			}
			if ( $options['category']['enabled'] ) {
				$categories = get_terms( 'category', array( 'hide_empty' => 0 ) );
				$output    .= $this->render_label( __( 'Category', 'wpst' ), 'wpst-category', $options['category']['required'] );
				$output    .= '<select name="wpst-category" id="category" data-width="auto" ' . $this->render_required( true ) . '>';
				foreach ( (array) $categories as $category ) {
					$selected = $this->render_selected( intval( $options['category']['default'] ) === intval( $category->term_id ) );
					$output  .= '<option value="' . $category->term_id . '"' . $selected . '>' . $category->name . '</option>';
				}
				$output .= '</select>';
			}
			if ( $options['tags']['enabled'] ) {
				$output .= $this->render_label( __( 'Tags', 'wpst' ) . ' <small>(' . __( 'separated by commas' ) . ')</small>', 'wpst-tags', $options['tags']['required'] );
				$output .= '<input type="text" name="wpst-tags" id="tags" value="' . $options['tags']['default'] . '"' . $this->render_required( $options['tags']['required'] ) . '>';
			}
			if ( $options['actors']['enabled'] ) {
				$output .= $this->render_label( __( 'Actors', 'wpst' ) . ' <small>(' . __( 'separated by commas' ) . ')</small>', 'wpst-actors', $options['actors']['required'] );
				$output .= '<input type="text" name="wpst-actors" id="actors" value="' . $options['actors']['default'] . '"' . $this->render_required( $options['actors']['required'] ) . '>';
			}
			if ( $options['duration']['enabled'] ) {
				$output .= $this->render_label( __( 'Duration', 'wpst' ), 'wpst-duration', $options['duration']['required'] );
				ob_start();
				?>
				<div id="video-duration-select">
					<div class="duration-col">
						<span class="input-group-label"><?php esc_html_e( 'hour', 'wpst' ); ?></span>
						<select name="wpst-duration_hh">
						<?php
						for ( $hour = 0; $hour <= 10;
						$hour++ ) :
							$formatted_hour = sprintf( '%02d', $hour );
							?>
							<option
								value="<?php echo $formatted_hour; ?>"
								<?php echo $this->render_selected( $options['duration']['default']['hh'] === $formatted_hour ); ?>
							><?php echo $formatted_hour; ?></option>
						<?php endfor; ?>
						</select>
					</div>
					<div class="duration-col">
						<span class="input-group-label"><?php esc_html_e( 'min', 'wpst' ); ?></span>
						<select name="wpst-duration_mm">
						<?php
						for ( $min = 0; $min <= 59;
						$min++ ) :
															$formatted_min = sprintf( '%02d', $min );
							?>
							<option
								value="<?php echo $formatted_min; ?>"
															<?php echo $this->render_selected( $options['duration']['default']['mm'] === $formatted_min ); ?>
							><?php echo $formatted_min; ?></option>
						<?php endfor; ?>
						</select>
					</div>
					<div class="duration-col">
						<span class="input-group-label"><?php esc_html_e( 'sec', 'wpst' ); ?></span>
						<select name="wpst-duration_ss">
						<?php
						for ( $sec = 0; $sec <= 59;
						$sec++ ) :
															$formatted_sec = sprintf( '%02d', $sec );
							?>
							<option
								value="<?php echo $formatted_sec; ?>"
															<?php echo $this->render_selected( $options['duration']['default']['ss'] === $formatted_sec ); ?>
							><?php echo $formatted_sec; ?></option>
						<?php endfor; ?>
						</select>
					</div>
				</div>
				<?php
				$output .= ob_get_clean();
			}
			return $output;
		}

		/**
		 * Function to process the form.
		 *
		 * @throws Exception On failure.
		 *
		 * @return bool True on success.
		 */
		private function process_form() {
			if ( $this->recaptcha_enabled ) {
				if ( ! isset( $_POST['g-recaptcha-response'] ) || empty( $_POST['g-recaptcha-response'] ) ) {
					throw new Exception( __( 'Please click on the reCAPTCHA box.', 'wpst' ) );
				}
				$captcha         = urlencode( $_POST['g-recaptcha-response'] );
				$verify_response = file_get_contents( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $this->recaptcha_secret . '&response=' . $captcha );
				$response_data   = json_decode( $verify_response );
				if ( ! $response_data->success ) {
					throw new Exception( __( 'Captcha verification failed, please try again.', 'wpst' ) );
				}
			}
			$title       = esc_html( $_POST['wpst-video_title'] );
			$description = esc_textarea( $_POST['wpst-video_description'] );
			$new_post_id = wp_insert_post(
				array(
					'post_title'    => ! empty( $title ) ? $title : 'Untitled',
					'post_content'  => ! empty( $description ) ? $description : '',
					'author'        => get_current_user_id(),
					'post-type'     => 'post',
					'post_status'   => 'pending',
					'post_category' => array( $_POST['wpst-category'] ),
					'tax_input'     => array(
						'post_tag' => $_POST['wpst-tags'],
						'actors'   => $_POST['wpst-actors'],
					),
				),
				true
			);
			if ( is_wp_error( $new_post_id ) ) {
				throw new Exception( $new_post_id->get_error_message() );
			}

			// Update Custom Metas.
			$duration_seconds = $_POST['wpst-duration_hh'] * 3600 + $_POST['wpst-duration_mm'] * 60 + $_POST['wpst-duration_ss'];
			update_post_meta( $new_post_id, 'duration', $duration_seconds );
			update_post_meta( $new_post_id, 'video_url', esc_attr( wp_strip_all_tags( $_POST['wpst-video_link'] ) ) );
			update_post_meta( $new_post_id, 'embed', $_POST['wpst-video_embed'] );
			update_post_meta( $new_post_id, 'thumb', esc_attr( strip_tags( $_POST['wpst-thumb_link'] ) ) );

			// Set post format.
			set_post_format( $new_post_id, 'video' );

			// Upload video.
			if ( isset( $_FILES['wpst-video_file'] ) && 0 === $_FILES['wpst-video_file']['error'] ) {
				$file       = $_FILES['wpst-video_file'];
				$file_types = array( 'video/mp4' );
				if ( ! in_array( $file['type'], $file_types, true ) ) {
					throw new Exception( __( 'Only MP4 files are accepted.', 'wpst' ) );
				}
				if ( $_FILES['wpst-video_file']['size'] > $this->upload_limit['bytes'] ) {
					throw new Exception( __( 'The file is too big.', 'wpst' ) );
				}
				$uploaded_file = wp_upload_bits( $_FILES['wpst-video_file']['name'], null, file_get_contents( $_FILES['wpst-video_file']['tmp_name'] ) );
				update_post_meta( $new_post_id, 'video_url', $uploaded_file['url'] );
			}

			// Upload thumb.
			if ( isset( $_FILES['wpst-thumb_file'] ) && 0 === $_FILES['wpst-thumb_file']['error'] ) {
				$file       = $_FILES['wpst-thumb_file'];
				$file_types = array( 'image/png', 'image/gif', 'image/jpg', 'image/jpeg' );
				if ( ! in_array( $file['type'], $file_types, true ) ) {
					throw new Exception( __( 'Only MP4 files are accepted.', 'wpst' ) );
				}
				if ( $_FILES['wpst-thumb_file']['size'] > $this->upload_limit['bytes'] ) {
					throw new Exception( __( 'The file is too big.', 'wpst' ) );
				}
				$uploaded_file = wp_upload_bits( $_FILES['wpst-thumb_file']['name'], null, file_get_contents( $_FILES['wpst-thumb_file']['tmp_name'] ) );
				$wp_filetype   = wp_check_filetype( $file['name'], null );
				$attachment    = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_parent'    => $new_post_id,
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $file['name'] ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);
				$attachment_id = wp_insert_attachment( $attachment, $uploaded_file['file'], $new_post_id );
				if ( ! is_wp_error( $attachment_id ) ) {
					require_once ABSPATH . 'wp-admin/includes/media.php';
					require_once ABSPATH . 'wp-admin/includes/image.php';
					$attachment_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
					wp_update_attachment_metadata( $attachment_id, $attachment_data );
					set_post_thumbnail( $new_post_id, $attachment_id );
				}
				update_post_meta( $new_post_id, 'thumb', $uploaded_file['url'] );
			}
			$_POST  = array();
			$_FILES = array();
			return true;
		}

		/**
		 * Helper function to check if an option is set to on.
		 *
		 * @param string $xbox_option_key The option to check.
		 *
		 * @return bool True if the option is set to on, false if not.
		 */
		private function is_on( $xbox_option_key ) {
			return 'on' === xbox_get_field_value( 'wpst-options', $xbox_option_key );
		}

		/**
		 * Helper function to set the default option.
		 *
		 * @param string $_post_key The $_POST key to use if exists.
		 *
		 * @return string The default option, empty string if the $_post_key doesn't exist.
		 */
		private function set_default_whith_post( $_post_key ) {
			return isset( $_POST[ $_post_key ] ) ? $_POST[ $_post_key ] : '';
		}

		/**
		 * Check if all options of a given option_key are disabled.
		 *
		 * @param string $options_key The option key to check.
		 *
		 * @return bool True if all options are disabled, false if not.
		 */
		private function are_all_options_disabled( $options_key ) {
			$options              = $this->get_options( $options_key );
			$all_options_disabled = true;
			foreach ( $options as $option ) {
				if ( true === $option['enabled'] ) {
					$all_options_disabled = false;
					break;
				}
			}
			return $all_options_disabled;
		}

		/**
		 * Function to render success and error messages.
		 *
		 * @return string The HTML formatted message.
		 */
		private function render_messages() {
			if ( ! empty( $this->error_message ) ) {
				return '<div class="alert alert-danger">' . $this->error_message . '</div>';
			}
			if ( ! empty( $this->success_message ) ) {
				return '<div class="alert alert-success">' . $this->success_message . '</div>';
			}
		}

		/**
		 * Function to render a legend tag.
		 *
		 * @param string $title    The title of the label.
		 *
		 * @return string The legend tag.
		 */
		private function render_legend( $title ) {
			return '<legend><strong>' . $title . '</strong></legend>';
		}

		/**
		 * Function to render requered to a tag.
		 *
		 * @param bool $tag_required Is the tag required.
		 *
		 * @return string The HTML tag required property.
		 */
		private function render_required( $tag_required ) {
			if ( ! $tag_required ) {
				return '';
			}
			return 'required="required"';
		}

		/**
		 * Function to render selected to a tag.
		 *
		 * @param bool $tag_selected Is the tag selected.
		 *
		 * @return string The HTML tag selected property.
		 */
		private function render_selected( $tag_selected ) {
			if ( ! $tag_selected ) {
				return '';
			}
			return 'selected';
		}

		/**
		 * Function to render a label tag.
		 *
		 * @param string $title    The title of the label.
		 * @param string $for      The for attr of the label.
		 * @param bool   $required Is the field required or not.
		 *
		 * @return string The label tag.
		 */
		private function render_label( $title, $for, $required = false ) {
			if ( $required ) {
				$title .= ' <span class="required">*</span>';
			}
			return '<label for="' . $for . '">' . $title . '</label>';
		}
	}
}
