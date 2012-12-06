<?php
/*----------------------------------------------
	Plugin Configuration
----------------------------------------------*/

define('WPT_BASE_PATH', untrailingslashit(dirname(__FILE__)));
define('WPT_CORE_PATH', WPT_BASE_PATH . '/includes');
define('WPT_THEME_PATH', WPT_BASE_PATH . '/theme');
define('WPT_ADMIN_PATH', WPT_BASE_PATH . '/admin');

define('WPT_BASE_URL', untrailingslashit(plugins_url('', __FILE__)));
define('WPT_THEME_URL', WPT_BASE_URL . '/theme');
define('WPT_ADMIN_URL', WPT_BASE_URL . '/admin');
define('SPT_STYLESHEET_URL', WPT_THEME_URL . '/style.css');


/*----------------------------------------------
	Includes
----------------------------------------------*/

// Include the post-types
require_once(WPT_CORE_PATH . '/post-types.php');

// Include the functions
require_once(WPT_CORE_PATH . '/functions.php');

// Include the plugin classes
require_once(WPT_CORE_PATH . '/classes/wpt-teacher.class.php');
require_once(WPT_CORE_PATH . '/classes/wpt-meta-boxes.class.php');
require_once(WPT_CORE_PATH . '/classes/wpt-admin.class.php');
?>