<?php
	class LYLBadge_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		/* construct our widget */
		parent::__construct(
			'lylbadge_widget', // Base ID
			__( 'Live Your Legend Badge', 'text_domain' ), // Name
			array( 'description' => __( 'A badge for LYL', 'text_domain' ), ) // Args
		);
		/* set our badges */
		$this->lylLink = 'http://liveyourlegend.net';
		$this->badges = array (
			'LYL Badge'	=> 'lylbadge.png'
		);
		$this->defautBadgeUrl = 'images/badges/' . $this->badges['lylbadge.png'];
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		$badgeUrl = $this->defautBadgeUrl;
		if ( ! empty( $instance['badge'] ) ) {
			$badgeUrl = 'images/badges/' . $instance['badge'];
		}
		$lylwidget_ouput = '<image src="' . plugins_url( $badgeUrl, __FILE__ ) . '">';
		if ( ! empty( $instance['lyl_link'] ) && (int)$instance['lyl_link'] === 1 ) {
			$lylwidget_ouput = '<a href="' . $this->lylLink . '" target="_blank">' . $lylwidget_ouput . '</a>';
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo __( $lylwidget_ouput, 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
		$lyl_link = ( isset( $instance['lyl_link'] ) && is_numeric( $instance['lyl_link'] ) ) ? (int) $instance['lyl_link'] : 0;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'badge' ); ?>"><?php _e( 'Badge:' ); ?></label> 
			<select id="<?php echo $this->get_field_id('badge'); ?>" name="<?php echo $this->get_field_name('badge'); ?>" class="widefat" style="width:100%;">
			<?php foreach( $this->badges as $k => $v ) { ?>
				<option <?php selected( $instance['badge'], $v ); ?> value="<?php echo $v; ?>"><?php echo $k; ?></option>
			<?php } ?>      
			</select>
		</p>
		<p>
			<?php _e( 'Link the badge to liveyourlegend.net?' ); ?>
			<br />
			<input type="radio" id="<?php echo $this->get_field_id( 'lyl_link' ) . '-0' ?>" name="<?php echo $this->get_field_name( 'lyl_link' ) ?>" value="0" <?php echo checked( $lyl_link == 0, true, false ) ?>><label for="<?php echo $this->get_field_id( 'lyl_link' ) . '-0' ?>">No</label>&nbsp;&nbsp;
			<input type="radio" id="<?php echo $this->get_field_id( 'lyl_link' ) . '-1' ?>" name="<?php echo $this->get_field_name( 'lyl_link' ) ?>" value="1" <?php echo checked( $lyl_link == 1, true, false ) ?>><label for="<?php echo $this->get_field_id( 'lyl_link' ) . '-1' ?>">Yes</label><br />
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['badge'] = ( ! empty( $new_instance['badge'] ) ) ? $new_instance['badge'] : '';
		$instance['lyl_link'] = ( ! empty ( $new_instance['lyl_link'] ) && $new_instance['lyl_link'] == 1 ) ? 1 : 0;
		return $instance;
	}
}
?>