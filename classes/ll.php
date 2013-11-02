<?php

class ll {
	static $logs = array();
	
	static function _($msg) {
		self::$logs[] = $msg;
	}
	static function get_ll_html() {
		$out = implode("<br/>", self::$logs);
		echo $out;
	}
	static function header_ll() {
		$out = implode(" | ", self::$logs);
		header("ll: ".$out);
	}
}
