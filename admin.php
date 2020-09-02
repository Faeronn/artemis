<?php

session_start();

require_once('includes/configuration.php');

  if(isset($_SESSION['id']))
      {
  
      }else
      {
          header('Location: login.php');
  exit();
      }
  
  if(isset($_POST['validation_ticket'])){
      $pro = htmlspecialchars($_POST['pro']);
      $cat = htmlspecialchars($_POST['cat']);
      $priorite = htmlspecialchars($_POST['priorite']);
      $explication = htmlspecialchars($_POST['explication']);
      $demandeur = htmlspecialchars($_POST['demandeur']);

     $reqinsert = $bdd->prepare('INSERT INTO ticket(pro, id_user, cat, priorite, explication, demandeur) VALUES(?, ?, ?, ?, ?, ?)');
     $reqinsert->execute(array($pro, $_SESSION['id'], $cat, $priorite, $explication, $demandeur));
  }

 if(isset($_POST['Validation_suivi'])){
   
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Artemis-rd | Looping</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="sidebar-brand-icon rotate-n-15">
          <img src="https://static.wixstatic.com/media/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.png/v1/fill/w_191,h_191,al_c,q_85,usm_4.00_1.00_0.00/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.webp" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">Artemis-rd <sup>Looping</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="admin.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tableau de Bord</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#registerticket">
        <i class="fas fa-ticket-alt"></i>
          <span>Création de Ticket</span></a>
      </li>

      <!-- The Modal -->
  <div class="modal" id="registerticket">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Enregistrement d'un ticket ✏️</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form class="form-signin" method="post">
      <input type="text" name="pro" id="inputEmail" class="form-control" placeholder="Problème" required autofocus>
      <hr>
      <textarea type="text" name="explication" id="inputPassword" class="form-control" placeholder="Explication" required></textarea>
      <hr>
        <div class="row">
          <div class="col">          
            <select name="cat" class="form-control">
              <option value="Bureautique">Bureautique</option>
                  <option value="Impression">Impression</option>
                  <option value="Reseaux">Reseaux</option>                  
                  <option value="Internet">Internet</option>
                  <option value="Logiciels métiers">Logiciels métiers</option>
                  <option value="Messagerie">Messagerie</option>
                  <option value="VPN">VPN</option>
                  <option value="Materiel">Materiel</option>
            </select>
          </div>
          <div class="col">          
            <select name="priorite" class="form-control">
            
              <option value="1">Mineur</option>
                  <option value="2">Critique</option>
                  <option value="3">Critique et Majeur</option>
                  
                  
            </select>
          </div>
        </div>
        </div>
          <div class="col">    
                
            <select  name="demandeur" class="form-control"><option>Demandeur</option><?php  $all_msg = $bdd->query(' SELECT * FROM entreprise ');
                  while ($msg = $all_msg->fetch()) {
                  ?>
              <option ><?= $msg['nom'] ?></option><?php } ?>
            </select>
          </div>
          <hr>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button class="btn btn-lg btn-success btn-block" type="submit" name="validation_ticket">Validation</button>
    </form>
        </div>
        
      </div>
    </div>
  </div>

  <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#registersuivi">
        <i class="fas fa-archive"></i>


          <span>Création de Suivi</span></a>
      </li>



      <!-- The Modal -->
  <div class="modal" id="registersuivi">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Enregistrement d'un suivi ✏️</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form class="form-signin" method="post">
      <label>Nom : <?php echo $_SESSION['nom'];?> Prenom : <?php echo $_SESSION['prenom'];?></label>
      <hr>
      <textarea type="text" id="inputPassword" class="form-control" placeholder="Desciption du suivi" required></textarea>
      <hr>
        </div>
          <div class="col">    
                
            <select  name="demandeur" class="form-control"><option>Chez ?</option><?php  $all_msg = $bdd->query(' SELECT * FROM entreprise ');
                  while ($msg = $all_msg->fetch()) {
                  ?>
              <option ><?= $msg['nom'] ?></option><?php } ?>
            </select><hr>
            <select class="form-control">
                            <option>De combien de temps ?</option>
                            <option value="4.00">4 h</option>
                            <option value="8.00">8 h</option>
                          </select>
          </div>
          <hr>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button class="btn btn-lg btn-success btn-block" name="Validation_suivi" type="submit">Validation du Suivi</button>
    </form>
        </div>
        
      </div>
    </div>
  </div>
      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="stats.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Statistiques</span></a>
      </li>
      


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['grade'];?> | <?php echo $_SESSION['prenom'];?> <?php echo $_SESSION['nom'];?></span>
                <img class="img-profile rounded-circle" src="https://static.wixstatic.com/media/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.png/v1/fill/w_191,h_191,al_c,q_85,usm_4.00_1.00_0.00/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.webp">
              </a>
              
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <?php
    $rssUrl="http://monitor.artemis-rd.fr:8080/api/gettreenodestats.xml?id=1&username=invite&password=Aqw12345";
    //====================================================
    $xml=simplexml_load_file($rssUrl) or die("Error: Cannot create object");
    //====================================================
    $featureRss =  array_slice(json_decode(json_encode((array) $xml ),  true ), 0 );
 
    function PrettyPrintArray($rssData, $level) {
    foreach($rssData as $key => $Items) {
    for($i = 0; $i < $level; $i++)
    echo("&nbsp;");
    /*if content more than one*/
    if(!is_array($Items)){
    //$Items=htmlentities($Items); 
    $Items=htmlspecialchars($Items);
    echo("Item " .$key . " => " . $Items . "<br/><br/>");
    }
    else 
    {
    echo($key . " => <br/><br/>");
    PrettyPrintArray($Items, $level+1);
    }
    }
    }
?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><div  id="timer"><body onload="horloge();"></div></h1>
            <a href="http://monitor.artemis-rd.fr:8080/" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"> Voir sur Monitor</a>
            <a href="https://serv1.netside-planning.com/" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"> NetSide Planning</a>
            <a href="http://185.50.52.133/artemis/glpi/front/ticket.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> GLPI - Artemis</a>
            
          </div>

          <!-- Content Row -->
          <div class="row" id="PRTG">

          

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Non Fonctionnel</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php echo($featureRss['downsens']); ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Avertissement</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php echo($featureRss['warnsens']); ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Disponible</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo($featureRss['upsens']); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Suspendu</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo($featureRss['pausedsens']); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Inhabituel</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo($featureRss['unusualsens']); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      
                      <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Capteurs</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($featureRss['totalsens']); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-align-justify fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
            
            <table class="table table-striped">
            
  <thead>
    <tr>
      <th scope="col">N°</th>
      <th scope="col">Problème</th>
      <th scope="col">Demandeur</th>
      <th scope="col">Priorité</th>
      <th scope="col">Catégorie</th>
      <th scope="col">Action</th>
      <th scope="col">Action du Technicien</th>
      <th scope="col">Date</th>
      <th scope="col">Etat</th>
      <th scope="col">/</th>
      
    </tr>
  </thead>
  <tbody>
  <?php  $all_msg = $bdd->query(' SELECT * FROM ticket Order by id_ticket DESC');
                  while ($msg = $all_msg->fetch()) {
                  ?>
    <tr>
      <th scope="row"><?php echo $msg['id_ticket']; ?></th>
      <td><?php echo $msg['pro']; ?></td>
      <td>
      <select  name="demandeur" class="form-control form-control-sm"><option>Chez ?</option>
              
              <?php  $all_msg2 = $bdd->query(' SELECT * FROM entreprise ');
                  while ($msg1 = $all_msg2->fetch()) {
                  ?>
              <option ><?= $msg1['nom'] ?></option><?php } ?>
              
            </select>
      </td>
      <td><select name="priorite" class="form-control form-control-sm">
      <option value="1">
      <?php
                   $test1 = $msg['priorite'];


if ($test1 == "1")
{
    ?>Mineur<?php
}
elseif ($test1 == "2")
{
    ?>Critique<?php
}elseif ($test1 == "3")
{
    ?>Critique et Majeur<?php
} ?>
      </option>
              <option value="1">Mineur</option>
                  <option value="2">Critique</option>
                  <option value="3">Critique et Majeur</option>
                  
                  
            </select></td>
      <td>
      
      <span class="badge badge-success"><?php echo $msg['cat']; ?></span></td>
      <td><form method="POST"><?php
                   $test = $msg['etat'];


if ($test == "1")
{
    ?><a type="submit" href="close_ticket.php?id_ticket=<?= $msg['id_ticket']; ?>" class="btn btn-success btn-sm">Cloturer le Ticket</a><?php
}
elseif ($test == "2")
{
    ?><a type="submit" href="open_ticket.php?id_ticket=<?= $msg['id_ticket']; ?>" class="btn btn-danger btn-sm">Ouvrir le Ticket</a><?php
}
  
    ?></form></td>
      <td>NP</td>
      <td><?php echo $msg['creation']; ?></td>
      <td><?php
                   $test = $msg['etat'];


if ($test == "1")
{
    ?><span class="badge badge-success">Non-clos</span><?php
}
elseif ($test == "2")
{
    ?><span class="badge badge-danger">Clos</span><?php
}
  
    ?></td>
                      <td><button type="submit" onclick="window.location.href='ticket.php?id_ticket=<?= $msg['id_ticket']; ?>';" class="btn btn-primary  btn-sm">Voir</button></td>
      
    </tr>
    <?php  
                }
                ?>  
  </tbody>
</table>       
              </div>
            </div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

  

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Artemis-rd 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>
<script>

function horloge()
{
	var tt = new Date().toLocaleTimeString(); // hh:mm:ss
 
	document.getElementById("timer").innerHTML = tt;
	setTimeout(horloge, 1000); // mise à jour du contenu "timer" toutes les secondes
}
</script>
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>
