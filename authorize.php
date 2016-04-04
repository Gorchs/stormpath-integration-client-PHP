<?php

require 'vendor/autoload.php';

$access_token=$_GET["access_token"];
$addresses=authorize($access_token);
echo json_encode($addresses, JSON_PRETTY_PRINT);

function authorize($access_token)
{

	//$sURL = "http://localhost/api/contacts.json";
	$sURL = "http://abastorm.heroku.com/api/contacts.json";
	$sPD = "";
	$aHTTP = array
	  (
	  'http' => 
	    array(
	    'method'  => 'GET',
	    'header'  => 'Authorization: '.$access_token,
	    'content' => $sPD
	  )
	);

	$context = stream_context_create($aHTTP);
	$contents = file_get_contents($sURL, false, $context);
	$resources=json_decode($contents,TRUE);

	return($resources);
}

function print_r2($array)
{
$string = join(',',$array);

return($string);
}

?>
