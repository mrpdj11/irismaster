<?php


/**
 * Database Name:
 * pcdsi_wms
 */




 if ($_SERVER['SERVER_ADDR'] == '194.163.32.64') { //HOSTINGER 194.163.32.64

	define('DB_HOST', 'localhost');          // Set database host
	define('DB_USER', 'u478425112_new_wms');   // Set database user
	define('DB_PASS', 'Newsys2022');         // Set database password
	define('DB_NAME', 'u478425112_new_wms'); // Set database name
} else {

	define('DB_HOST', 'localhost');          // Set database host
	define('DB_USER', 'root');               // Set database user
	define('DB_PASS', '');                   // Set database password
	define('DB_NAME', 'u478425112_new_wms');        // Set database name
}


