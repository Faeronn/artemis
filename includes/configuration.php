<?php

try
{
    $hostname = "localhost"; //Hôte
    $dbname = "artemis"; //Base de données
    $user = "root"; // Utilisateur
    $password = ""; // Mot de passe

    $bdd = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', ''.$user.'', ''.$password.'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} // Ne pas toucher

catch(Exception $e)
{
    die('<span style="color:red;"><b>Une erreur est survenue !</b></span> <br />'. $e->getMessage()); // Message d'erreur avec l'erreur rencontré, mettre juste die('Votre message d'erreur'); pour afficher simplement votre message d'erreur seul
}
if(isset($_SESSION['id']))
{
    $req = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $req->execute(array($_SESSION['id']));
    $info = $req->rowCount();
    if($info == 1)
        {
            $info = $req->fetch();
            $_SESSION['id'] = $info['id'];
            $_SESSION['nom'] = $info['nom'];
            $_SESSION['prenom'] = $info['prenom'];
            $_SESSION['rank'] = $info['rank'];

            $_SESSION['grade'] = $info['grade'];

        }
}
?>
