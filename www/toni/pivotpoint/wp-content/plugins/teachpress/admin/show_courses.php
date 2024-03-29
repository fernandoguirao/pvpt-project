<?php
/**
 * Add help tab for show courses page
 */
function tp_show_course_page_help () {
    $screen = get_current_screen();  
    $screen->add_help_tab( array(
        'id'        => 'tp_show_course_help',
        'title'     => __('Display courses','teachpress'),
        'content'   => '<p><strong>' . __('Shortcodes') . '</strong></p>
                        <p>' . __('You can use courses in a page or article with the following shortcodes:','teachpress') . '</p>
                        <p>' . __('For course informations','teachpress') . ': <strong>[tpdate id="x"]</strong> ' . __('x = Course-ID','teachpress') . '</p>
                        <p>' . __('For the course list','teachpress') . ': <strong>[tpcourselist]</strong></p>
                        <p>' . __('For the enrollment system','teachpress') . ': <strong>[tpenrollments]</strong></p>
                        <p><strong>' . __('More information','teachpress') . '</strong></p>
                        <p><a href="http://mtrv.wordpress.com/teachpress/shortcode-reference/" target="_blank" title="teachPress Shortcode Reference (engl.)">teachPress Shortcode Reference (engl.)</a></p>',
    ) );
} 

/**
 * Show courses page
 * @global type $wpdb
 * @global type $teachpress_settings
 * @global type $teachpress_courses 
 */
