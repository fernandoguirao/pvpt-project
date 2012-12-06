<?php
class WPTeacher {
	
	static function install () {
		//WPTeacher::createPostTypes();
	}
	
	static function uninstall () {
		delete_option('wpt-teacher-options');
	}
	
	static function createPostTypes () {
		global $postTypes;
		foreach ($postTypes as $key => $postType) {
			register_post_type($key, $postType);
		}
		flush_rewrite_rules();
		
		// Assignments
		add_filter("manage_edit-assignment_columns", array('WPTeacher', 'setupAssignmentViewColumns'));
		add_action("manage_assignment_posts_custom_column", array('WPTeacher', 'setupAssignmentViewColumnCategories'), 10, 2);
		
		// Events
		add_filter("manage_edit-event_columns", array('WPTeacher', 'setupEventViewColumns'));
		add_action("manage_event_posts_custom_column", array('WPTeacher', 'setupEventViewColumnCategories'), 10, 2);
	}
	
	static function createSidebars ($postType) {
		register_sidebar(array(
			'name'          => ucfirst($postType),
			'id'            => 'wpt-sidebar-' . $postType,
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>')
		);
	}
	
	static function createWidgets () {
		include(WPT_CORE_PATH . '/classes/widgets/wpt-assignments-widget.class.php');
		register_widget("WPTAssignmentsWidget");
		
		include(WPT_CORE_PATH . '/classes/widgets/wpt-events-widget.class.php');
		register_widget("WPTEventsWidget");
	}
	
	static function setupAssignmentViewColumns ($columns) {
		
		$columns = array(
			'cb' 		=> '<input type="checkbox" />',
			'title' 	=> __('Title'),
			'dueDate'	=> __('Due Date'),
			'course' 	=> __('Course'),
			'type' 		=> __('Type'),
			'date' 		=> __('Date')
		);

		return $columns;
	}
	
	static function setupAssignmentViewColumnCategories ($column, $post_id) {
		
		switch ($column) {
			
			case 'dueDate':
			
				$meta = get_post_meta(get_the_ID(), 'wpt_assignment_dueDate', true);
				if (!empty($meta)) {
					echo date('M d, Y', strtotime($meta));
				} else {
					echo 'Not Set';
				}
			
			break;
			
			case 'course':
				
				$terms = get_the_term_list($post_id , 'course' , '' , ', ' , '' );
		        
		        if (is_string($terms)) {
		            echo $terms;
		        } else {
		            echo 'No Courses';
		        }
		        
			break;
			
			case 'type':
				
				$terms = get_the_term_list($post_id , 'type' , '' , ', ' , '' );
		        
		        if (is_string($terms)) {
		            echo $terms;
		        } else {
		            echo 'No Assignment Types';
		        }
				
			break;
			
			default:
			break;
		}
		
	}
	
	static function setupEventViewColumns ($columns) {
		
		$columns = array(
			'cb' 			=> '<input type="checkbox" />',
			'title' 		=> __('Title'),
			'start-date'	=> __('Start Date'),
			'end-date'		=> __('End Date'),
			'course' 		=> __('Course'),
			'type' 			=> __('Type'),
			'date' 			=> __('Date')
		);

		return $columns;
	}
	
	static function setupEventViewColumnCategories ($column, $post_id) {
		
		switch ($column) {
			
			case 'start-date':
			
				$meta = get_post_meta(get_the_ID(), 'wpt_event_date', true);
				if (!empty($meta)) {
					echo date('M d, Y', strtotime($meta));
				} else {
					echo 'Not Set';
				}
			
			break;
			
			case 'end-date':
			
				$startDate = get_post_meta(get_the_ID(), 'wpt_event_date', true);
				$endDate = get_post_meta(get_the_ID(), 'wpt_event');
				$endDate = $endDate[0]['end-date'];
				
				if (!empty($endDate)) {
					echo date('M d, Y', strtotime($endDate));
				} else {
					if (!empty($startDate))
						echo date('M d, Y', strtotime($startDate));
					else
						echo 'Not Set';
				}
			
			break;
			
			case 'course':
				
				$terms = get_the_term_list($post_id , 'course' , '' , ', ' , '' );
		        
		        if (is_string($terms)) {
		            echo $terms;
		        } else {
		            echo 'No Courses';
		        }
		        
			break;
			
			case 'type':
				
				$terms = get_the_term_list($post_id , 'event-type' , '' , ', ' , '' );
		        
		        if (is_string($terms)) {
		            echo $terms;
		        } else {
		            echo 'No Event Types';
		        }
				
			break;
			
			default:
			break;
		}
		
	}
	
	static function createMetaBoxes () {
		return new WPTMetaBoxes();
	}
	
	static function createTaxonomies () {
		global $postTypes;
		
		$_postTypes = array();
		foreach ($postTypes as $key => $postType) 
			$_postTypes[] = $key;
		
		// Assignment Specific
		register_taxonomy('type', 'assignment', array(
			'hierarchical'		=> true,
			'show_ui'			=> true,
			'public' 			=> true,
			'label' 			=> __('Assignment Types'),
			'show_in_nav_menus' => true,
			'labels' 			=> array(
				'add_new_item' 	=> 'Add New Assignment Type'
			),
			'query_var' 		=> true,
			'rewrite' 			=> array('slug' => 'assignment-type', 'with_front' => true)
		));
		
		// Event Specific
		register_taxonomy('event-type', 'event', array(
			'hierarchical'		=> true,
			'show_ui'			=> true,
			'public' 			=> true,
			'label' 			=> __('Event Types'),
			'show_in_nav_menus' => true,
			'labels' 			=> array(
				'add_new_item' 	=> 'Add New Event Type'
			),
			'query_var' => true,
			'rewrite' 	=> array('slug' => 'event-type', 'with_front' => true),
		));
		
		$_postTypes[] = 'post'; // Add for regular post too
		register_taxonomy('course', $_postTypes, array(
			'hierarchical'		=> true,
			'show_ui'			=> true,
			'public' 			=> true,
			'label' 			=> __('Courses'),
			'show_in_nav_menus' => true,
			'labels' 			=> array(
				'add_new_item' 	=> 'Add New Course'
			),
			'query_var' => true,
			'rewrite' => array('slug' => 'course', 'with_front' => true),
		));
		
		flush_rewrite_rules(false);
		
	}
	
	static function loadCalendar () {
		global $post;
		
		// Style
	    wp_register_style('WPTCalStyle', WPT_THEME_URL . '/calendar/fullcalendar.css');
	    wp_enqueue_style('WPTCalStyle');
	    
	    //wp_register_style('WPTCalPrintStyle', WPT_THEME_URL . '/calendar/fullcalendar.print.css');
	    //wp_enqueue_style('WPTCalPrintStyle');
	 
	    // Javascript
	    wp_register_script('WPTCalJS', WPT_THEME_URL . '/calendar/fullcalendar.min.js');
	    wp_enqueue_script('WPTCalJS');
	    
	    wp_register_script('WPTGCalJS', WPT_THEME_URL . '/calendar/gcal.js');
	    wp_enqueue_script('WPTGCalJS');
		
		require_once(WPT_CORE_PATH . '/ui/ui-calendar.php');
	}
	
	static function loadAdminScripts () {
 
		// JQuery
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-datepicker');
	    
	    // jQuery UI
	    wp_register_style('WPTJQueryStyle', WPT_THEME_URL . '/jquery-ui/jquery-ui-1.8.23.custom.css');
	    wp_enqueue_style('WPTJQueryStyle');
	    
	    // Color Picker
	    wp_enqueue_style('farbtastic');
	    wp_enqueue_script('farbtastic');
	    
	    // Style
	    wp_register_style('WPTAdminStyle', WPT_ADMIN_URL . '/admin-style.css');
	    wp_enqueue_style('WPTAdminStyle');
	 
	}
	
	static function loadSiteScripts () {
 
		// JQuery
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-datepicker');
	    wp_enqueue_script('jquery-ui-draggable');
	    wp_enqueue_script('jquery-ui-droppable');
	    
	    // jQuery UI
	    wp_register_style('WPTJQueryStyle', WPT_THEME_URL . '/jquery-ui/jquery-ui-1.8.23.custom.css');
	    wp_enqueue_style('WPTJQueryStyle');
	    
	    // Style
	    wp_register_style('WPTStyle', WPT_THEME_URL . '/style.css');
	    wp_enqueue_style('WPTStyle');
	 
	    // Javascript
	    wp_register_script('WPTJS', WPT_THEME_URL . '/wp-teacher.js');
	    wp_enqueue_script('WPTJS');
	 
	}
	
}
?>