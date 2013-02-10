<?php
echo $this->html->script('http://code.jquery.com/jquery-1.9.1.min.js', array('inline'=>false));
echo $this->html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js', array('inline'=>false));
echo $this->html->script('calendar', array('inline'=>false));

echo $this->Form->create('calendar');
echo $this->Form->input('Start', array('id'=>'fromDate'));
echo $this->Form->input('End', array('id'=>'toDate'));
echo $this->Form->end('submit');