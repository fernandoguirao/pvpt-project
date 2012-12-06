<?php

global $postTypes;
$postTypes = array (
	'assignment' => array(
		'labels' => array(
			'name' 					=> _x('Assignments', 'post type general name'),
			'singular_name' 		=> _x('Assignment', 'post type singular name'),
			'add_new' 				=> _x('Add New', 'assignment'),
			'add_new_item' 			=> __('Add New Assignment'),
			'edit_item' 			=> __('Edit Assignment'),
			'new_item' 				=> __('New Assignment'),
			'view_item' 			=> __('View Assignment'),
			'search_items' 			=> __('Search Assignments'),
			'not_found'				=>  __('No Assignments Found'),
			'not_found_in_trash' 	=> __('No Assignments Found in Trash'), 
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Assignments'
		),
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu' 			=> true,
		'show_in_nav_menus' 	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'assignment'),
		'capability_type' 		=> 'post',
		'has_archive' 			=> true, 
		'hierarchical' 			=> false,
		'menu_position' 		=> 21,
		'supports' 				=> array('title', 'editor', 'excerpt', 'page-attributes')
	),
	'event' => array(
		'labels' => array(
			'name' 					=> _x('Events', 'post type general name'),
			'singular_name' 		=> _x('Event', 'post type singular name'),
			'add_new' 				=> _x('Add New', 'event'),
			'add_new_item' 			=> __('Add New Event'),
			'edit_item' 			=> __('Edit Events'),
			'new_item' 				=> __('New Event'),
			'view_item' 			=> __('View Event'),
			'search_items' 			=> __('Search Events'),
			'not_found'				=>  __('No Events Found'),
			'not_found_in_trash' 	=> __('No Events Found in Trash'), 
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Events'
		),
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu' 			=> true,
		'show_in_nav_menus' 	=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'event'),
		'capability_type' 		=> 'post',
		'has_archive' 			=> true, 
		'hierarchical' 			=> false,
		'menu_position' 		=> 22,
		'supports' 				=> array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
	)
);

?>