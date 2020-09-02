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
            $explication = $tickets['explication'];
            
        }else {
            die('Ce Ticket n\'existe pas ou plus !');
        }
    }else {
        die('Erreur');
    }

    if(isset($_POST['action']) AND !empty($_POST['action'])){
        $action = htmlspecialchars($_POST['action']);
        $insertask = $bdd->prepare('INSERT INTO tache(id_ticket, id_user, task) VALUES(?, ?, ?)');
        $insertask->execute(array($id_ticket, $_SESSION['id'], $action));
    }


    // if users hits a change level 1/2 button;
    if(isset($_POST['clos'])) {

      
      // update user in that row to level 1 in database
      $clos1 = $bdd->prepare("UPDATE ticket SET etat='2' WHERE id_ticket = $id_ticket");
      $clos1->execute();
      
      // echo success message and redirect
      echo '<p class="alert success"> Le ticket est désormais clos redirection vers le Panel!</p>';
      header('location:index.php');
      
      }
      

      // if users hits a change level 1/2 button;
    if(isset($_POST['ouvert'])) {

      
      // update user in that row to level 1 in database
      $clos1 = $bdd->prepare("UPDATE ticket SET etat='1' WHERE id_ticket = $id_ticket");
      $clos1->execute();
      
      // echo success message and redirect
      echo '<p class="alert success"> Le ticket est désormais clos redirection vers le Panel!</p>';
        $delai=1; 
        header('location:ticket.php?id_ticket='.$id_ticket);
      
      }

    if(isset($_GET['id'])){
        $delete_id = htmlspecialchars($_GET['id']);

        $delete = $bdd->prepare('DELETE FROM tache WHERE id = ?');
        $delete->execute(array($delete_id));
        header('location:ticket.php?id_ticket='.$id_ticket);
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
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="Enzo">

      <title>Artemis-rd | Looping</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
      
      <!-- Custom styles for this template-->
      <link href="css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body id="page-top">
    <script>
        setInterval('load_messages()', 500);
        function load_messages() {
            $('#messages1').load('load_messages.php?id_ticket=<?php echo $id_ticket; ?>');
        }

        $(function () {
            var frm = $('#contactForm1');
            frm.submit(function (ev) {

                ev.preventDefault();

                $.ajax({
                      url: "chat.php",
                      data: {
                        client: $("#client").val(),
                        session: $("#session").val(),
                        ticket_id: $("#id_ticket").val()
                      },
                      type: "post",
                      success: function (data) {
                          load_messages();
                          
                          window.setTimeout(function(){
                              var myDiv = document.getElementById("messages1");
                              window.scrollTo(0, myDiv.innerHeight);

                              alert("ok");
                          }, 600);
                      },
                      error: function (xhr, ajaxOptions, thrownError) {
                          alert("pas ok");
                      }
                });
                
            });
        });

      </script>
      <script>
    setInterval('load_action()', 500);
    function load_action() {
                                $('#action').load('load_action.php?id_ticket=<?php echo $id_ticket; ?>');
                            }

      </script>
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

              <!-- Sidebar Toggle (Topbar) -->
              <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
              </button>

              <!-- Topbar Search -->
              <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" placeholder="Recherche..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>

              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                  <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                  </a>
                  <!-- Dropdown - Messages -->
                  <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                      <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </li>

                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">3+</span>
                  </a>
                  <!-- Dropdown - Alerts -->
                  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                      Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="mr-3">
                        <div class="icon-circle bg-primary">
                          <i class="fas fa-file-alt text-white"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="mr-3">
                        <div class="icon-circle bg-success">
                          <i class="fas fa-donate text-white"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                      </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="mr-3">
                        <div class="icon-circle bg-warning">
                          <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                      </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                  </div>
                </li>

                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1">
                  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter">7</span>
                  </a>
                  <!-- Dropdown - Messages -->
                  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                      Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                        <div class="status-indicator bg-success"></div>
                      </div>
                      <div class="font-weight-bold">
                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                        <div class="status-indicator"></div>
                      </div>
                      <div>
                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                        <div class="small text-gray-500">Jae Chun · 1d</div>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                        <div class="status-indicator bg-warning"></div>
                      </div>
                      <div>
                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                        <div class="status-indicator bg-success"></div>
                      </div>
                      <div>
                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                      </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                  </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['grade'];?> | <?php echo $_SESSION['prenom'];?> <?php echo $_SESSION['nom'];?></span>
                    <img class="img-profile rounded-circle" src="https://static.wixstatic.com/media/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.png/v1/fill/w_191,h_191,al_c,q_85,usm_4.00_1.00_0.00/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.webp">
                  </a>
                  <!-- Dropdown - User Information -->
                  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                      Profile
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                      Settings
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                      Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Logout
                    </a>
                  </div>
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
              <div class="row">

              

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
                <div class="col-xl-6 col-lg-7">
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <??>
                      <style>
                      .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 0.5rem;
    }
                      </style>
                      
                      <div class="card-body">
                            <div class="list-group">
                              <a href="#" class="list-group-item list-group-item-action">
                              <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> <?= $pro ?></h5>
                                <small><?= $creation ?></small>
                              </div>
                              <small>
                              <?php
                      
    $langue = $etat;


    if ($langue == "1")
    {
        echo '<span class="badge badge-dark">Non-clos</span>';
    }
    elseif ($langue == "2")
    {
        echo '<span class="badge badge-success">Clos</span>';
    }
      
        ?>
                              <span class="badge badge-success"><?= $cat ?> <?= $_SESSION['id']; ?> <?= $id_ticket ?></span>
                              </small>
                          </a>
                        </div>
                    </div>   
                    </div>
                    <!-- Card Body -->
                    

                    <div id="test" style="max-height:400px; overflow-y:auto; ">
                    <div class="card-body ">
                    <div class="list-group" >
                    <div id="">
                    <ul class="list-unstyled">
      <li class="media alert alert-success">
        <img src="https://static.wixstatic.com/media/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.png/v1/fill/w_191,h_191,al_c,q_85,usm_4.00_1.00_0.00/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.webp" width="50px;"class="mr-3" alt="...">
        <div class="media-body">
        
          <h5 class="mt-0 mb-1">Bonjour je suis Looping,</h5>
           Comment puis-je vous aider ?
        </div>
      </li><hr>
      <li class="media alert alert-success">
        <div class="media-body ">
        
          <h5 class="mt-0 mb-1 ">Votre problème :</h5>
          <?= $explication ?>
        </div>
      </li>
    <div id="messages1" >
    <?php
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
    </div>
    </ul>
      </div>
      
    </div>
      
    </div>   



                        </div>
                        <div class="card-body">
                            <div class="list-group">
                              <li class="media alert alert-success">
        <img src="https://static.wixstatic.com/media/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.png/v1/fill/w_191,h_191,al_c,q_85,usm_4.00_1.00_0.00/d65658_4e5484e5997041a5a83860c36ad2bf16~mv2_d_1418_1417_s_2.webp" width="50px;"class="mr-3" alt="...">
        <div class="media-body">
        <form  id="contactForm1" method="post">
        <div class="input-group mb-3">
      <textarea type="text" class="form-control" placeholder="Chat en Direct avec le client" id="client" name="client" aria-label="Recipient's username" aria-describedby="button-addon2"></textarea>
      <input type="hidden" id="id_ticket" name="id_ticket" value="<?php echo $id_ticket?>">
      <input type="hidden" id="session" name="session" value="<?php echo $_SESSION['id']?>">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" h name="client1">Go</button>
      </div></div>
        </form>
          
        </div>
      </li>
                              <small>
                              <form method="POST">
                                <button type="button" class="btn btn-primary">Demande <b>TeamViewer</b> </button>
                                <button type="button" class="btn btn-info">Joindre un fichier</button>
                                <button type="button" class="btn btn-secondary">Présentation</button>
                                <?php
                      
    $langue = $etat;


    if ($langue == "1")
    {
        echo '<button type="submit" name="clos" class="btn btn-success">Cloturer le Ticket</button>';
    }
    elseif ($langue == "2")
    {
        echo '<button type="submit" name="ouvert" class="btn btn-danger">Ouvrir le Ticket</button>';
    }
      
        ?>
                                
                                </form>
                              </small>
                        </div>

     
                        
                  </div>
                </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                  <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      Action du Technicien
                    </div>
                    <!-- Card Body -->
                    
                    <div class="card-body">
                    <div id="action" >
                    <?php  $all_action = $bdd->query(' SELECT * FROM membres, tache WHERE id_ticket = "'.$id_ticket.'" AND tache.id_user = membres.id');
                      while ($action_tech = $all_action->fetch()) {
                      ?>
                      <style>
                      .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 0.5rem;
    }
                      </style>
                      
                      <div class="card-body">
                            <div class="list-group">
                              <a  class="list-group-item list-group-item-action">
                              
                              <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Action de <?php echo $action_tech['prenom']; ?> <?php echo $action_tech['nom']; ?> </h5>
                                <small><?php echo $action_tech['date_publication']; ?></small>
                              </div>
                              <p class="mb-1"><?= $action_tech['task']; ?></p>
                              <small>
                              
                              <button  type="submit" onclick="window.location.href='d.php?id=<?= $action_tech['id']; ?>&id_ticket=<?= $action_tech['id_ticket']; ?>';" data-dismiss="modal" aria-label="Close" class="btn btn-outline-dark">Suppression de l'action</button>
                              </small>
                          </a>
                        </div>
                        
                    </div>
                    
          <?php  
                    }
                    ?>  </div>       <form method="post" action="">
                                 <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Action du Technicien" name="action" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                    <select class="form-control">
                                <option value="0.05">5 min</option>
                                <option value="0.10">10 min</option>
                                <option value="0.15">15 min</option>
                                <option value="0.30">30 min</option>
                                <option value="0.45">45 min</option>
                                <option value="1.00">1 h</option>                            
                                <option value="1.30">1 h 30 min</option>
                                <option value="2.00">2 h</option>                            
                                <option value="2.30">2 h 30 min</option>
                                <option value="3.00">3 h</option>                            
                                <option value="3.30">3 h 30 min</option>
                                <option value="4.00">4 h</option>                            
                                <option value="4.30">4 h 30 min</option>
                                <option value="5.00">5 h</option>                            
                                <option value="5.30">5 h 30 min</option>
                                <option value="6.00">6 h</option>                            
                                <option value="6.30">6 h 30 min</option>
                                <option value="7.00">7 h</option>                            
                                <option value="7.30">7 h 30 min</option>
                                <option value="8.00">8 h</option>
                              </select>
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Go</button>
                                        
                                    </div>
                                </div> 
                                </form>
                        </div>
                        
                  </div>
                </div>
                

                <!-- Pie Chart -->
                
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
      <script>
    var x = document.getElementById('test');
    x.scrollTop = x.scrollHeight;
    </script>
    </body>

    </html>
