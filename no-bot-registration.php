<?php
/**
  * @package no-bot-registration
  * @version 0.1
**/ 
/*
Plugin Name: No Bot Registration
Version: 0.1
Plugin URI:  http://
Description: Try to block bot registration and other spam
Author: Bertrand Belguise
Author URI: http://bertrand.belguise.net/blog/
 */

define("LOGO","wordpress-logo_png"); //beware . became _ in cookie name

function nbr_check_cookie($errors, $sanitized_user_login, $user_email) {
     //$msg.="logo=".LOGO;
     //$msg.="\tCookies:".print_r($_COOKIE,true);
     //$msg.="\tCookie".$_COOKIE[LOGO];
     //$msg.="\tmicrotime:".microtime(true);
     //$msg.="\tIsset:".isset($_COOKIE[LOGO]);
     if(isset($_COOKIE[LOGO])) 
	     $mt=explode('=',$_COOKIE[LOGO])[1]/1000000;
     //$msg.="\tmt:".print_r(explode('=',$_COOKIE[LOGO]),true);
     //$msg.="\t delais:".microtime(true)-$mt;
    if(!isset($_COOKIE[LOGO]) or (microtime(true)-$mt> 600)) {
      $errors->add( 'nbr_error', __('<strong>ERROR</strong>: No direct access alowwed ','nbr_domain') );
      $msg.=date(DATE_RFC822);
      $msg.="\tIP:".$_SERVER['REMOTE_ADDR'];
      $whois=gethostbyaddr($_SERVER['REMOTE_ADDR']);
      $msg.="\tWhois:$whois";
      $msg.="\temail:".$user_email;
      $msg.="\n"; 
      file_put_contents(__DIR__.'/trace_rejet',$msg,FILE_APPEND);
    }
    return $errors;
}



function nbr_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'nbr_domain', false, $plugin_dir );
}




add_action('plugins_loaded', 'nbr_init');
add_filter('registration_errors', 'nbr_check_cookie', 10, 3);


	
    

		
		

