<?php
class WPTAdmin {
	
	static function install () {
		add_menu_page("WP Teacher", "WP Teacher", "administrator", "wpt-teacher-menu",  array('WPTAdmin', 'index'));
		//add_submenu_page("weblawl_menu", "Sources", "Sources", "administrator", "weblawl_menu_sources", "wblawl_admin_sources");
		add_action("admin_head", array('WPTAdmin', 'getHeader'));
		add_action("admin_foot", array('WPTAdmin', 'getFooter'));
	}
	
	static function getHeader () {
		include(WPT_ADMIN_PATH . '/header.php');
	}
	
	static function getFooter () {
		include(WPT_ADMIN_PATH . '/footer.php');
	}
	
	static function index () {
		include(WPT_ADMIN_PATH . '/index.php');
	}
	
}
?>