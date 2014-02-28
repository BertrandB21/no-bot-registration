<?php
if(file_exists('./params.php')) include './params.php';

if ( ! defined( 'NBR_SALT1' ) ) {
define('NBR_SALT1',       '50uYX(ygfi7-rv*C<3|JrijiYqO K/?HUt>B[1^n$%mw{QCWgzM-hZE%.b1JXlZ$');
	}
if ( ! defined( 'NBR_SALT2' ) ) {
define('NBR_SALT2',        'ijs%Rd60^t1x?]I*Yl;n(qpf|D+5f`3iBu7^V<p;@>`TnX#(&gdj+J8_|/Fby9W[');
}



function nbr_secretInput()
{
  return 'NBR_'.md5(NBR_SALT1.date('z').$_SERVER['REMOTE_ADDR']);
}

function nbr_secretCookie()
{
  return 'NBR_'.md5(NBR_SALT2.date('z').$_SERVER['REMOTE_ADDR']);
}

function nbr_secretMicrotime()
{
  $mt=strval(microtime(true));
  $key=substr(md5(NBR_SALT1.date('zD').$_SERVER['REMOTE_ADDR']),0,strlen($mt));
  return base64_encode($mt ^ $key);
} 

function nbr_microtimeDecrypt($mt)
{
  $mtd=base64_decode($mt);
  $key=substr(md5(NBR_SALT1.date('zD').$_SERVER['REMOTE_ADDR']),0,strlen($mtd));
  return floatval($mtd ^ $key);
}
