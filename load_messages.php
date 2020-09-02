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
      $creation = $tickets['creation'];
      $etat = $tickets['etat'];
      $id_ticket = $tickets['id_ticket'];
      
  }else {
      die('Ce Ticket n\'existe pas ou plus !');
  }
}else {
  die('Erreur');
}


function conversion($temps){
    $temps = strtotime($temps);
    $diff_temps = time() - $temps;
  
    if($diff_temps < 1){
        return 'à l\'instant';
    }
  
    $sec = array (
                12 * 30 * 24 * 60 * 60  =>  'an',
                30 * 24 * 60 * 60       =>  'mois',
                24 * 60 * 60            =>  'jour',
                60 * 60                 =>  'heure',
                60                      =>  'minute',
                1                       =>  'seconde'
    );
  
    foreach($sec as $sec => $value){
        $div = $diff_temps / $sec;
        if($div >= 1){
            $temps_conv = round($div);
            $temps_type = $value;
            if($temps_conv > 1 && $temps_type != "mois"){
                $temps_type .= "s" ;
            }
            return 'il y a ' . $temps_conv .' ' . $temps_type;
        }
    }

}

$all_chat = $bdd->query(' SELECT * FROM membres, chat WHERE id_ticket = "'.$id_ticket.'" AND chat.id_user = membres.id');
                  while ($chat_client = $all_chat->fetch()) {
  ?>
  <li class="media  alert alert-primary"  >
  
    <div class="media-body"  >
    
    
      <p class="text-justify"><?= $chat_client['message']; ?></p>
      <p class="text-right"><?= conversion($chat_client['date_publication1']); ?> - <?php echo $chat_client['prenom']; ?> <?php echo $chat_client['nom']; ?> - Technicien</p>
    </div>
    
  </li>
  <?php  
                }
                ?>  