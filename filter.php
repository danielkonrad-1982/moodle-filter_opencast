<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Plugin administration pages are defined here.
 *
 * @package     filter_opencast
 * @category    admin
 * @copyright   2017 TU Ilmenau - Daniel Konrad <daniel.konrad@tu-ilmenau.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 class filter_opencast extends moodle_text_filter {
	function callback($matches) {
		global $COURSE , $USER;
		 $baseurl = get_config('filter_opencast', 'baseurl');
		 $keyId = get_config('filter_opencast', 'keyId');
		 $Key = get_config('filter_opencast', 'Key');
        // Check if we ignore it.
		//$id ="demoKeyOne";
		//$key= "6EDB5EDDCF994B7432C371D7C274F";
		//$ip = $_SERVER['HTTP_CLIENT_IP']?$_SERVER['HTTP_CLIENT_IP']:($_SERVER['HTTP_X_FORWARDE‌​D_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);
		$url = utf8_encode($matches[1]);
		$url_encoded = json_encode($url);
		$policy =  "{\"Statement\":{\"Condition\":{\"DateLessThan\":". (time() + (2*60*60))*1000 ."},\"Resource\":" . $url_encoded ."}}";
		$raw_base64 = base64_encode($policy);
		$striped_base64 = str_replace("+","-",$raw_base64);
		$striped_base64 = str_replace("/","_",$raw_base64);
		$striped_base64 = str_replace("=","",$raw_base64);
		$signature = hash_hmac("sha256", utf8_encode($policy), utf8_encode($Key));
		//$return_url = $url. "?policy=" .$striped_base64 . "&keyId=" . $id . "&signature=" . $signature ; 
		
         return "<source src=\"" . $matches[1]. "?policy=" .$striped_base64 . "&keyId=" . $keyId . "&signature=" . $signature ."&couseid=" . $USER->id . "\">";
		 
        }

	 
      public function filter($text, array $options = array()) {
		 $baseurl = get_config('filter_opencast', 'baseurl');
		 $keyId = get_config('filter_opencast', 'keyId');
		 $Key = get_config('filter_opencast', 'Key');
		
		if (!is_string($text) or empty($text)) {
             //Non string data can not be filtered anyway.
            return $text;
        }
        //if (stripos($text, '</a>') === false) {
            // Performance shortcut - all regexes bellow end with the </a> tag,
            // if not present nothing can match.
        //    return $text;
        //}
       $newtext = preg_replace_callback($re = '~<source\s[^>]*src="([^"]*(?:' .
                $baseurl . ')[^"]*)"[^>]~is', array($this, 'callback'), $text);

        if (empty($newtext) or $newtext === $text) {
            // Error or not filtered.
            return $text;
        }
        return $newtext;
		  
    }
	
	

}
?>