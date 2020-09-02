<?php


session_start();

require_once('includes/configuration.php');

if(isset($_GET['id_ticket']) AND !empty($_GET['id_ticket'])){
    $get_id = htmlspecialchars($_GET['id_ticket']);
  
    $tickets = $bdd->prepare('SELECT * FROM ticket WHERE id_ticket = ?');
    $tickets->execute(array($get_id));
    if($tickets->rowCount() == 1){
        $tickets = $tickets->fetch();
        $pro = $tickets['pro'];
        $id_user = $tickets['id_user'];
        $cat = $tickets['cat'];
        $id_unique = $tickets['id_unique'];
        $creation = $tickets['creation'];
        $etat = $tickets['etat'];
        $id_ticket = $tickets['id_ticket'];
        
    }else {
        die('Ce Ticket n\'existe pas ou plus !');
    }
  }else {
    die('Erreur');
  }
  


if(isset($_GET['id_ticket'])) {

  
    // update user in that row to level 1 in database
    $clos1 = $bdd->prepare("UPDATE ticket SET etat='1' WHERE id_ticket = $id_ticket");
    $clos1->execute();
    
    // echo success message and redirect
    echo '<p class="alert success"> Le ticket est désormais clos redirection vers le Panel!</p>';
    header('location:index.php');
    
    }
    
  