<?php
class Austins_Popular_Posts extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        parent::__construct(
			'austins_popular_posts',
			__( 'Austin\'s Popular Posts ', 'austins-popular-posts' ), // Name
			array( 'description' => __( 'A widget the displays a list of your most viewed posts based on data generated with Austin\'s Popular Posts plugin.', 'austins-popular-posts' ), )
		);
	}


	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        // If a custom title has been set, 
		if ( !empty( $instance['title'] ) ) {
            // Print the custom title with the before_and_after_title stuff on either side
			echo '<h3>'.$instance['title'].'<small>'.$instance['time'].'</small></h3>';
		}
        
        get_popular_posts($instance['time'], $instance['per_page']);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
        // Assign the variables a default value if the custom field instance is empty || doesn't exist
        $title = !empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Posts', 'austins-popular-posts' );
        $time = !empty( $instance['time'] ) ? $instance['time'] : '' ;
        $time_options = array('daily', 'weekly', 'monthly');
        $per_page = !empty( $instance['per_page'] ) ? $instance['per_page'] : __( '5', 'austins-popular-posts' );
        // Start drawing the fields on screen
		?>
		<p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title ' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>		
        <p>
            <label for="<?php echo $this->get_field_id( 'time' ); ?>"><?php _e( 'When <i>(published within time-span)</i>' ); ?></label> 
            <select name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_id('time'); ?>" class="widefat">
            <?php
            foreach ($time_options as $option) {
                echo '<option value="' .$option. '" id="' . $option . '"', $time == $option ? ' selected="selected"' : '', '>', $option, '</option>';
            }
            ?>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'per_page' ); ?>"><?php _e( 'Amount to display ' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'per_page' ); ?>" type="number" value="<?php echo esc_attr( $per_page ); ?>">
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
        // Create the array that'll hold our custom fields
		$instance = array();
        
        // Assign the values to the custom instance fields
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['time'] = ( ! empty( $new_instance['time'] ) ) ? strip_tags( $new_instance['time'] ) : '';
        $instance['per_page'] = ( ! empty( $new_instance['per_page'] ) ) ? strip_tags( $new_instance['per_page'] ) : '';
        
        // Return the field data
		return $instance;
	}
}

// Initiliaze/register the widget
add_action( 'widgets_init', function(){
     register_widget( 'Austins_Popular_Posts' );
});

?>