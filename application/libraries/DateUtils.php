<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dateutils
{
	
	function dateStr_to_mysql($str, $delimiter = '/', $debug = FALSE) {
		if(!empty($str)) {
			if($debug)
				var_dump($str);
			list($d, $m, $y) = explode($delimiter, $str);
			return sprintf("%s-%s-%s",$y,$m,$d);
		} else {
			return NULL;
		}
	}
	
}