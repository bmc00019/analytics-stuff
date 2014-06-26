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
$accounts = $service->management_accounts->listManagementAccounts();

$tablet_mobile = 'gaid::-11';

$segments = $service->management_segments->listManagementSegments();
$goals = $service->management_goals->listManagementGoals("~all", "~all", "~all");
$profiles = $service->management_profiles->listManagementProfiles("~all", "~all"); 

// data variables
// $ids = 'ga:599058';
$ids = 'ga:73730733';
$start_date = '2014-06-01';
$end_date = '2014-06-24';
// $metrics = "ga:sessions,ga:visits,ga:pageviews,ga:users";
$metrics = 'ga:sessions,ga:visits,ga:pageviews';
$dimensions = "ga:browser";
$optParams = array(
	'segment' => $tablet_mobile,
	);
$mobile_tablet_sessions = $service->data_ga->get($ids,$start_date,$end_date,$metrics,$optParams);

$c_start_date = '2013-01-01';
$c_end_date = '2013-12-31';
$c_dimensions = 'ga:country';
$c_metrics = 'ga:sessions';
$c_optParams = array(
	'sort' => '-ga:sessions',
	'dimensions' => $c_dimensions,
	);
$sessions_by_country = $service->data_ga->get($ids,$c_start_date,$c_end_date,$c_metrics,$c_optParams);


// $mts = array_pop($mobile_tablet_sessions);

echo "<pre>";

echo "Mobile and Tablet Segment for June 1 - June 24: ";
echo "<br/>";
$mts = $mobile_tablet_sessions->rows;
$mts = array_pop($mts);
echo "Users: " . $mts[0] . "<br/>";
echo "Sessions: " . $mts[1] . "<br/>";
echo "Page Views: " . $mts[2] . "<br/>";

echo "<br/><br/>";
echo "Total Visits in 2013 by Country (descending): ";
echo "<br/>";
// var_dump($sessions_by_country);
$sbs = $sessions_by_country->rows;
var_dump($sbs);
// var_dump($sbs);
// foreach ($sbs as $key => $value) {
// 	$bla = array_pop($sbs);
// 	var_dump($bla);
// }
?>