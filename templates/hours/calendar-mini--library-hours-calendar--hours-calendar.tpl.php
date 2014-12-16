<?php
/**
 * @file
 * Template to display a view as a mini calendar month.
 *
 * @see template_preprocess_calendar_mini.
 *
 * $day_names: An array of the day of week names for the table header.
 * $rows: An array of data for each day of the week.
 * $view: The view.
 * $min_date_formatted: The minimum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $max_date_formatted: The maximum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 *
 * $show_title: If the title should be displayed. Normally false since the title is incorporated
 *   into the navigation, but sometimes needed, like in the year view of mini calendars.
 *
 */
	// js for popup
	drupal_add_js('sites/all/themes/ncsulib_foundation/scripts/hours.js', 'file');

	$params = array(
	  'view' => $view,
	  'granularity' => 'month',
	  'link' => FALSE,
	);
	$cnt=1;
	$date = (isset($_GET['date'])) ? strtotime($_GET['date']) : date('U');
	$month = date('F',$date);
	$year = date('Y', $date);
	if(date("m", $date) > 1){
		$prev_month = date("m", $date)-1;
	 	$prev_year = $year;
	} else{
	 	$prev_month = 12;
	 	$prev_year = $year-1;
	}
	if(date("m", $date) < 12){
		$next_month = date("m", $date)+1;
		$next_year = $year;
	} else{
		$next_month = 1;
		$next_year = $year+1;
	}
	$prev_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.arg(0).'/'.arg(1).'/'.arg(2).'?date='.$prev_year.'-'.$prev_month;
	$next_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.arg(0).'/'.arg(1).'/'.arg(2).'?date='.$next_year.'-'.$next_month;
?>

<div class="hours-pager">
	<div class="date-nav-wrapper clearfix">
		<div class="date-nav item-list">
			<div class="date-heading">
				<h3 class="subheader" id="hours-month"><?php echo $month; ?></h3>
			</div>
			<ul class="page">
				<li class="date-prev">
					<a href="<?php echo $prev_url; ?>#hours-month">«</a>
				</li>
				<li class="date-next">
					<a href="<?php echo $next_url; ?>#hours-month">»</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="schedule-block">

	<?php
		/* Regular Schedule*/
		include_once 'block--block--94.tpl.php';
	?>
	<div id="cal">
		<div class="hours-calendar">
			<table class="mini">
				<thead>
					<tr>
						<?php foreach ($day_names as $cell): ?>
						<th class="cal-label">
							<?php echo $cell['data']; ?>
						</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ((array) $rows as $row): ?>
					<tr>
						<?php foreach ($row as $cell):
						    $date_str = preg_split('/-/si',$cell['id']);
						    $year = $date_str[1];
						    $month = $date_str[2];
						    $day = $date_str[3]+0;
						    if(!strpos($cell['class'], 'empty')){
								$cal_ary = hours_get_cal_data($year, $month, $day);
						    } else{
								$cal_ary = array();
						    }
						?>
						<td
							 id="<?= $cell['id'];?>"
							 class="<?= $cell['class'].' '.$cal_ary['json']->open_display.' '.$cal_ary['color']; ?>"
							 data-display="<?= $cal_ary['json']->display; ?>"
							 data-date="<?= $cal_ary['monthName'].' '.$day.', '.$year;?>"
						>

						<?php
							// get day
							$day = strip_tags($cell['data'])+0;
							if($day > 0){echo $day;}
						?>
						</td>
						<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>



<br>
<br>
<br>
<br>
<br>
<br>




		<?php if(arg(1) == 'hunt' && arg(2) == 'general'): ?>
		<div class="row hide-for-small-only">
			<div class="columns medium-12">
				<div class="exam-hours-alert">
					<p><div class="left-triangle"></div>Wolfpack One Card required for entry Dec 4-16.</p>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>

