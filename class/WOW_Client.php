<?php 
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * WOW_Client
 * 
 * With this class you can get XML/JSON data from the API of Centroid Media
 * Please check <http://api.centroidmedia.com/> for more information about this API.
 * 
 * @author Bas van Dorst <info@basvandorst.nl>
 * @version 0.1 
 * @package WOW_Library
 */

class WOW_Client {
	/**
	 * Public API key
	 *
	 * @var string
	 */
	private $public_key = '';
	
	/**
	 * Private API key
	 *
	 * @var string
	 */
	private	$private_key = '';
	
	/**
	 * MD5 sum of the private key and current time
	 *
	 * @var string
	 */
	private $api_sig = '';
	
	/**
	 * API-signature with the current time
	 *
	 * @var string
	 */
	private $signature = '';
	
	/**
	 * API-method to call
	 *
	 * @var string
	 */
	private $method = '';
	
	/**
	 * Format of the output
	 *
	 * @var string
	 */
	private $format = 'json';
	
	/**
	 * Return the API-output as raw PHP/JSON data?
	 *
	 * @var string
	 */
	private $raw_data = FALSE;
	
	/**
	 * Array for user defined parameters
	 *
	 * @var array
	 */
	private $parameters = array();
	
	/**
	 * URL for connecting with the API
	 *
	 * @var string
	 */
	private static $request_url = "http://persons.api.centroidmedia.com/"; 
	
	/**
	 * Constructor
	 *
	 * @param string $public Public API-key
	 * @param string $private Private API-key
	 */
	public function __construct($public,$private) {
		$this->public_key = $public;
		$this->private_key = $private;
	}
	
	
	/**
	 * Set the API method
	 *
	 * @param string $method
	 */
	public function setMethod($method) {
		$this->method = $method;
	}

	/**
	 * Generate an unique API signature
	 *
	 */
	public function generateAPIsignature() {
		$this->signature = microtime();
		$this->api_sig = md5($this->private_key.$this->signature);
	}
	
	/**
	 * Add the user defined parameters to an array. 
	 * And also pick the format(json/xml) out of this array
	 *
	 * @param array $param
	 */
	public function setParameters($param = array()) {
		$this->parameters = $param;
		if(isset($param['format'])) $this->format = $param['format'];
	}
	
	/**
	 * Raw JSON/XML data or PHP-formatted output
	 *
	 * @param bool $raw_data 
	 */
	public function setOutputAsRawData($raw_data) {
		$this->raw_data = $raw_data;
	}
	
	/**
	 * Build an URL for the API-call, with includes the right method
	 * and the user defined parameters
	 *
	 * @return string URL for the API-call
	 */
	public function getRequestUrl() {
		$param = array(	'api_key' => $this->public_key,
                        'api_sig' => urlencode($this->api_sig),
                        'signature' => $this->signature
                    );
                               
        $data = array_merge($param,$this->parameters);       
        $get_query = http_build_query($data);
        $url = self::$request_url.$this->method.'?'.$get_query;
        return $url;
    } 
    
    /**
     * Do an cURL-request to the server and get the response of the request. 
     * This method will also throw an exception if there is something wrong with cURL.
     *
     * @param string $url URL for the API-call
     * @return string result of the API-call
     */
    public function getContentFromURL($url) {

    	$ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL,$url);  
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
        
        $data_result = curl_exec($ch); 
        if(curl_errno($ch) > 0) {
            throw new WOW_Exception(curl_errno($ch),"CURL: ".curl_error($ch));
        } 
      	curl_close($ch); 
        return $data_result;
    }
    
    /**
     * Format JSON/XML data to PHP elements. XML = SimpleXMLElement, JSON = object
     * OR: Throw an exception if the API generates errors..!
     *
     * @param string $content
     * @return object
     */
    public function getFormattedOutput($content) {
   		if($this->format == "xml") {
    		$output = @simplexml_load_string($content);
  			if (isset($output->error)) { 
  				throw new WOW_Exception($output->error->errorcode,"API-XML: ".$output->error->errorstring);
  			}
    	} else {
    		$output = @json_decode($content);
  			if (isset($output->errorCode)) {
  				throw new WOW_Exception($output->errorCode,"API-JSON: ".$output->errorString);
  			}
  		}
  		return $output;
    }
    
    /**
     * 1. Generate an unique API-signature (Do this for each API-call)
     * 2. Build the URL-string, with the right method and user defined vars
     * 3. Do the server request with cURL
     * 4. Optional: format the raw XML/JSON data to PHP-elements..
     * 
     * @return object|string
     */
    public function getOutput() {
    	$this->generateAPIsignature();
    	$url = $this->getRequestUrl();
    	$content = $this->getContentFromURL($url);
    	
    	// Raw XML/JSON data?
    	if($this->raw_data !== TRUE) {
	    	$output = $this->getFormattedOutput($content);
    	} else {
    		$output = $content;
    	}
    	return $output;
    }
}	
?>