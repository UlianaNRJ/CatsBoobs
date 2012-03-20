<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
| 'sess_driver'				= session driver to use (cookie, database, native, cache)
| 'sess_cache_driver'		= driver to use for cache
| 'sess_cookie_name'		= the name you want for the cookie
| 'sess_expiration'			= the number of SECONDS you want the session to last.
|   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'sess_expire_on_close'	= Whether to cause the session to expire automatically
|   when the browser window is closed
| 'sess_encrypt_cookie'		= Whether to encrypt the cookie
| 'sess_use_database'		= Whether to save the session data to a database
| 'sess_table_name'			= The name of the session database table
| 'sess_match_ip'			= Whether to match the user's IP address when reading the session data
| 'sess_match_useragent'	= Whether to match the User Agent when reading the session data
| 'sess_time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_driver']			= 'database';
$config['sess_cache_driver']	= 'apc';
$config['sess_cookie_name']		= 'local_cb_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= true;
$config['sess_encrypt_cookie']	= true;
$config['sess_use_database']	= true;
$config['sess_table_name']		= 'system_session';
$config['sess_match_ip']		= false;
$config['sess_match_useragent']	= false;
$config['sess_time_to_update']	= 300;
