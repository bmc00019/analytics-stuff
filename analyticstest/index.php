<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'Google/Client.php';
require_once 'Google/Auth/AssertionCredentials.php';
require_once 'Google/Service/Analytics.php';

$key = '78550efddd6eaa6fdeede0286d788b26e54862fd-privatekey.p12';

$creds = new Google_Auth_AssertionCredentials(
	'983324700705-h155d5sqcmogkanmkb8ssa70oon0va3p@developer.gserviceaccount.com',

	array('https://www.googleapis.com/auth/analytics.readonly'),

	file_get_contents($key)
);

$client = new Google_Client();
$client->setApplicationName('Vice Analytics Test');
$client->setDeveloperKey('AIzaSyAAIJMm36rBVWIFL94NdqWxjLXgDxiwvg0');
$client->setAssertionCredentials($creds);

$service = new Google_Service_Analytics($client);

$test = $service->management_webproperties->listManagementWebproperties('~all');

$analyticsService = new Google_Service_Analytics($client);
$ga = $service->ga;




echo "<pre>";
var_dump($ga);