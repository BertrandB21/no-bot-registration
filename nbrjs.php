<?php
header('Content-type: application/javascript');
include pathinfo(__FILE__,PATHINFO_DIRNAME).'/secretInput.php';
setcookie(nbr_secretCookie(),nbr_secretMicrotime(),time()+900,'/');
?>
function setInput(){
  if (document.forms.length > 0 )
  { 
   for (var i = 0 ;i <document.forms.length ; i++)
   { 
    theInput=document.createElement("input");
    theInput.type="hidden"; 
    theInput.name="<?php echo nbr_secretInput();?>";
    theInput.id="<?php echo nbr_secretInput();?>";
    theInput.value="<?php echo nbr_secretMicrotime(); ?>";
    document.forms[i].appendChild(theInput);
   }
  }
}
setInput();
