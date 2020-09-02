<?php


// Si l'utilisateur est déjà connecté, alors on le redigire sur l'index

if(isset($_SESSION['id']))
{
  header('Location: admin.php');
exit();
}
else
{

// Sinon il peut utiliser le formulaire

  if(isset($_POST['connexion']))
  {
    $email = htmlspecialchars($_POST['email']); // Ce qui sert pour le name="identifiant"
    $motdepasse = md5(sha1($_POST['motdepasse'])); // Ce qui sert pour le name="motdepasse"

    if(!empty($email) AND !empty($motdepasse))
    {

      $req = $bdd->prepare('SELECT * FROM membres WHERE email = ? AND motdepasse = ?');
      $req->execute(array($email, $motdepasse));
      $exist = $req->rowCount();

      if($exist == 1)
      {

        // On enregistre en cookie l'identifiant et le mot de passe

        if(isset($_POST['remember'])) {
                    setcookie('email',$email,time()+365*24*3600,null,null,false,true);
                    setcookie('motdepasse',$motdepasse,time()+365*24*3600,null,null,false,true);
                }

         // On ouvre les sessions

        $backup = $req->fetch();
        $_SESSION['id'] = $backup['id'];
        $_SESSION['nom'] = $backup['nom'];
        $_SESSION['prenom'] = $backup['prenom'];
        $_SESSION['motdepasse'] = $backup['motdepasse'];
        $_SESSION['avatar'] = $backup['avatar'];

        // On peut ici mettre ici -> $erreur = "Connexion réussi, redirection dans 3 secondes"; <- et modifier le header actuel par -> header("refresh:3;url=index"); <-

        header('Location: admin.php');
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