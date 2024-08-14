<?php
 session_start();
 $ids=$_SESSION['identifiant'];
 require('connexionbd.php');
 $delete="";
 if(isset($_POST['supprimer'])){
 $idd=$_POST['id'];
 $sql2="DELETE FROM `mainteances` WHERE `id_m`='$idd'";
 $query2=$con->query($sql2) or die($con->error);
 if($query2==true){
   $delete='
   <div class="alert alert-success alert-dismissible fade show" role="alert">
   <i class="bi bi-check-circle me-1"></i>
   supprimer avec success
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 </div>
 ';
 }else{
   $delete='
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <i class="bi bi-exclamation-triangle me-1"></i>
   non supprimer!
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 </div>
   ';
 }
}

if(isset($_POST['print'])){
  $_SESSION['idm'] = $_POST['id'];
  header('location:listemain.php');
}

if(isset($_POST['modifier'])){
  $_SESSION['idm7'] = $_POST['id'];
  header('location:editMain.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>maintances</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
 <?php require('header.php')?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Maintenance d'Appariels</h1>
      <?php
         require('connexionbd.php');
         $ids=$_SESSION['identifiant'];
     ?>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Maintenance</li>
          <li class="breadcrumb-item active">Liste</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
                <div class="card">
        <h5 class="card-title p-4">
            Revenue 
            <button>
                    <?php
                       $quer="SELECT * FROM `mainteances`";
                       $exe=$con->query($quer) or die($con->error);
                       $totalachat =0;
                       while($row=mysqli_fetch_assoc($exe)){
                         $somme=$row['prix'];
                         $totalachat+=$somme;
                       }
                       $totalachatf=number_format($totalachat,'0','0','.');
                       echo $totalachatf;
                    ?>FCFA
                </button>
            <a href="Newmaintance.php" class="btn btn-primary">Nouveau</a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="bi bi-printer-fill"></i></button>
        </h5>
    </div>
                <div class="card-body">
                  <h5 class="card-title">Appariels</h5>
                  <h5><?=$delete?></h5>
                  <table class="table  datatable">
                    <thead>
                      <tr>
                        <th scope="col">Date</S></th>
                        <th scope="col">Clients</th>
                        <th scope="col">Appariels</th>
                        <th scope="col">travail realiser</th>
                        <th scope="col">N°serie</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php

//deternation de la page
if(isset($_GET['page']) and !empty($_GET['page'])){
$currentPage=(int) strip_tags($_GET['page']);
}else{
$currentPage=1;
}
//determination du nombre d'utilisateur total
$sqq="SELECT * FROM `mainteances` ORDER BY `date` ASC ";
$re=$con->query($sqq);
//on recupere le nombre de user
$nbArticles =mysqli_num_rows($re);
//determination du nombre d'utilisateur par page
$parPage=10;
//on calcul le nombre de page tatal
$pages=ceil($nbArticles/$parPage);
//calcul de premier article de la page
$premier=($currentPage*$parPage)-$parPage;
  $sql="SELECT * FROM `mainteances` ORDER BY `date` ASC limit $premier,$parPage"; 
$re=$con->query($sql);
if(mysqli_num_rows($re)!=0){
  $i=1;
while($row=mysqli_fetch_assoc($re)){
                  $id=$row['id_m'];
                  $nom=$row['id_client'];
                  $equipement=$row['equipement'];
                  $taff=$row['taf_effectue'];
                  $statut=$row['satut'];
                  $date=$row['date'];
                  $prix=$row['prix'];
                  $serie=$row['num_serie'];

                  $q0="SELECT * FROM `clients` WHERE `id_client`='$nom'";
                  $a=$con->query($q0);
                  while($rr=mysqli_fetch_assoc($a)){
                     $nom_c=$rr['nom_client'];
                     $prenom=$rr['prenom_client'];
                  echo"
                    <tr>
                    <th scope='row'>$date</th>
                    <td>$nom_c $prenom</td>
                    <td>$equipement</td>
                    <td>$taff</td>
                    <td>$serie</td>
                    <td>$prix</td>
                    <td class='text-center'>
                    
                    <button type='submit' class='btn btn-success' name='print'><i class='bi bi-printer-fill'></i></button>
                    <button type='submit' name='modifier' class=' btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                    <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                    <input type='hidden' value='$id' name='id'></td>
                     </form>
                    </tr>
                    ";
                    $i++;
                  }
}
}else{
echo '  <div class="alert alert-info alert-dismissible fade show" role="alert">
<i class="bi bi-info-circle me-1"></i>
Aucun resultat!
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>


      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Specifations</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="Clients.php">
          <div class="mb-2">
            <label for="recipient-name" class="col-form-label">Travaux d'un trimestre:</label>
            <select name="" id="" class="form-select">
            <option value=""></option>
              <option value="">Janvier/Fevrier/Mars</option>
              <option value="">Avril/Mai/Juin</option>
              <option value="">Juillet/Aour/Septembre</option>
              <option value="">Octobre/Novembre/Decembre</option>
            </select>
          </div>
          <div class="mb-3">
            <a href="listem.php" class="btn btn-warning form-control">Imprimer</a>
          </div>
      </div>
      <div class="modal-footer">
      <a href="listem.php" class="btn btn-warning">Tous</a>
      </div>
    </div>
  </div>
</div>

    </section>

  </main><!-- End #main -->

 <?php
   require('footer.php');
 ?>
</body>

</html>