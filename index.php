<?php require("inc/header.php")?>
<h1>Hello World</h1>
<?php 
if(mail('kevin.ryckaert@yahoo.be', 'My Subject', 'message')){
echo "le message à été envoyé";
}else{
echo "le message n'a pas été envoyé et donc mail n'est pas installé";
}
?>
