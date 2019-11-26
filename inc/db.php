<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=npProject', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        echo('Erreur : '.$e->getMessage());
}