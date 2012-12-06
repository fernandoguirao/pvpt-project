<?php
global $wpdb;
if (!is_super_admin()) {
	$url = bloginfo('url');
	header("Location: " . $url);
	exit;
}

// If page is updated
if (!empty($_GET['page']) && $_GET['page'] == 'wpt-teacher-menu') {
	if (!empty($_POST['action']) && $_POST['action'] == 'save') {
		
		
		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		
		// Display Page
		update_option('wpt-teacher-options', $_POST['wpt-teacher-options']);

		
	} elseif (!empty($_POST['action']) && $_POST['action'] == 'reset') {
		
		delete_option('wpt-teacher-options');
		
	}
}

$courses = get_terms('course', 'hide_empty=0');
$events = get_terms('event-type', 'hide_empty=0');

// Get options if exist(s)
$options = get_option('wpt-teacher-options');

if (!empty($options)) {
	$calendarOptions = $options['calendar'];
} else {
	$calendarOptions = array();
}

if (!empty($_POST['save'])) echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
if (!empty($_POST['reset'])) echo '<div id="message" class="updated fade"><p><strong>Settings reset.</strong></p></div>';
?>

<div id="wpt-options-container">
	<form method="post">
		<div id="poststuff">
			<div class="metabox-holder">
				
				<!-- Calendar Settings -->
				<div class="postbox-container">
					<div class="postbox">
						<input name="save" type="submit" class="button-primary alignright" value="Save Settings" />
						<h3 class="hndle">Calendar Settings</h3>
						<div class="clear"></div>
						<div class="inside">
							<div class="wpt-options">
								<h4>Calendar View Settings</h4>
								<p class="wpt-description">These settings tell the calendar what views are available.</p>
								<div class="wpt-option-row">
									<div class="wpt-option-child-row wpt-first-row">
										<label for="display-page">Calendar Display Page:</label>
										<?php $sitePages = new WP_Query('post_type=page'); ?>
										<?php if ($sitePages->have_posts()) : ?>
											<div class="wpt-input-container">
												<select id="display-page" name="wpt-teacher-options[calendar][page]" class="wpt-input" />
													<option value="none"<?=(!empty($calendarOptions) && 'none' == $calendarOptions['page']) ? ' selected="selected"' : ''?>>Don't Display</option>
													<?php while ($sitePages->have_posts()) : $sitePages->the_post(); ?>
														<option value="<?=get_the_ID()?>"<?=(!empty($calendarOptions) && get_the_ID() == $calendarOptions['page']) ? ' selected="selected"' : ''?>><?php the_title(); ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										<?php else : ?>
											<div class="wpt-input-container">
												<select id="display-page" name="wpt-teacher-options[calendar][page]" class="wpt-input" />
													<option value="none" selected="selected">Don't Display</option>
												</select>
											</div>
										<?php endif; ?>
										<?php wp_reset_postdata(); ?>
										<div class="clear"></div>
									</div>
								</div>
								<div class="wpt-option-row">
									<div class="wpt-option-child-row wpt-first-row">
										<label for="hide-holidays">Hide Holidays?</label>
										<div class="wpt-input-container">
											<input type="checkbox" id="hide-holidays" name="wpt-teacher-options[calendar][show-holiday]" value="yes" class="wpt-input" <?=(!empty($calendarOptions) && !empty($calendarOptions['show-holiday']) && $calendarOptions['show-holiday'] == 'yes') ? 'checked="checked"' : ''?> />
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div class="wpt-option-row">
									<div class="wpt-option-child-row wpt-first-row">
										<label for="calendar-mode-select">Select Calendar Mode(s):</label>
										<div class="wpt-input-container">
											<select id="calendar-mode-select" name="wpt-teacher-options[calendar][modes][]" class="wpt-input" multiple="multiple">
												<option value="basicWeek" <?=(!empty($calendarOptions) && !empty($calendarOptions['modes']) && in_array('basicWeek', $calendarOptions['modes'])) ? 'selected="selected"' : ''?>>Basic Week</option>
												<option value="basicDay" <?=(!empty($calendarOptions) && !empty($calendarOptions['modes']) && in_array('basicDay', $calendarOptions['modes'])) ? 'selected="selected"' : ''?>>Basic Day</option>
												<option value="agendaWeek" <?=(!empty($calendarOptions) && !empty($calendarOptions['modes']) && in_array('agendaWeek', $calendarOptions['modes'])) ? 'selected="selected"' : ''?>>Agenda Week</option>
												<option value="agendaDay" <?=(!empty($calendarOptions) && !empty($calendarOptions['modes']) && in_array('agendaDay', $calendarOptions['modes'])) ? 'selected="selected"' : ''?>>Agenda Day</option>
											</select>
											<small>Allows these additional calendar views.</small>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div class="wpt-option-row">
									<div class="wpt-option-child-row wpt-first-row">
										<label for="course-select">Select Course(s):</label>
										<div class="wpt-input-container">
											<select id="course-select" name="wpt-teacher-options[calendar][course-displays][type]" class="wpt-input">
												<option value="all" <?=(!empty($calendarOptions) && !empty($calendarOptions['course-displays']['type']) && $calendarOptions['course-displays']['type'] == 'all') ? 'selected="selected"' : ''?>>All</option>
												<option value="none" <?=(!empty($calendarOptions) && !empty($calendarOptions['course-displays']['type']) && $calendarOptions['course-displays']['type'] == 'none') ? 'selected="selected"' : ''?>>None</option>
												<?php if (count($courses > 0) && !empty($courses)) : ?><option value="custom" <?=(!empty($calendarOptions) && !empty($calendarOptions['course-displays']['type']) && $calendarOptions['course-displays']['type'] == 'custom') ? 'selected="selected"' : ''?>>Custom</option><?php endif; ?>
											</select>
											<?php if (count($courses > 0) && !empty($courses)) : ?>
											<div class="wpt-dependent">
												<select name="wpt-teacher-options[calendar][course-displays][categories][]" class="wpt-input" multiple="multiple">
													<?php foreach ($courses as $course) : ?>
														<?php $selected = (!empty($calendarOptions) && !empty($calendarOptions['course-displays']['categories']) && in_array($course->slug, $calendarOptions['course-displays']['categories'])) ? 'selected="selected"' : ''; ?>
														<option value="<?=$course->slug?>" <?=$selected?>><?=$course->name?></option>
													<?php endforeach; ?>
												</select>
												<small>Displays only these selected courses on the calendar.</small>
											</div>
											<?php endif; ?>
										</div>
										<div class="clear"></div>
									</div>
									<div class="wpt-option-child-row">
										<label for="event-select">Select Event Type(s):</label>
										<div class="wpt-input-container">
											<select id="event-select" name="wpt-teacher-options[calendar][event-displays][type]" class="wpt-input">
												<option value="all" <?=(!empty($calendarOptions) && !empty($calendarOptions['event-displays']['type']) && $calendarOptions['event-displays']['type'] == 'all') ? 'selected="selected"' : ''?>>All</option>
												<option value="none" <?=(!empty($calendarOptions) && !empty($calendarOptions['event-displays']['type']) && $calendarOptions['event-displays']['type'] == 'none') ? 'selected="selected"' : ''?>>None</option>
												<?php if (count($events > 0) && !empty($events)) : ?><option value="custom" <?=(!empty($calendarOptions) && !empty($calendarOptions['event-displays']['type']) && $calendarOptions['event-displays']['type'] == 'custom') ? 'selected="selected"' : ''?>>Custom</option><?php endif; ?>
											</select>
											<?php if (count($events > 0) && !empty($events)) : ?>
											<div class="wpt-dependent">
												<select name="wpt-teacher-options[calendar][event-displays][categories][]" class="wpt-input" multiple="multiple">
													<?php foreach ($events as $event) : ?>
														<?php $selected = (!empty($calendarOptions) && !empty($calendarOptions['event-displays']['categories']) && in_array($event->slug, $calendarOptions['event-displays']['categories'])) ? 'selected="selected"' : ''; ?>
														<option value="<?=$event->slug?>"<?=$selected?>><?=$event->name?></option>
													<?php endforeach; ?>
												</select>
												<small>Displays only these selected event types on the calendar.</small>
											</div>
											<?php endif; ?>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							
							<div class="wpt-options wpt-last-row">
								<h4>Assignment Type Color Coding</h4>
								<p class="wpt-description">These settings apply a color to the different courses.</p>
								<div class="wpt-option-row" id="course-color-options">
									<?php if (count($courses > 0) && !empty($courses)) : ?>
										<?php foreach ($courses as $course) : ?>
											<div class="wpt-option-child-row">
												<label for="course-<?=$course->slug?>"><?=$course->name?></label>
												<?php 
													$color = (!empty($calendarOptions['colors']) && !empty($calendarOptions)) ? $calendarOptions['colors'] : '#5D943B';
													
													if (empty($color[$course->slug])) {
														$color = '#5D943B';
													} else {
														$color = (is_array($color)) ? $color[$course->slug] : $color;
													}
											
												?>
												<div class="color-container wpt-input-container">
													<?php $color = (!empty($color)) ? 'value="' . $color . '" style="background-color: ' . $color . '; color: #ffffff;"' : 'value="#5d943b" style="background-color: #5d943b; color: #ffffff;"'; ?>
													<input name="wpt-teacher-options[calendar][colors][<?=$course->slug?>]" id="course-<?=$course->slug?>" class="color-field" type="text" <?=$color?> />
													<div class="color-picker" id="course-color-picker-<?=$course->slug?>"></div>
												</div>
												<div class="clear"></div>
											</div>
										<?php endforeach; ?>
									<?php else : ?>
										<div class="wpt-option-child-row">
											<p class="error">Please add courses!</p>
											<div class="clear"></div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							
						</div>
						
						<div class="wpt-options-footer">
							<input name="save" type="submit" class="button-primary" value="Save Settings" />
							<div class="clear">
						</div>
						
					</div>
				</div>
				
			</div>
			<br class="clear" />
		</div>
		<input type="hidden" name="action" value="save">
	</form>
</div>

<form method="post">
	<p class="submit opts_submit">
		<input class="options_reset" name="reset" type="submit" value="Reset All" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('#course-select, #event-select').children('option').each(function (i) {
		if ($(this).is(':selected') && $(this).attr('value') == 'custom') {
			$(this).parent('select').next('.wpt-dependent').show();
			return;
		}
		
		$(this).parent('select').next('.wpt-dependent').hide();
	});
	
	// course/event display select
	$('#course-select, #event-select').change(function () {
		if ($(this).val() == 'custom') {
			$(this).next('.wpt-dependent').slideDown('fast');
			return;
		}
		
		$(this).next('.wpt-dependent').slideUp('fast');
	});

	// Course Colors
	var pickers = $('#course-color-options .color-container .color-picker');
    pickers.hide();
    
    pickers.each(function (i) {
    	var picker = $(this);
    	var input = picker.prev('.color-field').attr('id');
    	picker.farbtastic('#' + input);
    	picker.prev('.color-field').click(function () {
		   picker.fadeIn('fast');
		   return false; 
		});
    });
    
    $(document).mousedown(function() {
       	pickers.each(function() {
            var display = $(this).css('display');
            if (display == 'block')
                $(this).fadeOut('fast');
        });
    });
   
});
</script>