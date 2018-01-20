<?php

class Stats_widget extends WP_Widget {

	function __construct() {
		parent::__construct( 'the_stats_widget_widget', esc_html__( 'The Stats Widget', 'the-stats-widget' ), array( 'description' => esc_html__( 'Simple stats widget to display public stats of a site(s)', 'the-stats-widget' ) ) );
	}

	public function widget( $args, $instance ) {

		$html = '';

		$title = apply_filters( 'widget_title', $instance['title'] );

		$html .= $args['before_widget'];
		if ( ! empty( $title ) ) {
			$html .= $args['before_title'] . $title . $args['after_title'];
		}

		//actual widget's body
		$html .= '<div class="js-the_stats_widget_widget"></div>';


		$html .= $args['after_widget'];

		echo $html;
	}


	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = esc_html__( 'New title', 'the-stats-widget' );
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'the-stats-widget' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
