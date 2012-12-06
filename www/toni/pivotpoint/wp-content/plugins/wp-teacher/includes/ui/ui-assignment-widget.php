<?php
global $wpdb;

$displayTitle = (!empty($title)) ? $title : 'Assignments';
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
		'taxonomy' => 'type',
		'field' => 'slug',
		'terms' => $type
	);
}


$assignments = new WP_Query(array(
	'post_type' => 'assignment',
	'tax_query' => $taxQuery,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key'=> 'wpt_assignment_dueDate',
	'posts_per_page' => $numPosts
));
?>

<?=$before_widget?>
	<?=$displayTitle?>
	<?php if ($assignments->have_posts()) : ?>
	<ul>
		<?php $showCount = 0;?>
		<?php while ($assignments->have_posts()) : $assignments->the_post(); ?>
			<?php 
				$meta = get_post_meta(get_the_ID(), 'wpt_assignment_dueDate', true);
				
				$term = wp_get_post_terms(get_the_ID(), 'course');
				$term = $term[0];
				
				$color = (is_array($courseColors)) ? $courseColors[$term->slug] : $courseColors;
			?>
			<?php if (is_upcoming ($meta)) : ?>
				<li>
					<span class="due-date block">Due <?=(is_today($meta)) ? '<strong>Today</strong>' : ' on <strong>' . str_replace('/', '.', $meta) . '</strong>'?> in <a href="<?=get_term_link($term->slug, 'course')?>" class="course-title" style="color: <?=$color?>;" title="<?=$term->name?>"><?=ucfirst($term->name)?></a> &raquo;</span>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</li>
				<?php $showCount++;?>
			<?php endif; ?>
		<?php endwhile; ?>
		
		<?php if ($showCount == 0) : ?>
		<li
			<p><em>There are no assignments due this month.</em></p>
		</li>
		<?php endif; ?>
		
	</ul>
	<?php else : ?>
	<div class="container">
		<div class="wrapper">
			<p><em>There are no assignments due.</em></p>
		</div>
	</div>
	<?php endif; ?>
<?=$after_widget?>
<?php wp_reset_query(); ?>