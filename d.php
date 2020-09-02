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
  
if(isset($_GET['id'])){
    $delete_id = htmlspecialchars($_GET['id']);
    
    $delete = $bdd->prepare('DELETE FROM tache WHERE id = ?');
    $delete->execute(array($delete_id));
    header('location:ticket.php?id_ticket='.$id_ticket);
}
?>