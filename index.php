<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

define('APP_PATH',''); //with trailing slash pls
define('WEB_DOMAIN','http://demo.kissmvc.com'); //with http:// and NO trailing slash pls
define('WEB_FOLDER','/kissmvc_simple/'); //with trailing slash pls
//define('WEB_FOLDER','/kissmvc_simple/index.php/'); //use this if you do not have mod_rewrite enabled
define('VIEW_PATH','views/'); //with trailing slash pls

require('kissmvc.php');

session_start();

$GLOBALS['sitename']='Mindspace CMS';

function myUrl($url='', $fullurl=false) {
  $s=$fullurl ? WEB_DOMAIN : '';
  $s.=WEB_FOLDER.$url;
  return $s;
}

$controller = new Controller(APP_PATH.'controllers/',WEB_FOLDER,'main','index');