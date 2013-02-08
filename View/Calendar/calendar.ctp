<?php
//debug($eventList);
$c = 0;
foreach($eventList as $event) {
	//echo $event['start']['dateTime'];
	$startTime = strtotime($event['start']['dateTime']);
	$endTime = strtotime($event['end']['dateTime']);
	
	if (isset($event['description'])) {
		preg_match('/Boy Leader:\s*(.*)\s*Adult Leader:\s*(.*)$/',$event['description'], $matches);
		//debug($matches);
		$youthLeader = isset($matches[1]) ? $matches[1] : '';
		$adultLeader = isset($matches[2]) ? $matches[2] : '';
	} else {
		$youthLeader = '';
		$adultLeader = '';
	}
?>

<div class='row'>
	<div class='col1' id='date'>
		<?php echo date("M d y", $startTime); ?>
	</div>
	<div class='col2' id='summary'>
		<?php echo $event['summary']; ?>
	</div>
	<div class='col3' id='startTime'>
		<?php echo date("g:i a", $startTime); ?>
	</div>
	<div class='col4' id='endTime'>
		<?php echo date("g:i a", $endTime); ?>
	</div>
	<div class='col5' id='location'>
		<?php echo $event['location']; ?>
	</div>
	<div class='col6' id='youthLeader'>
		<?php echo $youthLeader; ?>
	</div>
	<div class='col7' id='adultLeader'>
		<?php echo $adultLeader; ?>
	</div>
</div>	

<?php 
	if(++$c == 20000000) {
		break;
	}
}
?>
