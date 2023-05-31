<?php
/**
 * WP_Widget class
 */
class wpst_WP_Widget_Videos_Block extends WP_Widget {

	/**
	 * Set up widget infos.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'widget_videos_block',
			'description' => __( 'Display blocks of videos sorted by views, date, popularity, category, etc.', 'wpst' ),
		);
		parent::__construct( 'widget_videos_block', 'RetroTube - Video Blocks', $widget_options );
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array $args     Args of the widget.
	 * @param array $instance Instance of the widget.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$args_query     = array();
		$video_type     = isset( $instance['video_type'] ) ? $instance['video_type'] : null;
		$video_number   = isset( $instance['video_number'] ) ? $instance['video_number'] : null;
		$video_category = isset( $instance['video_category'] ) ? $instance['video_category'] : null;

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$args_query = array(

		);

		switch ( $video_type ) {
			case 'related':
				global $post;
				$categories = get_the_terms( $post->ID, 'category' );
				if ( $categories ) {
					$args_query = array(
						'post_type'           => 'post',
						'posts_per_page'      => $video_number,
						'ignore_sticky_posts' => true,
						'orderby'             => 'rand',
						'post__not_in'        => array( $post->ID ),
						'tax_query'           => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'category',
								'field'    => 'id',
								'terms'    => $categories[0]->term_id,
								'operator' => 'IN',
							),
						),
					);
				}
				break;
			case 'latest':
				$args_query = array(
					'post_type'           => 'post',
					'orderby'             => 'date',
					'order'               => 'DESC',
					'posts_per_page'      => $video_number,
					'cat'                 => $video_category,
					'ignore_sticky_posts' => true,
				);
				break;
			case 'most-viewed':
				$args_query = array(
					'post_type'           => 'post',
					'meta_key'            => 'post_views_count',
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
					'posts_per_page'      => $video_number,
					'cat'                 => $video_category,
					'ignore_sticky_posts' => true,
				);
				break;
			case 'longest':
				$args_query = array(
					'post_type'           => 'post',
					'meta_key'            => 'duration',
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
					'posts_per_page'      => $video_number,
					'cat'                 => $video_category,
					'ignore_sticky_posts' => true,
				);
				break;
			case 'popular':
				$args_query = array(
					'post_type'           => 'post',
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
					'meta_query'          => array(
						'relation' => 'OR',
						array(
							'key'     => 'rate',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'rate',
							'compare' => 'EXISTS',
						),
					),
					'posts_per_page'      => $video_number,
					'cat'                 => $video_category,
					'ignore_sticky_posts' => true,
				);
				break;
			case 'random':
				$args_query = array(
					'post_type'           => 'post',
					'orderby'             => 'rand',
					'order'               => 'DESC',
					'posts_per_page'      => $video_number,
					'cat'                 => $video_category,
					'ignore_sticky_posts' => true,
				);
				break;
		}
		$home_query = new WP_Query( $args_query );

		if ( $home_query->have_posts() ) : ?>
			<?php
			require_once get_template_directory() . '/temp-style.php';
			if ( 'related' === $video_type ) {
					global $post;
					$post_cat = wp_get_post_categories( $post->ID );
			}
			?>
  <a class="more-videos label" href="<?php echo get_bloginfo( 'url' ); ?>/?filter=<?php echo $video_type; ?>
												<?php
												if ( $video_category != 0 ) :
													?>
		&amp;cat=<?php echo $video_category; ?><?php endif; ?>"><i class="fa fa-plus"></i> <span><?php _e( 'More videos', 'wpst' ); ?></span></a>
  <div class="videos-list">
		<?php
		while ( $home_query->have_posts() ) :
			$home_query->the_post();
			get_template_part( 'template-parts/loop', 'video' );
		endwhile;
		?>
  </div>
  <div class="clear"></div>
			<?php
endif;
		echo $args['after_widget'];
		wp_reset_query();
	}



	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 * @return void
	 */
	public function form( $instance ) {
		$instance           = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$current_video_type = isset( $instance['video_type'] ) ? esc_attr( $instance['video_type'] ) : '';
		$video_number       = isset( $instance['video_number'] ) ? esc_attr( $instance['video_number'] ) : '';
		$video_category     = isset( $instance['video_category'] ) ? esc_attr( $instance['video_category'] ) : '';
		?>
  <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpst' ); ?> :</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<?php
		if ( $video_number == '' ) {
			$video_number = 4;}
		?>
	<p><label for="<?php echo $this->get_field_id( 'video_number' ); ?>"><?php _e( 'Total videos', 'wpst' ); ?> :</label>
	  <input style="width:40px;" class="widefat" id="<?php echo $this->get_field_id( 'video_number' ); ?>" name="<?php echo $this->get_field_name( 'video_number' ); ?>" type="text" value="<?php echo $video_number; ?>" /></p>
	  <p><label for="<?php echo $this->get_field_id( 'video_type' ); ?>"><?php _e( 'Display', 'wpst' ); ?> :</label>
		<select class="widefat video-sort" id="<?php echo $this->get_field_id( 'video_type' ); ?>" name="<?php echo $this->get_field_name( 'video_type' ); ?>">
		  <?php
			  $types_videos = array(
				  'latest'      => __( 'Latest videos', 'wpst' ),
				  'most-viewed' => __( 'Most viewed videos', 'wpst' ),
				  'longest'     => __( 'Longest videos', 'wpst' ),
				  'popular'     => __( 'Popular videos', 'wpst' ),
				  'random'      => __( 'Random videos', 'wpst' ),
				  'related'     => __( 'Related videos', 'wpst' ),
			  );
			  foreach ( $types_videos as $key => $value ) :

					?>
		  <option class="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $current_video_type ); ?>><?php echo ucfirst( $value ); ?></option>
				  <?php
			  endforeach;
				?>
		</select></p>
		<p class="cat_display"><label for="<?php echo $this->get_field_id( 'video_category' ); ?>"><?php _e( 'Category', 'wpst' ); ?> :</label>
			  <?php
				$args = array(
					'show_option_all'  => __( 'All', 'wpst' ),
					'show_option_none' => '',
					'show_last_update' => 0,
					'show_count'       => 1,
					'hide_empty'       => 0,
					'child_of'         => 0,
					'exclude'          => '',
					'echo'             => 1,
					'selected'         => $video_category,
					'hierarchical'     => 1,
					'name'             => $this->get_field_name( 'video_category' ),
					'id'               => $this->get_field_id( 'video_category' ),
					'class'            => 'widefat',
					'depth'            => -1,
					'tab_index'        => 0,
					'taxonomy'         => 'category',
					'order'            => 'ASC',
					'orderby'          => 'title',
				);
				wp_dropdown_categories( $args );
				?>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['title']          = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['video_type']     = isset( $new_instance['video_type'] ) ? sanitize_text_field( $new_instance['video_type'] ) : '';
		$instance['video_number']   = isset( $new_instance['video_number'] ) ? sanitize_text_field( preg_replace( '[^0-9]', '', $new_instance['video_number'] ) ) : '';
		$instance['video_category'] = isset( $new_instance['video_category'] ) ? sanitize_text_field( $new_instance['video_category'] ) : '';
		return $instance;
	}
}
function wpst_register_widgets() {
	register_widget( 'wpst_WP_Widget_Videos_Block' );
}
add_action( 'widgets_init', 'wpst_register_widgets' );
