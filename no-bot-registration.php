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

include plugin_dir_path( __FILE__ ).'secretInput.php';

//define("LOGO","wordpress-logo_png"); //beware . became _ in cookie name

function nbr_check_cookie($errors, $sanitized_user_login, $user_email) {
/*     if(isset($_COOKIE[LOGO])) 
	     $mt=explode('=',$_COOKIE[LOGO])[1]/1000000;
if(!isset($_COOKIE[LOGO]) or (microtime(true)-$mt> 600) or !nbr_sourceOK())*/
   if (!nbr_sourceOK())	
    {
      $errors->add( 'nbr_error', __('<strong>ERROR</strong>: No direct access allowed ','nbr_domain') );
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

function nbr_sourceOK(){
  $ok=false;
  file_put_contents(__DIR__.'/trace_rejet',sprintf("Cookie=%s Input=%s %s %s\n",$_COOKIE[nbr_secretCookie()],$_POST[nbr_secretInput()],nbr_secretCookie(),nbr_secretInput()),FILE_APPEND);
  if(isset($_COOKIE[nbr_secretCookie()]) and isset($_POST[nbr_secretInput()])) {
   $mtc=nbr_microtimeDecrypt($_COOKIE[nbr_secretCookie()]);
   $mtp=nbr_microtimeDecrypt($_POST[nbr_secretInput()]);
   $delaisC=abs(microtime(true)-$mtc);
   $delaisM=$mtp-$mtc;
   if($delaisM >0 and $delaisM <30 and $delaisC < 900) $ok=true;
  file_put_contents(__DIR__.'/trace_rejet',sprintf("Délais M=%f C=%f Cookie=%s Input=%s\n",$delaisM,$delaisC,$mtp,$mtc),FILE_APPEND);
  }
  return $ok;
}

function nbr_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'nbr_domain', false, $plugin_dir );
}

function nbr_load_script()
{
  echo '<script type="text/javascript" src ="'.plugin_dir_url(__FILE__).'nbrjs.php" ></script>';
}




add_action('plugins_loaded', 'nbr_init');
add_action('login_footer','nbr_load_script',100);
add_filter('registration_errors', 'nbr_check_cookie', 10, 3);
add_action('wp_footer', 'nbr_load_script', 100);
