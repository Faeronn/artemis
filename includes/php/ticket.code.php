<?php

session_start();

if(isset($_SESSION['id']))
    {

    }else
    {
        header('Location: login.php');
exit();
    }

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

if(isset($_POST['envoie'])){
    $pro = htmlspecialchars($_POST['pro']);
   $reqinsert = $bdd->prepare('INSERT INTO ticket(pro) VALUES(?)');
   $reqinsert->execute(array($pro));
}



?>
<form class="form-signin" action="" method="post">

  <img  class="center" src="https://static.wixstatic.com/media/d65658_8392220e97ad4011a32a878bcf1ba53b~mv2.png/v1/fill/w_418,h_63,al_c,q_85,usm_4.00_1.00_0.00/d65658_8392220e97ad4011a32a878bcf1ba53b~mv2.webp" >
  </br>
  <?php if(isset($erreur)) { ?>

<?php echo $erreur ?>
<?php } ?>
  <label  class="sr-only">Quel est votre problème ?</label>
  <input type="text" name="pro" class="form-control" placeholder="Quel est votre problème ?" required ></br>
  

  <button class="btn btn-lg btn-primary btn-block" name="envoie" type="submit">Créer mon Ticket</button>
  <hr>
  <a class="btn btn-lg btn-success btn-block" href="/login.php" >Reprendre mon ticket</a>
  <p class="mt-5 mb-3 text-muted">&copy; Artemis-rd - 2020</p>
  </form>
