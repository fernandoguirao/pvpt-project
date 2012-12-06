<?php
/*
Plugin Name: WP Teacher
Plugin URI: http://www.fredlawl.com
Description: Allows teacher wordpress multi-sites to have all the same post-types etc...
Version: 1.1.3
Author: Frederick Lawler
Author URI: http://www.fredlawl.com
License: GPL2
*/

include_once('config.php');

add_action('init', 'wpt_initiate');

function wpt_initiate () {

	WPTeacher::createPostTypes();
	WPTeacher::createMetaBoxes();
	WPTeacher::createTaxonomies();
	
	WPTeacher::createSidebars('blog');
	
	do_action('wpt_initiate');
}

add_action('admin_enqueue_scripts', 'wpt_loadScripts');
function wpt_loadScripts () {
	WPTeacher::loadAdminScripts();
}

add_action('wp_enqueue_scripts', 'wpt_loadScripts');
function wpt_loadSiteScripts () {
	WPTeacher::loadSiteScripts();
}

function wpt_calendar () {
	WPTeacher::loadCalendar();
}
add_shortcode('wpt-class-calendar', 'wpt_calendar');

function wpt_injectCalendar ($content) {
	$options = get_option('wpt-teacher-options');
	//$content = 'THE CONTENT<BR /><BR />' . $content;
	
	if (empty($options))
		return $content;
		
	if (empty($options['calendar']['page']))
		return $content;
	
	// assuming you have created a page/post entitled 'debug'
	if ($GLOBALS['post']->ID == $options['calendar']['page']) {
		//return var_export($GLOBALS['post'], TRUE );
		return $content . '' . do_shortcode('[wpt-class-calendar]');
	}
	
	// otherwise returns the database content
	return $content;
}
add_filter('the_content', 'wpt_injectCalendar');

add_action('widgets_init', array('WPTeacher', 'createWidgets') );

add_action("admin_menu", array('WPTAdmin', 'install'));

register_activation_hook(__FILE__, array('WPTeacher', 'install') );

register_deactivation_hook(__FILE__, array('WPTeacher', 'uninstall'));
?>