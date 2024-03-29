<?php
/* Edit a student
 * @param $student_ID (Int)
 * @param $search (String)
 * @param $students_group (String)
*/ 
function teachpress_editstudent_page() { 
   global $wpdb;
   global $teachpress_courses; 
   global $teachpress_stud; 
   global $teachpress_signup;
   global $teachpress_settings;  
   $student = tp_sec_var($_GET['student_ID']);
   $students_group = tp_sec_var($_GET['students_group']);
   $search = tp_sec_var($_GET['search']);
   $entry_limit = tp_sec_var($_GET['limit']);
   
   $data['matriculation_number'] = isset($_GET['matriculation_number']) ? tp_sec_var($_GET['matriculation_number']) : '';
   $data['firstname'] = isset($_GET['firstname']) ? tp_sec_var($_GET['firstname']) : '';
   $data['lastname'] = isset($_GET['lastname']) ? tp_sec_var($_GET['lastname']) : '';
   $data['course_of_studies'] = isset($_GET['course_of_studies']) ? tp_sec_var($_GET['course_of_studies']) : '';
   $data['semester_number'] = isset($_GET['semester_number']) ? tp_sec_var($_GET['semester_number']) : '';
   $data['userlogin'] = isset($_GET['userlogin']) ? tp_sec_var($_GET['userlogin']) : '';
   $data['birthday'] = isset($_GET['birthday']) ? tp_sec_var($_GET['birthday']) : '';
   $data['email'] = isset($_GET['email']) ? tp_sec_var($_GET['email']) : '';
   // WP User ID
   global $user_ID;
   get_currentuserinfo();
   ?> 
   <div class="wrap">
   <?php
   // Event handler
   if ( isset( $_GET['delete'] )) {
        tp_delete_registration($_GET['checkbox']);
        $message = __('Enrollment deleted','teachpress');
        get_tp_message($message);
   }
   if ( isset( $_GET['save'] )) {
        $wp_id = tp_sec_var($_GET['wp_id'], 'integer');
        tp_change_student($wp_id, $data, $user_ID);
        $message = __('Changes successful','teachpress');
        get_tp_message($message);
   }
   echo '<p><a href="admin.php?page=teachpress/students.php&amp;search=' . $search . '&amp;students_group=' . $students_group . '&amp;limit=' . $entry_limit . '" class="button-secondary" title="' . __('back to the overview','teachpress') . '">&larr; ' . __('Back','teachpress') . ' </a></p>';
   ?>
   <form name="personendetails" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
   <input name="page" type="hidden" value="teachpress/students.php" />
   <input name="action" type="hidden" value="show" />
   <input name="student_ID" type="hidden" value="<?php echo $student; ?>" />
   <input name="students_group" type="hidden" value="<?php echo $students_group; ?>" />
   <input name="search" type="hidden" value="<?php echo $search; ?>" />
   <input name="limit" type="hidden" value="<?php echo $entry_limit; ?>" />
   <?php
      $sql = "SELECT * FROM " . $teachpress_stud . " WHERE `wp_id` = '$student'";
      $row3 = $wpdb->get_row($sql);
   ?>
   <h2 style="padding-top:0px;"><?php echo stripslashes($row3->firstname); ?> <?php echo stripslashes($row3->lastname); ?> <span class="tp_break">|</span> <small><a onclick="teachpress_showhide('daten_aendern')" id="daten_aendern_2" style="cursor:pointer;"><?php _e('Edit','teachpress'); ?> </a></small></h2>
     <div id="daten_aendern" style="display:none; padding-top:5px; padding-bottom:5px; margin:5px;">
        <fieldset style="border:1px solid silver; padding:10px; width:650px;">
            <legend><?php _e('Edit Data','teachpress'); ?></legend>
                <table class="widefat">
                <thead>
                <tr>
                    <th><label for="wp_id"><?php _e('WordPress User-ID','teachpress'); ?></label></th>
                    <td style="text-align:left;"><input name="wp_id" type="text" id="wp_id" value="<?php echo $row3->wp_id; ?>" readonly="true"/></td>
                </tr>
                <?php
                $field1 = get_tp_option('regnum');
                if ($field1 == '1') { ?>
                    <tr>
                        <th><label for="matriculation_number"><?php _e('Matr. number','teachpress'); ?></label></th>
                        <td style="text-align:left;"><input name="matriculation_number" type="text" id="matriculation_number" value="<?php echo $row3->matriculation_number; ?>" readonly="true"/></td>
                    </tr>
                <?php }?>
                <tr>
                    <th><label for="firstname"><?php _e('First name','teachpress'); ?></label></th>
                    <td><input name="firstname" type="text" id="firstname" value="<?php echo stripslashes($row3->firstname); ?>" size="40"/></td>
                </tr>
                <tr>
                    <th><label for="lastname"><?php _e('Last name','teachpress'); ?></label></th>
                    <td><input name="lastname" type="text" id="lastname" value="<?php echo stripslashes($row3->lastname); ?>" size="40"/></td>
                </tr>
                <tr>
                <?php
                $field2 = get_tp_option('studies');
                if ($field2 == '1') { ?>
                    <th><label for="course_of_studies"><?php _e('Course of studies','teachpress'); ?></label></th>
                    <td>
                    <select name="course_of_studies" id="course_of_studies">
                        <?php
                        $stud = "SELECT value FROM " . $teachpress_settings . " WHERE category = 'course_of_studies'";
                        $stud = $wpdb->get_results($stud);
                        foreach ($stud as $stud) {
                            if ($stud->value == $row3->course_of_studies) {
                                    $current = 'selected="selected"' ;
                            }
                            else {
                                    $current = '' ;
                            }
                            echo '<option value="' . stripslashes($stud->value) . '" ' . $current . '>' . stripslashes($stud->value) . '</option>';
                        } ?>
                    </select></td>
                    </tr>
                <?php } ?>
                <?php
                $field3 = get_tp_option('termnumber');
                if ($field3 == '1') { ?>
                    <tr>
                    <th><label for="semester_number"><?php _e('Number of terms','teachpress'); ?></label></th>
                    <td style="text-align:left;">
                    <select name="semester_number" id="semesternumber">
                    <?php
                        for ($i=1; $i<20; $i++) {
                            if ($i == $row3->semesternumber) {
                                $current = 'selected="selected"' ;
                            }
                            else {
                                $current = '' ;
                            }
                            echo '<option value="' . $i . '" ' . $current . '>' . $i . '</option>';
                        }  
                    ?>
                    </select>
                    </td>
                    </tr>
                <?php } ?> 
                    <tr>
                        <th><label for="userlogin"><?php _e('User account','teachpress'); ?></label></th>
                        <td style="text-align:left;"><input name="userlogin" type="text" id="userlogin" value="<?php echo $row3->userlogin; ?>" readonly="true"/></td>
                    </tr>
                <?php
                $field4 = get_tp_option('birthday');
                if ($field4 == '1') { ?>  
                    <tr>
                        <th><label for="birthday"><?php _e('Date of birth','teachpress'); ?></label></th>
                        <td><input name="birthday" type="text" id="birthday" value="<?php echo $row3->birthday; ?>" size="15"/>
                            <em><?php _e('Format: JJJJ-MM-TT','teachpress'); ?></em></td>
                    </tr>
                <?php } ?>  
                    <tr>
                        <th><label for="email"><?php _e('E-Mail'); ?></label></th>
                        <td><input name="email" type="text" id="email" value="<?php echo $row3->email; ?>" size="50" readonly="true"/></td>
                    </tr>
                </thead> 
                </table>
            <?php 
            if ($field1 != '1') {
                echo '<input name="matriculation_number" type="hidden" id="matriculation_number" value="' . $row3->matriculation_number . '" />';
            }
            if ($field2 != '1') {
                echo '<input name="course_of_studies" type="hidden" id="course_of_studies" value="' . $row3->course_of_studies . '" />';
            }
            if ($field3 != '1') {
                echo '<input name="semesternumber" type="hidden" id="semesternumber" value="' . $row3->semesternumber . '" />';
            }
            if ($field4 != '1') {
                echo '<input name="birthday" type="hidden" id="birthday" value="' . $row3->birthday . '" />';
            } ?>     
            <table border="0" cellspacing="7" cellpadding="0">
                <tr>
                    <td><input name="save" type="submit" id="teachpress_einzel_change" onclick="teachpress_validateForm('wp_id','','RisNum','matriculation_number','','RisNum','firstname','','R','lastname','','R','userlogin','','R','birthday','','R','email','','RisEmail');return document.teachpress_returnValue" value="<?php _e('Save'); ?>" class="button-secondary"/></td>
                    <td><a onclick="teachpress_showhide('daten_aendern')" style="cursor:pointer;"><?php _e('Cancel','teachpress'); ?></a></td>
                </tr>
            </table>
        </fieldset>
     </div>
     <div style="width:55%; padding-bottom:10px;">
     <table border="0" cellpadding="0" cellspacing="5" class="widefat">
        <thead>
        <?php
        echo '<tr>';
        echo '<th width="130">' . __('WordPress User-ID','teachpress') . '</th>';
        echo '<td style="vertical-align:middle;">' . $row3->wp_id . '</td>';
        echo '</tr>';
        if ($field1 == '1') {
            echo '<tr>';
            echo '<th>' . __('Matr. number','teachpress') . '</th>';
            echo '<td style="vertical-align:middle;">' . $row3->matriculation_number . '</td>';
            echo '</tr>';
        }
        if ($field2 == '1') {
            echo '<tr>';
            echo '<th>' . __('Course of studies','teachpress') . '</th>';
            echo '<td style="vertical-align:middle;">' . stripslashes($row3->course_of_studies) . '</td>';
            echo '</tr>';
        }
        if ($field3 == '1') { 
            echo '<tr>';
            echo '<th>' . __('Number of terms','teachpress') . '</th>';
            echo '<td style="vertical-align:middle;">' . $row3->semesternumber . '</td>';
            echo '</tr>';
        }
        if ($field4 == '1') {
            echo '<tr>';
            echo '<th>' . __('Date of birth','teachpress') . '</th>';
            echo '<td style="vertical-align:middle;">' . $row3->birthday . '</td>';
            echo '</tr>';
        }
        echo '<tr>';
        echo '<th>' . __('User account','teachpress') . '</th>';
        echo '<td style="vertical-align:middle;">' . $row3->userlogin . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo'<th>' . __('E-Mail') . '</th>';
        echo '<td style="vertical-align:middle;"><a href="admin.php?page=teachpress/teachpress.php&amp;student_ID=' . $row3->wp_id . '&amp;search=' . $search . '&amp;students_group=' . $students_group . '&amp;limit=' . $entry_limit . '&amp;action=mail&amp;single=' . $row3->email . '" title="' . __('Send E-Mail to','teachpress') . ' ' . $row3->firstname . ' ' . $row3->lastname . '">' . $row3->email . '</a></td>';
        echo '</tr>';
        ?>
      </thead>   
     </table>
     </div>
   </form>
   <form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
   <input name="page" type="hidden" value="teachpress/editstudent.php">
   <input name="student_ID" type="hidden" value="<?php echo $student; ?>">
   <input name="search" type="hidden" value="<?php echo $search; ?>">
   <table border="1" cellspacing="0" cellpadding="5" class="widefat">
    <thead>
        <tr>
        <th>&nbsp;</th>
        <th><?php _e('Enrollment-Nr.','teachpress'); ?></th>
        <th><?php _e('Registered at','teachpress'); ?></th>
        <th><?php _e('Course','teachpress'); ?></th>
        <th><?php _e('Type'); ?></th>
        <th><?php _e('Date','teachpress'); ?></th>
        </tr>
    </thead>    
    <tbody>
    <?php
        $wait = false;
        // Nach Daten zur Person: Ausgabe aller Einschreibungen
        $sql = "SELECT s.wp_id, s.firstname, s.lastname, c.name, c.type, c.date, c.parent, si.con_id, si.date AS signup, si.waitinglist
                FROM " . $teachpress_signup . " si
                INNER JOIN " . $teachpress_courses . " c ON c.course_id = si.course_id
                INNER JOIN " . $teachpress_stud . " s ON s.wp_id = si.wp_id
                WHERE si.wp_id = '$student'";		
        $test = $wpdb->query($sql);
        if ($test != 0) {	
            $row = $wpdb->get_results($sql);
            foreach($row as $row2) {
            if ($row2->waitinglist == 1) {
                $wait = true;
            }
            else {
                if ($row2->parent != 0) {
                    $parent_name = $wpdb->get_var("SELECT `name` FROM " . $teachpress_courses . " WHERE `course_id` = '$row2->parent'");
                    $parent_name = $parent_name . " ";
                }
                else {
                    $parent_name = "";
                }
                echo '<tr>';
                echo '<th class="check-column"><input name="checkbox[]" type="checkbox" value="' . $row2->con_id . '"/></th>';
                echo '<td>' . $row2->con_id . '</td>';
                echo '<td>' . $row2->signup . '</td>';
                echo '<td>' . stripslashes($parent_name) . stripslashes($row2->name) . '</td>';
                echo '<td>' . stripslashes($row2->type) . '</td>';
                echo '<td>' . stripslashes($row2->date) . '</td>';
                echo '</tr>';
            }
            } 
        }
        else {
            echo '<tr><td colspan="6"><strong>' . __('Sorry, no entries matched your criteria.','teachpress') . '</strong></td></tr>';
        }?>
    </tbody>
   </table>
   <?php
   if ($wait == true) {
        echo '<h3>' . __('Waitinglist','teachpress') . '</h3>';
        ?>
        <table border="1" cellspacing="0" cellpadding="5" class="widefat">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php _e('Enrollment-Nr.','teachpress'); ?></th>
                    <th><?php _e('Registered at','teachpress'); ?></th>
                    <th><?php _e('Course','teachpress'); ?></th>
                    <th><?php _e('Type'); ?></th>
                    <th><?php _e('Date','teachpress'); ?></th>
                </tr>
            </thead>    
            <tbody>
            <?php     
            foreach($row as $row2) {
                if ($row2->waitinglist == 1) {
                    if ($row2->parent != 0) {
                        $parent_name = $wpdb->get_var("SELECT `name` FROM " . $teachpress_courses . " WHERE `course_id` = '$row2->parent'");
                        $parent_name = $parent_name . " ";
                    }
                    else {
                        $parent_name = "";
                    }
                    echo '<tr>';
                    echo '<th class="check-column"><input name="checkbox[]" type="checkbox" value="' . $row2->con_id . '"/></th>';
                    echo '<td>' . $row2->con_id . '</td>';
                    echo '<td>' . $row2->signup . '</td>';
                    echo '<td>' . stripslashes($parent_name) . stripslashes($row2->name) . '</td>';
                    echo '<td>' . stripslashes($row2->type) . '</td>';
                    echo '<td>' . stripslashes($row2->date) . '</td>';
                    echo '</tr>';
                }
            }
                ?>
            </tbody>
        </table>
   <?php } ?>
   <table border="0" cellspacing="7" cellpadding="0" id="einzel_optionen">
     <tr>
        <td><?php _e('delete enrollment','teachpress'); ?></td>
        <td> <input name="delete" type="submit" value="<?php _e('Delete','teachpress'); ?>" id="teachpress_search_delete" class="button-secondary"/></td>
     </tr>
   </table>
   </form>
   </div>
<?php } ?>