function teachpress_show_courses_page() {
     // test if teachpress database is up to date
     $test = get_tp_option('db-version');
     $version = get_tp_version();
     // if is the actual one
     if ($test != $version) {
           $message = __('An database update is necessary.','teachpress') . ' <a href="options-general.php?page=teachpress/settings.php&amp;up=1">' . __('Update','teachpress') . '</a>';
           get_tp_message($message, '');
     }
     
     // Send mail (received from mail.php)
     if( isset( $_POST['send_mail'] ) ) {
          $from = isset ( $_POST['from'] ) ? tp_sec_var($_POST['from']) : '';
          $to = isset ( $_POST['recipients'] ) ? tp_sec_var($_POST['recipients']) : '';
          $subject = isset ( $_POST['subject'] ) ? tp_sec_var($_POST['subject']) : '';
          $text = isset ( $_POST['text'] ) ? tp_sec_var($_POST['text']) : '';
          $options['backup_mail'] = isset ( $_POST['backup_mail'] ) ? tp_sec_var($_POST['backup_mail']) : '';
          $options['recipients'] = isset ( $_POST['recipients_option'] ) ? tp_sec_var($_POST['recipients_option']) : '';
          $attachments = isset ( $_POST['attachments'] ) ? $_POST['attachments'] : '';
          $ret = tp_mail::sendMail($from, $to, $subject, $text, $options, $attachments);
          $message = $ret == true ? __('E-Mail sent','teachpress') : __('Error: E-Mail could not sent','teachpress');
          get_tp_message($message);
     }

     // Event Handler
     $action = isset( $_GET['action'] ) ? tp_sec_var($_GET['action']) : '';
     
     if ($action == 'edit') {
          tp_add_course_page();
     }
     elseif ($action == 'show') {
          tp_show_single_course_page();
     }
     elseif ($action == 'list') {
          tp_lists_page();
     }
     elseif ($action == 'mail') {
          tp_show_mail_page();
     }
     else {
     /*
      * Show courses
     */
     global $wpdb;
     global $teachpress_settings; 
     global $teachpress_courses;
	 global $teachpress_signup;

     $search = isset( $_GET['search'] ) ? tp_sec_var($_GET['search']) : '';
     $course_ID = isset( $_GET['course_ID'] ) ? (int) $_GET['course_ID'] : '';
     $checkbox = isset( $_GET['checkbox'] ) ? $_GET['checkbox'] : '';
     $bulk = isset( $_GET['bulk'] ) ? $_GET['bulk'] : '';
     $copysem = isset( $_GET['copysem'] ) ? $_GET['copysem'] : '';
     
     // if the semester is selected by user
     if (isset($_GET['sem'])) {
       $sem = tp_sec_var($_GET['sem']);
     }
     else {
       $sem = get_tp_option('sem');
     }
     ?> 

     <div class="wrap">
     <h2><?php _e('Courses','teachpress'); ?></h2>
     <form id="showcourse" name="showcourse" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
     <input name="page" type="hidden" value="teachpress/teachpress.php" />
           <?php 	
           // delete a course, part 1
           if ( $bulk == "delete" ) {
                echo '<div class="teachpress_message">
                <p class="hilfe_headline">' . __('Are you sure to delete the selected elements?','teachpress') . '</p>
                <p><input name="delete_ok" type="submit" class="button-secondary" value="' . __('Delete','teachpress') . '"/>
                <a href="admin.php?page=teachpress/teachpress.php&sem=' . $sem . '&search=' . $search . '"> ' . __('Cancel','teachpress') . '</a></p>
                </div>';
           }
           // delete a course, part 2
           if ( isset($_GET['delete_ok']) ) {
                tp_delete_course($checkbox);
                $message = __('Removing successful','teachpress');
                get_tp_message($message);
           }
           // copy a course, part 1
           if ( $bulk == "copy" ) { ?>
                <div class="teachpress_message">
                <p class="hilfe_headline"><?php _e('Copy courses','teachpress'); ?></p>
                <p class="hilfe_text"><?php _e('Select the term, in which you will copy the selected courses.','teachpress'); ?></p>
                <p class="hilfe_text">
                <select name="copysem" id="copysem">
                    <?php    
                    $term = "SELECT `value` FROM " . $teachpress_settings . " WHERE `category` = 'semester' ORDER BY `setting_id` DESC";
                    $term = $wpdb->get_results($term);
                    foreach ($term as $term) { 
                        if ($term->value == $sem) {
                            $current = 'selected="selected"' ;
                        }
                        else {
                            $current = '' ;
                        } 
                        echo '<option value="' . $term->value . '" ' . $current . '>' . stripslashes($term->value) . '</option>';
                    } ?> 
                </select>
                <input name="copy_ok" type="submit" class="button-secondary" value="<?php _e('copy','teachpress'); ?>"/>
                <a href="<?php echo 'admin.php?page=teachpress/teachpress.php&sem=' . $sem . '&search=' . $search . ''; ?>"> <?php _e('Cancel','teachpress'); ?></a>
                </p>
                </div>
           <?php
           }
           // copy a course, part 2
           if ( isset($_GET['copy_ok']) ) {
                   tp_copy_course($checkbox, $copysem);
                   $message = __('Copying successful','teachpress');
                   get_tp_message($message);
           }
           ?>
     <div id="searchbox" style="float:right; padding-bottom:10px;"> 
         <?php if ($search != "") { ?>
         <a href="admin.php?page=teachpress/teachpress.php" style="font-size:14px; font-weight:bold; text-decoration:none; padding-right:3px;" title="<?php _e('Cancel the search','teachpress'); ?>">X</a>
         <?php } ?>
         <input type="text" name="search" id="pub_search_field" value="<?php echo stripslashes($search); ?>"/></td>
         <input type="submit" name="pub_search_button" id="pub_search_button" value="<?php _e('Search'); ?>" class="button-secondary"/>
     </div>
     <div id="filterbox" style="padding-bottom:10px;">    
          <select name="bulk" id="bulk">
               <option>- <?php _e('Bulk actions','teachpress'); ?> -</option>
               <option value="copy"><?php _e('copy','teachpress'); ?></option>
               <option value="delete"><?php _e('Delete','teachpress'); ?></option>
          </select>
          <input type="submit" name="teachpress_submit" value="<?php _e('OK','teachpress'); ?>" id="teachpress_submit2" class="button-secondary"/>
          <select name="sem" id="sem">
               <option value="alle"><?php _e('All terms','teachpress'); ?></option>
               <?php    
               $row = "SELECT `value` FROM " . $teachpress_settings . " WHERE `category` = 'semester' ORDER BY `setting_id` DESC";
               $row = $wpdb->get_results($row);
               foreach ($row as $row) { 
                    if ($row->value == $sem) {
                            $current = 'selected="selected"' ;
                    }
                    else {
                            $current = '' ;
                    } 
                    echo '<option value="' . $row->value . '" ' . $current . '>' . stripslashes($row->value) . '</option>';
               } ?> 
          </select>
         <input type="submit" name="start" value="<?php _e('Show','teachpress'); ?>" id="teachpress_submit" class="button-secondary"/>
      </div>
     <table cellpadding="5" cellspacing="0" border="1" class="widefat">
        <thead>
        <tr>
            <th class="check-column"><input name="tp_check_all" id="tp_check_all" type="checkbox" value="" onclick="teachpress_checkboxes();" /></th>
            <th><?php _e('Name','teachpress'); ?></th>
            <th><?php _e('ID'); ?></th>
            <th><?php _e('Type'); ?></th>
            <th><?php _e('Lecturer','teachpress'); ?></th>
            <th><?php _e('Date','teachpress'); ?></th>
            <th colspan="2" align="center" style="text-align:center;"><?php _e('Places','teachpress'); ?></th>
            <th colspan="2" align="center" style="text-align:center;"><?php _e('Enrollments','teachpress'); ?></th>
            <th><?php _e('Term','teachpress'); ?></th>
            <th><?php _e('Visibility','teachpress'); ?></th>
        </tr>
        </thead>
        <tbody>
     <?php
           if ($search == "") {
                if ($sem == 'alle') {
                    $abfrage = "SELECT * FROM " . $teachpress_courses . " ORDER BY `name`";
                }
                else {
                    $abfrage = "SELECT * FROM " . $teachpress_courses . " WHERE `semester` = '$sem' ORDER BY `name`, `course_id`";
                }	
           }
           // if the user is using the search
           else {
                   $abfrage = "SELECT `course_id`, `name`, `type`, `lecturer`, `date`, `room`, `places`, `start`, `end`, `semester`, `parent`, `visible`, `parent_name` 
                   FROM (SELECT t.course_id AS course_id, t.name AS name, t.type AS type, t.lecturer AS lecturer, t.date AS date, t.room As room, t.places AS places, t.start AS start, t.end As end, t.semester AS semester, t.parent As parent, t.visible AS visible, p.name AS parent_name FROM " . $teachpress_courses . " t LEFT JOIN " . $teachpress_courses . " p ON t.parent = p.course_id ) AS temp 
                   WHERE `name` like '%$search%' OR `parent_name` like '%$search%' OR `lecturer` like '%$search%' OR `date` like '%$search%' OR `room` like '%$search%' OR `course_id` = '$search' 
                   ORDER BY `semester` DESC, `name`";
           }
           $test = $wpdb->query($abfrage);	
           // is the query is empty
           if ($test == 0) { 
               echo '<tr><td colspan="13"><strong>' . __('Sorry, no entries matched your criteria.','teachpress') . '</strong></td></tr>';
           }
           else {
			    // free places
				$sql = "SELECT `course_id`, COUNT(`course_id`) AS used_places FROM $teachpress_signup WHERE `waitinglist` = '0' GROUP BY `course_id`";
				$r = $wpdb->get_results($sql);
				foreach ($r as $r) {
					$free_places[$r->course_id] = $r->used_places;
				}
				// END free places
                $static['bulk'] = $bulk;
                $static['sem'] = $sem;
                $static['search'] = $search;
                $z = 0;
                $ergebnis = $wpdb->get_results($abfrage);
                foreach ($ergebnis as $row){
                    $date1 = tp_datesplit($row->start);
                    $date2 = tp_datesplit($row->end);
                    $courses[$z]['course_id'] = $row->course_id;
                    $courses[$z]['name'] = stripslashes($row->name);
                    $courses[$z]['type'] = stripslashes($row->type);
                    $courses[$z]['room'] = stripslashes($row->room);
                    $courses[$z]['lecturer'] = stripslashes($row->lecturer);
                    $courses[$z]['date'] = stripslashes($row->date);
                    $courses[$z]['places'] = $row->places;
                    // number of free places
                    if ( array_key_exists($row->course_id, $free_places) ) {
                        $courses[$z]['fplaces'] = $courses[$z]['places'] - $free_places[$row->course_id];
                    }
                    else {
                        $courses[$z]['fplaces'] = $courses[$z]['places'];
                    }
                    $courses[$z]['start'] = '' . $date1[0][0] . '-' . $date1[0][1] . '-' . $date1[0][2] . '';
                    $courses[$z]['end'] = '' . $date2[0][0] . '-' . $date2[0][1] . '-' . $date2[0][2] . '';
                    $courses[$z]['semester'] = stripslashes($row->semester);
                    $courses[$z]['parent'] = $row->parent;
                    $courses[$z]['visible'] = $row->visible;
                    $z++;
                }
                // display courses
                for ($i=0; $i<$z; $i++) {
                    if ($search == "") {
                        if ($courses[$i]['parent'] == 0) {
                            echo get_tp_single_table_row_course ($courses[$i], $checkbox, $static);
                            // Search childs
                            for ($j=0; $j<$z; $j++) {
                                if ($courses[$i]['course_id'] == $courses[$j]['parent']) {
                                    echo get_tp_single_table_row_course ($courses[$j], $checkbox, $static, $courses[$i]['name'],'child');
                                }
                            }
                            // END search childs
                        }	
                    }
                    // if the user is using the search
                    else {
                        if ($courses[$i]['parent'] != 0) {
                            $parent_name = get_tp_course_data($courses[$i]['parent'], 'name'); 
                        }
                        else {
                            $parent_name = "";
                        }
                        echo get_tp_single_table_row_course ($courses[$i], $checkbox, $static, $parent_name, 'search');
                    }
                }	
           }   
     ?>
     </tbody>
     </table>
     </form>
     </div>
     <?php 
     }
} ?>