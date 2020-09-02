<?php

try
{
    $hostname = "localhost"; //Hôte
    $dbname = "artemis"; //Base de données
    $user = "root"; // Utilisateur
    $password = ""; // Mot de passe

 
    $bdd = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', ''.$user.'', ''.$password.'', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

catch(Exception $e)
{
    die('<span style="color:red;"><b>Une erreur est survenue !</b></span> <br />'. $e->getMessage());
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
            $_SESSION['motdepasse'] = $info['motdepasse'];
            $_SESSION['email'] = $info['email'];
            $_SESSION['grade'] = $info['grade'];

        }
}

?>