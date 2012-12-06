<?php
class WPTAssignmentsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'assignment_widget', // Base ID
			'Assignments', // Name
			array(
				'description' => __('Displays a list of assignments.', 'text_domain')
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$numPosts = $instance['num-posts'];
		
		$course = $instance['course'];
		
		$courseColors = get_option('wpt-teacher-options');
		$courseColors = (!empty($courseColors) && !empty($courseColors['colors'])) ? $courseColors['colors'] : '#5D943B';
		
		$type = $instance['type'];
		
		include(WPT_CORE_PATH . '/ui/ui-assignment-widget.php');
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
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num-posts'] = strip_tags( $new_instance['num-posts'] );
		$instance['course']	= $new_instance['course'];
		$instance['type']	= $new_instance['type'];
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form ($instance) {
		$title = (isset($instance['title'])) ? $instance['title'] : 'Assignments';
		$numPosts = (isset($instance['num-posts'])) ? $instance['num-posts'] : 5;
		$course = (isset($instance['course'])) ? $instance['course'] : '';
		$type = (isset($instance['type'])) ? $instance['type'] : '';
?>
<p>
	<label for="<?=$this->get_field_id('title')?>">Title:</label> 
	<input class="widefat" id="<?=$this->get_field_id('title')?>" name="<?=$this->get_field_name('title')?>" type="text" value="<?=esc_attr($title)?>" />
</p>
<p>
	<label for="<?=$this->get_field_id('num-posts')?>"># to Display:</label> 
	<input type="text" id="<?=$this->get_field_id('num-posts')?>" name="<?=$this->get_field_name('num-posts')?>" value="<?=esc_attr($numPosts)?>" size="3" />
</p>
<!-- The Course Which it Belongs -->
<?php
$terms = get_terms('course');
if (count($terms) > 0) : 
?>	
<p>
	<label for="<?=$this->get_field_id('course')?>">Course:</label>
	<select id="<?=$this->get_field_id('course')?>" name="<?=$this->get_field_name('course')?>">
		<option value="all" <?=(('all' == $course) ? 'selected="selected"' : '')?>>All</option>
		<?php foreach ($terms as $term) : ?>
		<option value="<?=$term->slug?>" <?=(($term->slug == $course) ? 'selected="selected"' : '')?>><?=$term->name?></option>
		<?php endforeach; ?>
	</select>
</p>
<?php else : ?>
<p><em>Add courses, otherwise this will not display!</em></p>
<?php endif; ?>
<!-- Type of Assignment -->
<?php $typeTerms = get_terms('type', 'hide_empty=0'); ?>	
<p>
	<label for="<?=$this->get_field_id('type')?>">Assignment Type:</label>
	<select id="<?=$this->get_field_id('type')?>" name="<?=$this->get_field_name('type')?>">
		<option value="any" <?=(('any' == $type || empty($type)) ? 'selected="selected"' : '')?>>Any</option>
		<?php if (!empty($typeTerms)) : ?>
			<?php foreach ($typeTerms as $term) : ?>
			<option value="<?=$term->slug?>" <?=(($term->slug == $type) ? 'selected="selected"' : '')?>><?=$term->name?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</p>
<?php
		//global $copy;
		//$copy = &$this;
		//require_once(WPT_CORE_PATH . '/ui/ui-assignment-widget-backend.php');
	}

}
?>