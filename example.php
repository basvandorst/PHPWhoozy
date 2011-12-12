<?php
require_once('config.php');
print '<pre>';

try {
	$wow = new WOW_Client($public_key,$private_key);
	$wow->setMethod('search');
	
	$parameters = array('format' => 'json',
						'lang' => 'nl',
						'country' => 'nl',
						'firstname' => 'Jan-Peter',
						'lastname' => 'Balkenende',
						'categories' => 'searchengines,socialnetworks'); 
						
	$wow->setParameters($parameters);
	$output = $wow->getOutput();
	
	foreach($output->sources as $nr => $source) {
		print $source->name.' (Results: '.$source->found.')<br />';
		if($source->found > 0) {
			foreach($source->results as $nr => $result) {
				// Please check the class WOW_View_Helper
				// Each source has a different output values
				print WOW_View_Helper::getInformation($result,$source->id);
				print '<br />';
			}
		}
		print '<br />';
	}
} catch (WOW_Exception $e) {
	print 'Error: #'.$e->getCode().' > '.$e->getMessage();
}

print '</pre><hr />';
?>