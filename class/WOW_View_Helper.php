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
 * WOW_View_Helper
 * 
 * Because every source has a different type of output, this class will "help"
 * you parsing the output. For example in this file you can add tables, div's
 * to determine your own layout. Be creative ;-) For a good example, take a look
 * at www.wieowie.nl 
 * 
 * @author Bas van Dorst <info@basvandorst.nl>
 * @version 0.1
 * @package WOW_Library
 */

class WOW_View_Helper {
	
	/**
	 * Source object with different arguments
	 *
	 * @var object
	 */
	private static $obj;
	
	/**
	 * Dispatch every source object to the right function. 
	 * Example: for $source=hyves function getHyves will be called.
	 * This class does not support every source, so it can generate an exception, in 
	 * that case, please add your own function.
	 *
	 * @param object $obj
	 * @param string $source
	 * @return string|exception
	 */
	static public function getInformation($obj,$source) {
		self::$obj = $obj;
		// build function `getSource`
		$function = "get".ucfirst($source);
		// Check if the function exists, else throw exception
		if(is_callable(array(__CLASS__, $function))) {
			// call the function
			return call_user_func(array(__CLASS__, $function));
		} else {
			throw new WOW_Exception(99,'Source type '.$source.' is not supported yet. Please add the function "'.$function.'" in '.__CLASS__);
		}
	 }
	 
 	 /**
 	  * Hyves Helper
 	  *
 	  * @return string
 	  */
	static private function getHyves() {
		$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->friends.' friends';
	 	return $x;
	}
	 
	/**
	 * Twitter Helper
	 *
	 * @return string
	 */
	static private function getTwitter() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->location;
	 	return $x;
	}
	
	/**
	 * LinkedIn Helper
	 *
	 * @return string
	 */	
	static private function getLinkedIn() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->headline. ','. self::$obj->location;
	 	return $x;
	}
	
	/**
	 * Schoolbank Helper
	 *
	 * @return string
	 */	
	static private function getSchoolbank() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.' ('.self::$obj->birthyear.')</a><br />';
	 	foreach (self::$obj->schools as $school) {
	 		$x.= '<a href="'.$school->url.'" target="_blank">'.$school->name.' ('.$school->place.')</a><br />';
	 	}
	 	return $x;
	}
	
	/**
	 * Livespaces Helper
	 *
	 * @return string
	 */
	static private function getLivespaces() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->place. ','. self::$obj->age;
	 	return $x;
	}
	
	/**
	 * Facebook Helper
	 *
	 * @return string
	 */	
	static private function getFacebook() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	return $x;
	}
	
	/**
	 * MySpace Helper
	 *
	 * @return string
	 */	 
 	static private function getMyspace() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->place;
	 	return $x;
	}
	
	/**
	 * HI5 Helper
	 *
	 * @return string
	 */
	static private function getHi5() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	return $x;
	}
	
	/**
	 * Netlog Helper
	 *
	 * @return string
	 */
	static private function getNetlog() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->place;
	 	return $x;
	}
	
	/**
	 * Friendster Helper
	 *
	 * @return string
	 */
	static private function getFriendster() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->place;
	 	return $x;
	}
	
	/**
	 * Xing Helper
	 *
	 * @return string
	 */
	static private function getXing() {
	 	$x = '<img src="'.self::$obj->photo.'"><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->headline. ','. self::$obj->place;
	 	return $x;
	}
	
	/**
	 * ZoomInfo Helper
	 *
	 * @return string
	 */
	static private function getZoominfo() {
	 	$x = 'Please check WOW_Helper_Information, this type is not supported while developing';
	 	// print_r(self::$obj) to use what information you can use...
	 	return $x;
	 }
	 
	/**
	 * Google Helper
	 *
	 * @return string
	 */
	 static private function getGoogle() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	 }
	
	/**
	 * Yahoo Helper
	 *
	 * @return string
	 */
	 static private function getYahoo() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	}
	
	/**
	 * Bing Helper
	 *
	 * @return string
	 */
	static private function getBing() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	}
	
	/**
	 * Google news Helper
	 *
	 * @return string
	 */
	static private function getGooglenews() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	}
	
	/**
	 * Google blogs Helper
	 *
	 * @return string
	 */
	static private function getGoogleblogs() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	}
	
	/**
	 * Telefoongids Helper
	 *
	 * @return string
	 */
	static private function getDetelefoongids() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->name.'</a>, ';
	 	$x.= self::$obj->phonenumber. ','. self::$obj->street. ','. self::$obj->postalcode. ','. self::$obj->city;
	 	return $x;
	}
	
	/**
	 * Related Helper
	 *
	 * @return string
	 */
	static private function getRelated() {
		$x = 'Please check WOW_Helper_Information, this type is not supported while developing';
	 	// print_r(self::$obj) to use what information you can use...
	 	return $x;
	}
	
	/**
	 * Facts Helper
	 *
	 * @return string
	 */
	static private function getFacts() {
	 	$x = self::$obj->fact.'<br />';
		foreach (self::$obj->urls as $url) {
	 		$x.= '<a href="'.$url.'" target="_blank">'.$url.'</a><br />';
	 	}
	 	return $x;
	}
	
	/**
	 * Tags Helper
	 *
	 * @return string
	 */
	static private function getTags() {
	 	$x = self::$obj->tag.'<br />';
		foreach (self::$obj->urls as $url) {
	 		$x.= '<a href="'.$url.'" target="_blank">'.$url.'</a><br />';
	 	}
	 	return $x;
	}
	
	/**
	 * Phonenumber Helper
	 *
	 * @return string
	 */
	static private function getPhonenumbers() {
		// This return value is a little bit different, please print_r(self::$obj) to see the results...
	 	$x = '';
		foreach (self::$obj as $new_obj) {
	 		$x.= $new_obj->phonenumber.'<br />';
			foreach ($new_obj->urls as $url) {
		 		$x.= '<a href="'.$url.'" target="_blank">'.$url.'</a><br />';
		 	}
	 	}
	 	return $x;
	}
	
	/**
	 * E-mail addresses Helper
	 *
	 * @return string
	 */
	static private function getEmailaddresses() {
	 	$x = self::$obj->emailaddress.'<br />';
		foreach (self::$obj->urls as $url) {
	 		$x.= '<a href="'.$url.'" target="_blank">'.$url.'</a><br />';
	 	}
	 	return $x;
	}
	
	/**
	 * Docs Helper
	 *
	 * @return string
	 */
	static private function getDocs() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= self::$obj->info;
	 	return $x;
	}
	
	/**
	 * Images Helper
	 *
	 * @return string
	 */
	static private function getImages() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= '<a href="'.self::$obj->image_url.'" target="_blank"><img src="'.self::$obj->thumb.'"></a><br />';
	 	return $x;
	}
	
	/**
	 * TVblik Helper
	 *
	 * @return string
	 */
	static private function getTvblik() {
		$x = self::$obj->title.'<br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank"><img src="'.self::$obj->thumb.'"></a><br />';
		$x.= self::$obj->description.'<br />';
	 	return $x;
	}
	
	/**
	 * Flickr Helper
	 *
	 * @return string
	 */
	static private function getFlickr() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	$x.= '<a href="'.self::$obj->url.'" target="_blank"><img src="'.self::$obj->thumb.'"></a><br />';
	 	return $x;
	}
	
	/**
	 * Youtube Helper
	 *
	 * @return string
	 */
	static private function getYoutube() {
	 	$x = '<a href="'.self::$obj->url.'" target="_blank">'.self::$obj->title.'</a><br />';
	 	return $x;
	}
	
}