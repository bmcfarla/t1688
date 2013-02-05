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
    }
    
    function index() {
    	$client = new Google_Client();
    	$client->setApplicationName("Troop1688_Calendar_Reader");

    	$cal = new Google_CalendarService($client);
    	
    	if (isset($_GET['logout'])) {
    		unset($_SESSION['token']);
    	}
    	
    	if (isset($_GET['code'])) {
    		$client->authenticate($_GET['code']);
    		$_SESSION['token'] = $client->getAccessToken();
    		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    	}
    	
    	if (isset($_SESSION['token'])) {
    		$client->setAccessToken($_SESSION['token']);
    	}

    	if ($client->getAccessToken()) {
    		$calList = $cal->calendarList->listCalendarList();
    		//debug($calList);
    		$this->set('callist', $calList);
    		$this->render('calendarList');
    	
    		$_SESSION['token'] = $client->getAccessToken();
    	} else {
    		$authUrl = $client->createAuthUrl();
    		$this->set('authUrl', $authUrl);
    		$this->render('login');
    		//debug("<a class='login' href='$authUrl'>Connect Me!</a>");
    	}
    	
    	echo "What";
    }
}