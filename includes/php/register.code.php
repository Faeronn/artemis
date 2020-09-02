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

    if(isset($_POST['inscription']))
    {
        $nom = htmlspecialchars($_POST['nom']); // Ce qui sert pour le name="identifiant"
        $prenom = htmlspecialchars($_POST['prenom']); // Ce qui sert pour le name="email"        
        $problem = htmlspecialchars($_POST['problem']); // Ce qui sert pour le name="email"

        if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['problem'])) // Les champs qui seront obligatoire d'être remplis dans le formulaire
        {
                $req = $bdd->prepare("SELECT * FROM membres WHERE nom = ?");
                $req->execute(array($nom));
                $userexist = $req->rowCount();
                if($userexist == 0)
                {
                            $reqinsert = $bdd->prepare('INSERT INTO membres(nom, prenom, problem) VALUES(?, ?, ?)');
                            $reqinsert->execute(array($nom, $prenom, $problem));

                            // Si tout c'est bien passé, on affiche ce message
                            $erreur = "<div class=\"alert alert-success\">
                            <strong>Succès!</strong> Votre compte est maintenant créé.<br> Vous pouvez dès à présent vous connecter.
                        </div>";
                            header('Refresh: 1; login.php');
exit();
                }
                else
                {
                    // Si l'identifiant est déjà utilisé
                    $erreur = "<div class=\"alert alert-danger\">
                            <strong>Erreur!</strong> Ce identifiant est déjà utilisé.
                        </div>";
                }
        }
            // Si tous les champs ne sont pas remplis
            $erreur = "<div class=\"alert alert-danger\"><strong>Erreur!</strong> Tous les champs ne sont pas remplis.
                        </div>";
        }
    }