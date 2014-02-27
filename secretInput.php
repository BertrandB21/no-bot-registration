<?php


function secretInput()
{
  return 'NBR_'.md5('SaltALaCon'.date('z').$_SERVER['REMOTE_ADDR']);
}
