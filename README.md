People-Search-Engine-API-Client
===============================

```php
<?php
// include these files or use class autoloading (Zend 1.0 style)
include_once 'class/WOW_Client.php';
include_once 'class/WOW_Exception.php';
include_once 'class/WOW_View_Helper.php';

try {
    $client = new WOW_Client($public_key, $private_key);
    $client->setMethod('search');

    $parameters = array('format' => 'json',
        'lang' => 'nl',
        'country' => 'nl',
        'firstname' => 'Jan-Peter',
        'lastname' => 'Balkenende',
        'categories' => 'searchengines,socialnetworks'
    ); 

    $client->setParameters($parameters);
    $output = $client->getOutput();

    foreach($output->sources as $source) 
    {
        print $source->name.' (Results: '.$source->found.')<br />';
        if($source->found > 0) 
        {
            foreach($source->results as $result) 
            {
                // Please check the class WOW_View_Helper, 
                // Each source has a different output values
                print WOW_View_Helper::getInformation($result,$source->id);
            }
        }
    }
} catch (WOW_Exception $e) {
    print $e->getMessage();
}
```
