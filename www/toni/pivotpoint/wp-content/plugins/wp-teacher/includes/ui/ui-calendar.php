<?php 
	global $post;
	
	// Calendar Options
	$calendarOptions = get_option('wpt-teacher-options');
	$calendarOptions = (!empty($calendarOptions) && !empty($calendarOptions['calendar'])) ? $calendarOptions['calendar'] : array();
	
	/*
	echo "<h2>Calendar Options</h2>";
	echo "<pre>";
	print_r($calendarOptions);
	echo "</pre>";
	*/
	
	// ------------------------------------------------------
	// Assignment Listings
	// ------------------------------------------------------
	$selectedCourse = $calendarOptions['course-displays'];
	if ($selectedCourse['type'] == 'all' || (empty($selectedCourse['categories']) && $selectedCourse['type'] == 'custom')) {
		$courses = new WP_Query(array(
			'post_type' => 'assignment',
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'meta_key'=> 'wpt_assignment_dueDate'
		));
	} else if ($selectedCourse['type'] == 'none') {
		
	} else {
		$courses = new WP_Query(array(
			'post_type' => 'assignment',
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'tax_query' => array(
				array(
					'taxonomy' => 'course',
					'field' => 'slug',
					'terms' => $selectedCourse['categories']
				)
			),
			'meta_key'=> 'wpt_assignment_dueDate'
		));
	}
	
	$assignments = array();
	
	$courseColors = (!empty($calendarOptions) && !empty($calendarOptions['colors'])) ? $calendarOptions['colors'] : '#5D943B';
	
	if ($selectedCourse['type'] != 'none') {
		while ($courses->have_posts()) {
			$courses->the_post();
			$meta = get_post_meta(get_the_ID(), 'wpt_assignment_dueDate', true);
			
			$terms = get_the_terms(get_the_ID(), 'course');
			
			if (!empty($terms)) {
				$postTerm = '';
				foreach ($terms as $term) {
					$postTerm = $term->slug;
					break;
				}
			}
			
			$color = (is_array($courseColors)) ? $courseColors[$postTerm] : $courseColors;
			
			$assignments[] = array(
				'title' => (!empty($terms)) ? $term->name . ': ' . html_entity_decode(get_the_title()) : html_entity_decode(get_the_title()),
				//'title' => ' ',
				'start' => $meta,
				'className' => (!empty($terms)) ? array('assignment', 'course-' . $postTerm) : array('assignment'),
				'url' => get_permalink(),
				'color' => $color,
				'background-color' => $color,
				'info' => array(
					'title' => get_the_title(),
					'link' => get_permalink()
				)
			);
		}
	}
	wp_reset_postdata();
	

	// ------------------------------------------------------
	// Events Listings
	// ------------------------------------------------------
	$selectedEvent = $calendarOptions['event-displays'];
	if ($selectedEvent['type'] == 'all' || (empty($selectedEvent['categories']) && $selectedEvent['type'] == 'custom')) {
		$_events = new WP_Query(array(
			'post_type' => 'event',
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'meta_key'=> 'wpt_event_date'
		));
	} else if ($selectedEvent['type'] == 'none') {
		
	} else {
		$_events = new WP_Query(array(
			'post_type' => 'event',
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'tax_query' => array(
				array(
					'taxonomy' => 'event-type',
					'field' => 'slug',
					'terms' => $selectedEvent['categories']
				)
			),
			'meta_key'=> 'wpt_event_date'
		));
	}
	
	$events = array();
	if ($selectedEvent['type'] != 'none') {
		while ($_events->have_posts()) {
			$_events->the_post();
			$event_startDate = get_post_meta(get_the_ID(), 'wpt_event_date', true);
			$event_meta = get_post_meta(get_the_ID(), 'wpt_event');
			$event_meta = $event_meta[0];
			
			$newStart = date('Y-n-d', strtotime($event_startDate)) . 'T' . date('H:i:00', strtotime($event_meta['time'] . ':00' . $event_meta['time-mark'])) . 'Z';
			$newEnd = date('Y-n-d', strtotime($event_meta['end-date'])) . 'T' . date('H:i:00', strtotime($event_meta['end-time'] . ':00' . $event_meta['end-time-mark'])) . 'Z';
			
			
			#echo "Event: " . get_the_title() . '<br />';
			#echo 'Start: ' . $newStart . '<br />';
			#echo 'End: ' . $newEnd . '<br />';
			#echo '-----------------------------<br /><br />';
			
			
			$terms = get_the_terms(get_the_ID(), 'event-type');
			
			if (!empty($terms)) {
				$postTerm = '';
				foreach ($terms as $term) {
					$postTerm = $term->slug;
					break;
				}
			}
			
			if (empty($event_meta['all-day'])) {
				
				if ($newStart == $newEnd) {
					$events[] = array(
						'title' => html_entity_decode(get_the_title()),
						'start' => $newStart,
						'end' => $newEnd,
						'allDay' => ((!empty($event_meta['all-day']))), 
						'className' => (!empty($terms)) ? array('event', 'event-' . $postTerm) : array('event'),
						'url' => get_permalink(),
					);
					
				} else {
					
					$dayCount = date('d', strtotime($newEnd)) - date('d', strtotime($newStart));
					for ($i = 0; $i <= $dayCount; $i++) {
						
						$day = ((int) date('d', strtotime($event_startDate))) + $i;
						
						$startDate = explode('/', $event_startDate);
						$endDate = explode('/', $event_meta['end-date']);
						
						$startDate[1] = $day;
						$endDate[1] = $day;
						
						$startDate = implode('/', $startDate);
						$endDate = implode('/', $endDate);
						
						$newStart = date('Y-n-d', strtotime($startDate)) . 'T' . date('H:i:00', strtotime($event_meta['time'] . ':00' . $event_meta['time-mark'])) . 'Z';
						$newEnd = date('Y-n-d', strtotime($endDate)) . 'T' . date('H:i:00', strtotime($event_meta['end-time'] . ':00' . $event_meta['end-time-mark'])) . 'Z';
						
						$events[] = array(
							'title' => get_the_title(),
							'start' => $newStart,
							'end' => $newEnd,
							'allDay' => ((!empty($event_meta['all-day']))), 
							'className' => (!empty($terms)) ? array('event', 'event-' . $postTerm) : array('event'),
							'url' => get_permalink(),
						);
						
					}
					
				}
				
			} else {
				
				$events[] = array(
					'title' => html_entity_decode(get_the_title()),
					'start' => $event_startDate,
					'end' => $event_meta['end-date'],
					'allDay' => 'true', 
					'className' => (!empty($terms)) ? array('event', 'event-' . $postTerm) : array('event'),
					'url' => get_permalink(),
				);
				
			}
		}
	}
	wp_reset_postdata();
	
?>

<div id="wpt-calendar"></div>
<!--<p>Calendar Powered By: <a href="http://arshaw.com/fullcalendar/" title="FullCalendar" target="_blank">FullCalendar</a></p>-->
<script type="text/javascript">
jQuery(document).ready(function($) {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		<?php 
			$viewOptions = (!empty($calendarOptions['modes'])) ? implode(',', $calendarOptions['modes']) : '';
		?>
		var viewOptions = '<?=(!empty($viewOptions)) ? 'month,' . $viewOptions . ',' : ''?>';
		$('#wpt-calendar').fullCalendar({
			editable: false,
			eventSources: [
				{
		            events: <?=json_encode($assignments)?>
		        },
		        {
		            events: <?=json_encode($events)?>
		        }
		        <?php if (empty($calendarOptions) || empty($calendarOptions['show-holiday'])) : ?>
		        , {
			        url: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic'
		        }
		        <?php endif; ?>
		    ],
		    eventRender: function(event, element) {
		    	if (typeof event.info == 'undefined')
		    		return;
		    },
			header: {
				left: 'prev today',
				center: 'title',
				right: viewOptions + 'next'
			}
		});

		
	});
</script>