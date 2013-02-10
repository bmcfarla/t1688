<?php
$titleStateDate = date('M Y', strtotime($eventList[0]['start']['dateTime']));
$titleEndDate = date('M Y', strtotime($eventList[count($eventList) - 1]['start']['dateTime']));
$titleDate = $titleStateDate . " - " . $titleEndDate;
$runDate = date('Ymd');
?>
<div id="header-main">
	<div id="page-date"><?php echo $runDate ?></div>
	<div id="header-title">TROOP 1688 CALENDAR: <?php echo $titleDate ?> </div>
	<div id="header-body">Troop 1688 meets at the American Legion Post 66 @ 9605 Old Laurel-Bowie RD, May thru September in Class B Uniforms,
	and at the YMCA located at 3501 Moylan Drive, Bowie, MD, October thru April in Class A Uniforms, <span id=underline>unless noted on calendar</span></div>
	<div id="header-meetings">
		<div class="header-row">
			<div class="header-col1" id="plc-meeting">Patrol Leader Council Meetings:</div> 
			<div class="header-col2" id="plc-meeting-info">1st Tuesday of each month from 7pm - 8:30pm, <span id=underline>unless noted on calendar.</span></div>
		</div>
		<div class="header-row">
			<div class="header-col1" id="troop-meeting">Troop Meetings:</div> 
			<div class="header-col2" id=troop-meeting-info>All other Tuesdays of each month from 7pm - 8:30pm, <span id=underline>unless noted on calendar.</span></div>
		</div>
		<div class="header-row">
			<div class="header-col1" id="patrol-meeting">Patrol Meetings:</div>
			<div class="header-col2" id="patrol-meeting-info">At least once a month; arrangements of where & when made by Patrol Leader</div>
		</div>
		<div class="header-row">
			<div class="header-col1" id="committee-meeting">Troop Committee Meetings:</div>
			<div class="header-col2" id="committee-meeting-info">1st Tuesday of each month - contact Ben McFarland, Committee Chair</div>
		</div>
	</div>
</div>
<div id="calendar-body">
<?php
//debug($eventList);
$curMonth = '';
$header = 1;
$c = 0;
foreach($eventList as $event) {
	//echo $event['start']['dateTime'];
	$startTime = strtotime($event['start']['dateTime']);
	$endTime = strtotime($event['end']['dateTime']);
	
	$trip = null;
	
	if (isset($event['description'])) {
		if (preg_match('/Boy Leader:\s*(.*)\s*Adult Leader:\s*(.*)$/',$event['description'], $matches)) {
			$youthLeader = isset($matches[1]) ? $matches[1] : '&nbsp;';
			$adultLeader = isset($matches[2]) ? $matches[2] : ' &nbsp;';
		} elseif (preg_match('/Boy Leader:\s*(.*)\s*Adult Leader:\s*(.*)\s*Type:\s*(.*)$/',$event['description'], $matches)) {
			$youthLeader = isset($matches[1]) ? $matches[1] : '&nbsp;';
			$adultLeader = isset($matches[2]) ? $matches[2] : '&nbsp;';
			$type = isset($matches[3]) ? $matches[3] : '';
			
			if ($type == 'trip' || $type == 'Trip') {
				$trip = 'trip';
			}
			
		}
	} else {
		$youthLeader = '&nbsp;';
		$adultLeader = '&nbsp;';
	}
?>
<div class='row' >
	<?php if (isset($header)) : ?>
		<div class='col1 header' id='date'>
			<?php echo "DATE"; ?>
		</div>
		<div class='col2 header' id='date'>
			<?php echo "WHAT"; ?>
		</div>
		<div class='col3 header' id='date'>
			<?php echo "TIME"; ?>
		</div>
		<div class='col4 header' id='date'>
			<?php echo "WHERE"; ?>
		</div>
		<div class='col5 header' id='date'>
			<?php echo "YOUTH LDR"; ?>
		</div>
		<div class='col6 header' id='date'>
			<?php echo "ADULT LDR"; ?>
		</div>
		
		<?php unset($header); ?>
	<?php endif; ?>
</div>

<?php if (date("M 'y", $startTime) != $curMonth) :?>
	<div class='month-year' id='month-year'>
		<?php 
			echo date("M 'y", $startTime);
			$curMonth = date("M 'y", $startTime);
		?>
	</div>
<?php endif;?>

<div class='row' >
	<div class='col1<?php echo " $trip"; ?>' id='date'>
		<?php
			if (date("d", $startTime) == date("d", $endTime)) {
				echo date("d", $startTime);
			} else {
				echo date("d", $startTime) . ' - ' . date("d", $endTime);
			} 
		?>
	</div>
	<div class='col2<?php echo " $trip"; ?>' id='summary'>
		<?php echo $event['summary']; ?>
	</div>
	<div class='col3<?php echo " $trip"; ?>' id='startTime'>
		<?php 
			if (date("d", $startTime) == date("d", $endTime)) {
				echo date("g:i a", $startTime) . ' - ' . date("g:i a", $endTime); 
			} else {
				echo date("M d - g:i a", $startTime) . ' to ' . date("M d - g:i a", $endTime);
			}
		?>
	</div>
	<div class='col4<?php echo " $trip"; ?>' id='location'>
		<?php echo $event['location']; ?>
	</div>
	<div class='col5<?php echo " $trip"; ?>' id='youthLeader'>
		<?php echo $youthLeader ? $youthLeader : "&nbsp;"; ?>
	</div>
	<div class='col6<?php echo " $trip"; ?>' id='adultLeader'>
		<?php echo $adultLeader; ?>
	</div>
</div>	

<?php 
	if(++$c == 20000000) {
		break;
	}
}
?>
</div>
