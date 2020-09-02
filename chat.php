<?php

	if(isset($_POST['client']) && isset($_POST['session']) && isset($_POST['ticket_id'])) {
		try {
    		$hostname = "localhost"; //Hôte
    		$dbname = "artemis"; //Base de données
    		$user = "root"; // Utilisateur
    		$password = ""; // Mot de passe

    		$bdd = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', ''.$user.'', ''.$password.'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} // Ne pas toucher
		catch(Exception $e) {
    		die('<span style="color:red;"><b>Une erreur est survenue !</b></span> <br />'. $e->getMessage()); // Message d'erreur avec l'erreur rencontré, mettre juste die('Votre message d'erreur'); pour afficher simplement votre message d'erreur seul
		}
		
	  	$client = htmlspecialchars($_POST['client']);
	  	$client = nl2br($client);
	  
	  	$inserchat = $bdd->prepare('INSERT INTO chat(id_ticket, id_user, message) VALUES(?, ?, ?)');
	  	$inserchat->execute(array($_POST["ticket_id"], $_POST["session"], $client));
	}

?>