<?php
		$protocol = 'http';
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
		{
			$protocol = 'https';
		}
		define('URL', $protocol.'://'.$_SERVER['HTTP_HOST'].'/');
		define('SITE','sms/');
		define('DB_NAME','%db%');
		define('DB_PASS','%pass%');
		define('DB_HOST','%host%');
		define('DB_USER','%user%');
		define('ADMIN_EMAIL','%email%');

		define('INSTALL', '%install%');

		define('TIME_ZONE', '%timezone%');

		define('FROM_PERIOD', '%from_period%');
		define('TO_PERIOD', '%to_period%');