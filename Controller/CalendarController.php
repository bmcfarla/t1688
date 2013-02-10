<?php
require_once('t1688Calendar\Vendor' . DS . 'google-api-php-client\src\Google_Client.php');
require_once('t1688Calendar\Vendor' . DS . 'google-api-php-client\src\contrib\Google_CalendarService.php');

class CalendarController extends AppController
{
	
    public $components = array('RequestHandler');
    public $helpers = array('Html','Form');
    
    function beforeFilter()
    {
    	session_start();
    	$this->client = new Google_Client();
    	$this->client->setApplicationName("Troop1688_Calendar_Reader");
    	
    	$this->cal = new Google_CalendarService($this->client);
    	$uses = false;
    }
    
    function index() {
    	
    }
    
    function add() {
 
    	set_time_limit(0);
    	if (isset($_GET['logout'])) {
    		unset($_SESSION['token']);
    	}
    	
    	if (isset($_GET['code'])) {
    		$this->client->authenticate($_GET['code']);
    		$_SESSION['token'] = $this->client->getAccessToken();
    		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    	}
    	
    	if (isset($_SESSION['token'])) {
    		$this->client->setAccessToken($_SESSION['token']);
    	}

    	if ($this->client->getAccessToken()) {
    		//$toDate = "20130331";
    		//$fromDate = "20130101";
    		
    		$toDate = $this->request->data['calendar']['End'];
    		$fromDate = $this->request->data['calendar']['Start'];
    		
    		//$this->calList = $this->cal->events->listEvents('ei13vj25sj5bhs8nku7j0bipao@group.calendar.google.com',array('orderBy'=>'starttime','singleEvents'=>true,'timeMin'=>date('c',strtotime($fromDate)),'timeMax'=>date('c',strtotime($toDate))));
    		$this->calList = $this->cal->calendarList->listCalendarList();
    		
    		$calId = $this->_getCalendarId('BSA Troop1688 Calendar');
    		
    		$this->eventList = $this->cal->events->listEvents($calId, array(
    			'orderBy'=>'starttime',
    			'singleEvents'=>true,
    			'timeMin'=>date('c',strtotime($fromDate)),
    			'timeMax'=>date('c',strtotime($toDate))
    		));
    		
    		//5ck5uqtinscqq7ssjlo36vfgb0_20120229T000000Z
    		//$this->calList = $this->cal->calendarList->listCalendarList();
    		//debug($this->calList);
    		
    		$this->set('eventList', $this->eventList['items']);
    		$this->layout = 'calendar';
    		$this->render('calendar');
    	
    		$_SESSION['token'] = $this->client->getAccessToken();
    	} else {
    		$authUrl = $this->client->createAuthUrl();
    		$this->set('authUrl', $authUrl);
    		$this->render('login');
    		//debug("<a class='login' href='$authUrl'>Connect Me!</a>");
    	}
    	
    }
    
    function _getCalendarId($name){
    	foreach ($this->calList['items'] as $c) {
    		//debug($c['summary']);
    		if ($c['summary'] == $name) {
    			//debug($c['id']);
    			//exit;
    			return $c['id'];
    		}
    	}
    	
    	return 0;
    }
}