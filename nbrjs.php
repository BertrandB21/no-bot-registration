<?php
header('Content-type: application/javascript');
setcookie(pathinfo(__FILE__,PATHINFO_FILENAME),microtime(true),time()+900,'/');
include pathinfo(__FILE__,PATHINFO_DIRNAME).'/secretInput.php';
?>
function setInput(){
  if (document.forms.length > 0 )
  { 
   for (var i = 0 ;i <document.forms.length ; i++)
   { 
    theInput=document.createElement("input");
    theInput.type="hidden"; 
    theInput.name="<?php echo secretInput();?>";
    theInput.id="<?php echo secretInput();?>";
    theInput.value="<?php echo microtime(true); ?>";
    document.forms[i].appendChild(theInput);
   }
  }
}
setInput();
