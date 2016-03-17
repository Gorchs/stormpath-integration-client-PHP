<?php

require 'vendor/autoload.php';

/*these are the api_key/api_secret pair needed to authenticate the call against Strompaths API */
$keys = parse_ini_file(".stormpath/apiKey.properties", true);
$api_key=$keys["apiKey.id"];
$api_secret=$keys["apiKey.secret"];

/*The username and password below belong to the user that is requesting the access token. These two values are entered by the user on a login/pass form */
$username=$_GET["username"];
$password=$_GET["password"];

/*This is the 3scale app_id that we will store the token in*/
$app_id="a268377f";


$token=get_token_through_3scale($username,$password, $app_id);
echo $token;
/*No need to call the store token in 3scale, as Nginx will deal lwith storing the token in 3scale */

function get_token_through_3scale($username,$password, $app_id)
{
	$sURL = "http://localhost/oauth/token?provider_key=<your 3scale provider id here>";
	$sPD = "grant_type=password&username=".$username."&password=".$password."&app_id=".$app_id; // The POST Data
	$aHTTP = array
	  (
	  'http' => 
	    array(
	    'method'  => 'POST',
	    'header'  => 'Content-type: application/x-www-form-urlencoded',
	    'content' => $sPD
	  )
	);

	$context = stream_context_create($aHTTP);
	$contents = file_get_contents($sURL, false, $context);

	$token=json_decode($contents,TRUE);

	return($token["access_token"]);
}


?>