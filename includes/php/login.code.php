<?php


// Si l'utilisateur est déjà connecté, alors on le redigire sur l'index

if(isset($_SESSION['id']))
{
  header('Location: support.php');
exit();
}
else
{

// Sinon il peut utiliser le formulaire

  if(isset($_POST['connexion']))
  {
    $nom = htmlspecialchars($_POST['nom']); // Ce qui sert pour le name="identifiant"
    $prenom = htmlspecialchars($_POST['prenom']); // Ce qui sert pour le name="motdepasse"

    if(!empty($nom) AND !empty($prenom))
    {

      $req = $bdd->prepare('SELECT * FROM membres WHERE nom = ? AND prenom = ?');
      $req->execute(array($nom, $prenom));
      $exist = $req->rowCount();

      if($exist == 1)
      {

        // On enregistre en cookie l'identifiant et le mot de passe

        if(isset($_POST['remember'])) {
                    setcookie('nom',$nom,time()+365*24*3600,null,null,false,true);
                    setcookie('prenom',$prenom,time()+365*24*3600,null,null,false,true);
                }

         // On ouvre les sessions

        $backup = $req->fetch();
        $_SESSION['id'] = $backup['id'];
        $_SESSION['nom'] = $backup['nom'];
        $_SESSION['prenom'] = $backup['prenom'];

        // On peut ici mettre ici -> $erreur = "Connexion réussi, redirection dans 3 secondes"; <- et modifier le header actuel par -> header("refresh:3;url=index"); <-

        header('Location: support.php');
exit();

      }
      else
      {

        // Erreur si l'utilisateur ou le mot de passe est incorrect

        $erreur = "<div class=\"alert alert-danger\">
                            <strong>Erreur!</strong> Votre nom d'utilisateur ou mot de passe est incorrect.
                        </div>";

      }

    }
    else
    {

      // Erreur si tous les champs ne sont pas remplis, mais on peut utiliser un required dans notre code HTML mais il n'est pas prit en compte sur tous les navigateurs.

      $erreur = "<div class=\"alert alert-danger\">
                            <strong>Erreur!</strong> Tous les champs ne sont pas remplis!
                        </div>";

    }

  }

}

?>