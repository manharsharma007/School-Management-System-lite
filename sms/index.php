<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
require_once 'protected/config/config.php';
$routes = array('errorHandler'=>array(
			// use 'site/error' action to display errors
			'action'=>'error/main',
		));

require_once "framework/index.php";