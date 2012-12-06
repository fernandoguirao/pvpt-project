<?php
global $wpdb;

$displayTitle = (!empty($title)) ? $title : 'Events';
$displayTitle = $before_title . $displayTitle . $after_title;

// Taxonomy Query
$taxQuery = array();

if ($course != 'all') {
	$taxQuery[] = array(
		'taxonomy' => 'course',
		'field' => 'slug',
		'terms' => $course
	);
}

if ($type != 'any') {
	$taxQuery[] = array(
		'taxonomy' => 'event-type',
		'field' => 'slug',
		'terms' => $type
	);
}

$events = new WP_Query(array(
	'post_type' => 'event',
	'tax_query' => $taxQuery,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key'=> 'wpt_event_date',
	'posts_per_page' => $numPosts
));
?>

<?=$before_widget?>
	<?=$displayTitle?>
	<?php if ($events->have_posts()) : ?>
		<ul>
			<?php $showCount = 0;?>
			<?php while ($events->have_posts()) : $events->the_post(); ?>
				<?php 
					$startDate = get_post_meta(get_the_ID(), 'wpt_event_date', true);
					$meta = get_post_meta(get_the_ID(), 'wpt_event');
					$meta = (!empty($meta)) ? $meta[0] : '';
					
					$endDate = (!empty($meta)) ? $meta['end-date'] : '';
					
					$term = wp_get_post_terms(get_the_ID(), 'course');
					$term = (!empty($term)) ? $term[0] : '';
					
					$eventTerm = wp_get_post_terms(get_the_ID(), 'event-type');
					$eventTerm = (!empty($eventTerm)) ? ((is_array($eventTerm)) ? $eventTerm[0] : $eventTerm) : '';
					
					$color = (is_array($courseColors)) ? $courseColors[$term->slug] : $courseColors;
				?>
				<?php if (is_date_allowed ($startDate)) : ?>
					
					<?php if (empty($meta)) continue; ?>
					
					<?php 
						
						// Display Means
						$timeIndicator = (is_today($startDate) || in_progress($startDate, $endDate)) ? '<strong>Today</strong>' : ' On <strong>' . str_replace('/', '.', $startDate) . '</strong>';
						$showEvent = true;
						switch ($displayMeans) {
							case 'inProgress':
								$showEvent = in_progress($startDate, $endDate);
							break;
							case 'thisWeek':
								$showEvent = is_week($startDate, $endDate);
							break;
							case 'thisMonth':
								$showEvent = true;
							break;
							case 'upcoming':
							default: 
								$showEvent = (is_upcoming($startDate));
							break;
						}
						
					?>
					<?php if ($showEvent) : ?>
						<li>
							<span class="due-date block"><?=$timeIndicator?> &raquo;</span>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</li>
						<?php $showCount++;?>
					<?php endif; ?>
					
				<?php endif; ?>
			<?php endwhile; ?>
			
			<?php if ($showCount == 0) : ?>
				<li>
					<p><em>There are no events for this month.</em></p>
				</li>
			<?php endif; ?>
			
		</ul>
	<?php else : ?>
		<div class="container">
			<div class="wrapper">
				<p><em>There are no events.</em></p>
			</div>
		</div>
	<?php endif; ?>
<?=$after_widget?>
<?php wp_reset_query(); ?>