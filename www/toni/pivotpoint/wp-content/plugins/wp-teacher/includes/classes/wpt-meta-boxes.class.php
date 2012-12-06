<?php 
class WPTMetaBoxes {
 
    public function __construct() {
        add_action('add_meta_boxes', array(&$this, 'createMetaBoxes'));
        add_action('save_post', array(&$this, 'saveData'));
    }
    
    public function __deconstruct () {
	    unset($this);
    }

    public function createMetaBoxes () {
        // Events
        add_meta_box('wpt-event-meta-box', 'Event Information', array(&$this, 'renderEventMeta'), 'event', 'advanced', 'default');
        
        // Assignments
        add_meta_box('wpt-assignment-meta-box', 'Assignment Information', array(&$this, 'renderAssignmentMeta'), 'assignment', 'advanced', 'default');
    }

    public function renderEventMeta () {
    	global $post;
        require_once(WPT_CORE_PATH . '/ui/ui-event-meta.php');
    }
    
    public function renderAssignmentMeta () {
    	global $post;
	    require_once(WPT_CORE_PATH . '/ui/ui-assignment-meta.php');
    }
    
    public function saveData ($postID) {
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $postID;
		
		if ($parent_id = wp_is_post_revision($postID)) 
			$postID = $parent_id;
		
		//echo '<pre>';
		//print_r($_POST);
		//echo '</pre>';
		
		if (isset($_POST['post-type']) && $_POST['post-type'] == 'assignment') {
			if (isset($_POST['due-date']))
				update_post_meta($postID, 'wpt_assignment_dueDate', $_POST['due-date']);
			
			if (isset($_POST['assignment']))
				update_post_meta($postID, 'wpt_assignment_docs', $_POST['assignment']);
		} else {
			if (isset($_POST['date']))
				update_post_meta($postID, 'wpt_event_date', $_POST['date']);
				
			if (isset($_POST['event']))
				update_post_meta($postID, 'wpt_event', $_POST['event']);
		}
				
		return $postID;
    }
    
}
?>