<?php

require 'vendor/autoload.php';
$keys = parse_ini_file(".stormpath/apiKey.properties", true);

$username=$_GET["username"];
$password=$_GET["password"];
$app_id="a268377f";
$api_key=$keys["apiKey.id"];
$api_secret=$keys["apiKey.secret"];
/*$token=get_token_from_stormpath($username,$password, $api_key,$api_secret);*/
$token=get_token_through_3scale($username,$password, $app_id);
echo $token;
/*if we use the get_token_through_3scale there is no need to call the store token, as Nginx will also store the token in the same call */
/*if we use the get_token_from_stormpath then we shoudl comment out the lien below so that the token is stored */
/*store_access_token_3scale("962f405ac06b3ecf42623edce6cb1a92","2555417729973","a268377f",$token);*/



function get_token_through_3scale($username,$password, $app_id)
{
	$sURL = "http://localhost/oauth/token?provider_key=962f405ac06b3ecf42623edce6cb1a92";
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


function get_token_from_stormpath($username,$password, $api_key,$api_secret)
{
	$sURL = "https://".$api_key.":".$api_secret."@api.stormpath.com/v1/applications/22jMRtt7GeNyaQ3LQ4ZjrC/oauth/token";
	$sPD = "grant_type=password&username=".$username."&password=".$password; // The POST Data
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

function store_access_token_3scale($provider_key, $service_id, $app_id, $access_token)
{
	$sURL = "http://su1.3scale.net/services/".$service_id."/oauth_access_tokens.xml";
	$sPD = "provider_key=".$provider_key."&app_id=".$app_id."&token=".$access_token; 

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
}

?>