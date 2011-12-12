<?php
// A simple "quick and dirty" console :-)
require_once('config.php');
// standard parameters
$method = (isset($_REQUEST['method']) && $_REQUEST['method'] != '') ? $_REQUEST['method'] : "search";
$format = (isset($_REQUEST['format']) && $_REQUEST['format'] != '') ? $_REQUEST['format'] : "json";
$callback = (isset($_REQUEST['callback']) && $_REQUEST['callback'] != '') ? $_REQUEST['callback'] : "";
$lang = (isset($_REQUEST['lang']) && $_REQUEST['lang'] != '') ? $_REQUEST['lang'] : "nl";
$country = (isset($_REQUEST['country']) && $_REQUEST['country'] != '') ? $_REQUEST['country'] : "nl";
$raw_data = (isset($_REQUEST['raw_data']) && $_REQUEST['raw_data'] == 'on') ? TRUE : FALSE;

// additional key parameters
$key1 = (isset($_REQUEST['key1']) && $_REQUEST['key1'] != '') ? $_REQUEST['key1'] : "";
$key2 = (isset($_REQUEST['key2']) && $_REQUEST['key2'] != '') ? $_REQUEST['key2'] : "";
$key3 = (isset($_REQUEST['key3']) && $_REQUEST['key3'] != '') ? $_REQUEST['key3'] : "";
$key4 = (isset($_REQUEST['key4']) && $_REQUEST['key4'] != '') ? $_REQUEST['key4'] : "";

// additional value parameters
$val1 = (isset($_REQUEST['val1']) && $_REQUEST['val1'] != '') ? $_REQUEST['val1'] : "";
$val2 = (isset($_REQUEST['val2']) && $_REQUEST['val2'] != '') ? $_REQUEST['val2'] : "";
$val3 = (isset($_REQUEST['val3']) && $_REQUEST['val3'] != '') ? $_REQUEST['val3'] : "";
$val4 = (isset($_REQUEST['val4']) && $_REQUEST['val4'] != '') ? $_REQUEST['val4'] : "";
?>
<html>
<head>
<title>API console</title>
</head>
<body> 
<h1>API console</h1>
<h2>Parameters</h2>

<form action="console.php" method="post">	
<pre>

RAW-data		<input type="checkbox" name="raw_data" <?=($raw_data) ? 'checked="checked"' : '';?>" />
method: 		<input type="text" name="method" value="<?=$method?>" />	getCurrentRate/getActiveSources/search/etc ..
format: 		<input type="text" name="format" value="<?=$format?>" /> 	XML/JSON
callback: 		<input type="text" name="callback" value="<?=$callback?>" />	Callback for JSON
lang: 			<input type="text" name="lang" value="<?=$lang?>" />	nl,en,fr,de,se,dk,pl,ru,es,it
country: 		<input type="text" name="country" value="<?=$country?>" />	nl,gb,fr,be,de,se,dk,pl,ru,es,us,it

Optional
<input type="text" name="key1" value="<?=$key1?>" /> 	<input type="text" name="val1" value="<?=$val1?>" />	firstname	Bas
<input type="text" name="key2" value="<?=$key2?>" /> 	<input type="text" name="val2" value="<?=$val2?>" />	lastname	van Dorst
<input type="text" name="key3" value="<?=$key3?>" /> 	<input type="text" name="val3" value="<?=$val3?>" />	sources		myspace,linkedin
<input type="text" name="key4" value="<?=$key4?>" /> 	<input type="text" name="val4" value="<?=$val4?>" />



<input type="submit" name="submit" value="API-request">
	</pre>
</form>
<h2>Result</h2>

<? 
if(isset($_REQUEST['submit'])){ 
	try {
		$wow = new WOW_Client($public_key,$private_key);
		// available methods search, getActiveSources, getCurrentRate, getCategories, getPopularSources
		$wow->setMethod($method);
		$wow->setOutputAsRawData($raw_data);
		$parameters = array('format' => $format,
							'callback' => $callback, // only json
							'lang' => $lang,
							'country' => $country); 
		if($key1 != "" && $val1 != "") $parameters[$key1] = $val1;
		if($key2 != "" && $val2 != "") $parameters[$key2] = $val2;
		if($key3 != "" && $val3 != "") $parameters[$key3] = $val3;
		if($key4 != "" && $val4 != "") $parameters[$key4] = $val4;
		$wow->setParameters($parameters);
		$output = $wow->getOutput();
		if($raw_data) {
			$output = htmlentities($output);
		}
	} catch (WOW_Exception $e) {
		$output = 'Error: #'.$e->getCode().' > '.$e->getMessage();
	}
	
	print '<pre>';
	print_r($output);
	print '</pre>';
} else {
	print '<pre>Please do a request</pre>';
} 
?>
</body>
</html>

