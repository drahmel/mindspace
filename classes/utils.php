<?php

class utils {
	static function print_r($str) {
		echo '<pre>'.print_r($str,true).'</pre>';
	}

	// Alternative to standard get_request -- does typing and avoids the real_escape in the normal get_request which creates a database connection
	static function getRequest($varname,$defaultVal='',$varType='str',$mysqlEscape=false,$htmlDecode=false) {
		$outVal = $defaultVal;
		if(isset($_GET[$varname])) {
			$temp = $_GET[$varname];
		} elseif(isset($_POST[$varname])) {
			$temp = $_POST[$varname];
		} elseif(isset($_REQUEST[$varname])) {
			$temp = $_REQUEST[$varname];
		} else {
			return $outVal;
		}
		if($varType=='int') {
			$outVal = intval($temp);
		} elseif($varType=='float') {
			$outVal = floatval($temp);			
		} else {
			if($mysqlEscape) {
				$outVal = real_escape($temp);
			} else {
				$outVal = self::realEscape($temp);
			}
		}
		return $outVal;
	}
	static function redirect($url,$permanent=true) {
		if(isset($_REQUEST['showredirect']) && $_REQUEST['showredirect']) {
			echo "Redirecting to $url".NL; 
			debug_print_backtrace(); 
			echo ll::out();		
			die();
		}
		//session_write_close();    
		if (!substr_count($url, 'http')) {
			$url = "http://" . $_SERVER['HTTP_HOST'] . $url;
		}
		if(headers_sent()) {
			$errorType = 'REDIRECT_FAIL';
			//utilsreport::trigger_error("REDIRECT:$url from ".$_SERVER['REQUEST_URI'], $errorType);    
		}
		if($permanent) {
			header("HTTP/1.1 301 Moved Permanently");
		}
		header("Location: " . $url);
		die();
	}
	static function realEscape($value) {
		$return = '';
		for($i=0;$i<strlen($value);++$i) {
			$char = $value[$i];
			$ord = ord($char);
			if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
				$return .= $char;
			} elseif($char == "'") {
				$return .= "\\'";
			} else {
				$return .= '\\x' . dechex($ord);
			}
		}
		return $return;
	}

}
