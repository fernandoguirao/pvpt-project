<?php 
	global $post;
	$meta = get_post_custom($post->ID);
	
	$data['data'] = '';
	if (!empty($meta['wpt_event_date']))
		$data['date'] = $meta['wpt_event_date'][0];
	
	$data['endDate'] = '';
	$data['time'] = '';
	$data['endTime'] = '';
	$data['allDay'] = '';
	$data['timeMark'] = '';
	$data['endTimeMark'] = '';
	if (!empty($meta['wpt_event'])) {
		$meta['wpt_event'][0] = unserialize($meta['wpt_event'][0]);
		$data['endDate'] = (!empty($meta['wpt_event'][0]['end-date'])) ? $meta['wpt_event'][0]['end-date'] : '';
		$data['time'] = (!empty($meta['wpt_event'][0]['time'])) ? $meta['wpt_event'][0]['time'] : '';
		$data['endTime'] = (!empty($meta['wpt_event'][0]['end-time'])) ? $meta['wpt_event'][0]['end-time'] : '';
		$data['allDay'] = (!empty($meta['wpt_event'][0]['all-day'])) ? $meta['wpt_event'][0]['all-day'] : '';
		$data['timeMark'] = (!empty($meta['wpt_event'][0]['time-mark'])) ? $meta['wpt_event'][0]['time-mark'] : '';
		$data['endTimeMark'] =  (!empty($meta['wpt_event'][0]['end-time-mark'])) ? $meta['wpt_event'][0]['end-time-mark'] : '';
	}	
		
	$data = (object) $data;
?>
<fieldset>
	<input type="hidden" name="post-type" value="event" />
	<div>
		<label for="date">Start Date:</label>
		<input type="text" name="date" id="date" value="<?=(!empty($data->date)) ? $data->date : ''?>" />
	</div>
	<div>
		<label for="end-date">End Date:</label>
		<input type="text" name="event[end-date]" id="end-date" value="<?=(!empty($data->endDate)) ? $data->endDate : ''?>" />
	</div>
	<div>
		<label for="all-day">All Day?</label>
		<input type="checkbox" name="event[all-day]" id="all-day" value="true" <?=(!empty($data->allDay)) ? 'checked="checked"' : ''?> />
	</div>
	<div id="time-range">
		<div>
			<label for="time">Start Time:</label>
			<input type="text" name="event[time]" id="time" value="<?=$data->time?>" />
			<select name="event[time-mark]">
				<option value="AM"<?=($data->timeMark == 'AM') ? ' selected="selected"' : ''?>>AM</option>
				<option value="PM"<?=($data->timeMark == 'PM') ? ' selected="selected"' : ''?>>PM</option>
			</select>
		</div>
		<div>
			<label for="time">End Time:</label>
			<input type="text" name="event[end-time]" id="end-time" value="<?=$data->endTime?>" />
			<select name="event[end-time-mark]">
				<option value="AM"<?=($data->endTimeMark == 'AM') ? ' selected="selected"' : ''?>>AM</option>
				<option value="PM"<?=($data->endTimeMark == 'PM') ? ' selected="selected"' : ''?>>PM</option>
			</select>
		</div>
	</div>
</fieldset>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$("#date, #end-date").datepicker();
	
	if ($('#all-day').is(':checked')) {
		$('#time-range').slideUp('fast');
	} else {
		$('#time-range').slideDown('fast');
	}
	
	$('#all-day').change(function () {
		if ($(this).is(':checked')) {
			$('#time-range').slideUp('fast');
		} else {
			$('#time-range').slideDown('fast');
		}
	});
	
});
</script>