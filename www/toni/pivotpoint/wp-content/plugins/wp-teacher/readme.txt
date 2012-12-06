=== Plugin Name ===
Contributors: fredlawl, brysem
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=EMWA7249JZVEG&lc=US&item_name=FredLawl%20Development&item_number=fredlawl%2ddevelopment&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: teaching, teacher, classroom, class
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Teacher is a plugin that allows teachers to integrate course content into their personal website to enhance student learning.

== Description ==

WP Teacher is a plugin that allows teachers to use Wordpress to their advantage by integrating course 
content into their personal website to enhance student learning. WP Teacher is built with easy-to-use
features that will make his or her Wordpress experience easier.

WP Teacher functions like typical blog postings, but it provides additional features to maximize student learning. All the features work 
together. The plugin is maximized for customization, which makes it perfect for multi-site Wordpress installation.

**Features:**

- 2 Post Types
	- Assignments
		- Document Uploading
		- Due Date for assignments
	- Events
		- All Day
		- Date Range
		- Time selection

- 2 Widgets
	- Assignments List
		- Display X amount of posts
		- Choose a course category to display
		- Choose a assignment type to display
	- Events List
		- Display X amount of posts
		- Choose a course category to display (That applies to a specific course)
		- Choose a event type to display
	
- 3 Taxonomies (Post Categories)
	- Course
	- Event Type
	- Assignment Type
	
- Calendar

- Plugin Options
	- Calendar view settings
	- Select Specific courses/events to display on calendar
	- Color choices for the courses taxonomy

== Installation ==

**To Automatically Install:**

1. Log into the backend of Wordpress
2. Click 'Plugins'
3. Click 'Add New'
4. Type in 'WP Teacher'
5. Click 'Search Plugins'
6. Find WP Teacher
7. Click 'Install Now'
8. Follow on-screen instructions
9. Click 'Activate'
	
**To Manually Install:**

1. Download Project
2. FTP project folder into `{your-root}/wp-content/plugins/`
3. Log into the backend of Wordpress 
4. Click on 'Plugins'
5. Click 'Install'
6. Click 'Activate'

== Screenshots ==

1. Screenshot 1 demonstrates the meta fields for assignments 
2. Screenshot 2 demonstrates the options for custom events
3. Screenshot 3 shows the theme options for the calendar

== Changelog ==

= 1.1.3 = 
* [Backend] [Added] New widget options to the 'Events' widget to allow more control for displaying events. (Suggested by llester)
* [Front-End] [Bug] Fixed an issue where multiple instances of assignment or events widgets would not display in sidebar

= 1.1.2 =
* Added a new developer, Brysem
* [Backend] [Bug] Fixed an issue that if a course slug was changed, an error would appear on the options page.
* [Backend] [Removed] Removed the 'All' Option from the 'Calendar Modes' select
* [Backend] [Bug] Set the default title to the events widget to 'Events' (was 'Assignments')
* [Backend] [Bug] Fixed events and assignments widget to show all types regardless of being used or not
* [Backend] [Bug] Fixed events and assignments widget to allow to select types and still have the widget display
* [Backend] [Bug] Fixed the events list to display the event types

= 1.1.1 =
* [Backend] [Added] A checkbox to show/hide holidays on the calendar. (Suggested by kennibc) 

= 1.1.0 =
* [Backend] [Added] Redesign of the plugin settings page.
* [Backend] [Added] Additional calendar settings to allow more customization.
* [Backend] [Added] Added a dropdown to select a calendar page, `[wpt-class-calendar]` short-code is now optional to use to display the calendar.
* [Backend] [Bug] Fixed an issue where the whole plugin was completely dependent on taxonomies being set.
* [Backend] [Bug] Fixed installation bugs (that were caused by improper error handling)
* [Backend] [Bug] Fixed all calendar settings bugs
* [Backend] [Bug] Fixed the documents error for the assignments meta
* [Backend] [Bug] Fixed the event's all-day, and end date errors for the events meta
* [Front-End] [Bug] Fixed a multiple-day bug that caused an event to skip a day

= 1.0.1 =
* [Backend] Assignment and Event posts list columns are now filled out with the appropriate information.
* [Backend] Added a new column `Due Date` on the Assignments list.
* [Backend] Added two columns `Start Date` and `End Date` on the Events list.

= 1.0.0 =
* Launch

== Upgrade Notice ==

= 1.1.0 =
This upgrade fixes many critical issues with the plugin. An upgrade is strongly advised. (Note: All current data will remain except the settings for the calendar.)

= 1.0.1 =
Assignment and Event's list now have post-specific information within the lists.

== Basic Usage ==

This plugin functions like typical blog postings, but with only a few additional features. 

1. Install Plugin/Activate it (see above)
2. Create some courses
3. Create some assignment types
4. Create some event types
5. Add some assignments
6. Add some events
7. Add the widgets to the sidebar
	* Set a title
	* Set a course category to display (or leave default)
	* Set a type to display (or leave default)
8. Create a Calendar page
9. Set the display page for the calendar OR Add the `[wpt-class-calendar]` short tag into a page
10. View the results!  


== Calendar Use ==
Select a page to display the calendar on within the plugin's settings OR copy/paste `[wpt-class-calendar]` to your calendar page.


== Accessing Assignment Meta Information ==

**To get the assignment due date:**
`
$assignmentDueDate = get_post_meta($post->ID, 'wpt_assignment_dueDate', true);
`

**To get the assignment docs:**
`
$assignmentDocs = get_post_meta($post->ID, 'wpt_assignment_docs');

$assignmentDocs = $assignmentDocs[0];

// return Array ( 0 => Array( 0 => Array('name', 'fileLink'), 1 => Array('name', 'fileLink') ... ) )
`

== Accessing Event Meta Information ==

**To get the event start date:**
`
$eventStartDate = get_post_meta($post->ID, 'wpt_event_date', true);
`

**To get the all other post meta:**
`
$eventMeta = get_post_meta($post->ID, 'wpt_event');

$eventMeta = $eventMeta[0];

// return Array ( 0 => Array('end-date', 'time', 'end-time', 'time-mark', 'end-time-mark', 'all-day') )
`
