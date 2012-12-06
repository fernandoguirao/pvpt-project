<?php 
// Filter for a date range of assignments
function is_date_allowed ($date) {
	$date = strtotime($date);
	$startDate = strtotime(date('Y-n-1'));
	$endDate = strtotime(date('Y-n-t'));
	
	return ($date >= $startDate && $date <= $endDate) ? true : false;
}

function is_upcoming ($date) {
	$date = strtotime($date);
	$startDate = strtotime(date('Y-n-d'));
	$endDate = strtotime(date('Y-n-t'));
	
	return ($date >= $startDate && $date <= $endDate) ? true : false;
}

function is_today ($date) {
	$date = strtotime($date);
	$foundDate = strtotime(date('Y-n-d'));
	
	return ($date == $foundDate);
}

function in_progress ($startDate, $endDate) {
	$today = strtotime(date('Y-n-d'));
	$startDate = strtotime($startDate);
	$endDate = strtotime($endDate);
	
	return ($today >= $startDate && $today <= $endDate);
}

function is_week ($startDate, $endDate) {
	$startDate = date('W', strtotime($startDate));
	$endDate = date('W', strtotime($endDate));
	$week = date('W');
	
	return ($startDate == $week || ($week >= $startDate && $week <= $endDate));
}
?>