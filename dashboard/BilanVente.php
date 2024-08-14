<?php
 session_start();
 $ids=$_SESSION['identifiant'];
 $_SESSION['idfac']="";


 if(isset($_POST['telecharger'])){
  $_SESSION['idfac']=$_POST['id'];
  header('location:facturepdfA.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<?php

   require("connexionbd.php");
   
   if(isset($_POST['modifier'])){
    $id_p=$_POST['id'];
    $_SESSION['id_p']=$id_p;
   header('location:Updateproduit.php'); 
   }
  
  //supprimer 
  $delete="";
  if(isset($_POST['supprimer'])){
    $idd=$_POST['id'];
    $idz=$_POST['idf'];
    $sql2="DELETE FROM `factures` WHERE `id_fac`='$idd'";
    $query2=$con->query($sql2);

    $sql22="DELETE FROM `ventes` WHERE `CodeFac`='$idz'";
    $query22=$con->query($sql22) or die($con->error);
    if($query2==true){
      $delete='
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      facture supprimer avec success
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
    }else{
      $delete='
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      facture non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
    }
    
  }
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bilan des ventes</title>
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

 <?php
   require('header.php');
 ?>

  </aside><!-- End Sidebar-->
 
  <main id="main" class="main">
  <div class="pagetitle">
      <h1>Ventes au comptoire</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Ventes</li>
          <li class="breadcrumb-item active">factures</li>
        </ol>
      </nav>
    </div>
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Valeur total
                <button>
                    <?php
                       $quer="SELECT * FROM `factures` WHERE `type`='vente'";
                       $exe=$con->query($quer) or die($con->error);
                       $totalachat =0;
                       while($row=mysqli_fetch_assoc($exe)){
                         $somme=$row['montant'];
                         $totalachat+=$somme;
                       }
                       $totalachatf=number_format($totalachat,'0','0','.');
                       echo $totalachatf;
                    ?>FCFA
                </button>
              </h5>
              <h5>
                <?= $delete?>
              </h5>
          <table class="table datatable">
              <thead>
                  <th>Date</th>
                  <th>N° Fac</th>
                  <th>Client</th>
                  <th>Prix (FCFA)</th>
                  <th>Action</th>
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
                         $sqq="SELECT * FROM `factures` WHERE `type`='vente' ORDER BY `date_fac` DESC ";
                       $re=$con->query($sqq);
                       //on recupere le nombre de user
                       $nbArticles =mysqli_num_rows($re);
                       //determination du nombre d'utilisateur par page
                       $parPage=10;
                       //on calcul le nombre de page tatal
                       $pages=ceil($nbArticles/$parPage);
                       //calcul de premier article de la page
                       $premier=($currentPage*$parPage)-$parPage;
                         $sql="SELECT * FROM `factures`WHERE `type`='vente' ORDER BY `date_fac` DESC limit $premier,$parPage";
                       $re=$con->query($sql);
                       if(mysqli_num_rows($re)!=0){
                        $i=1;
                       while($row=mysqli_fetch_assoc($re)){
                        $id=$row['id_fac'];
                        $numfac=$row['num_fac'];
                        $sql5="SELECT * FROM `ventes` WHERE `codeFac`='$numfac' ";
                        $quere=$con->query($sql5) or die($con->error);
                        while($rs=mysqli_fetch_assoc($quere)){
                          $cd=$rs['id_client'];
                          $sql01="SELECT * FROM `clients` WHERE `id_client`='$cd'";
                          $quer7=$con->query($sql01) or die($con->error);
                          while($rs1=mysqli_fetch_assoc($quer7)){
                            $nomd=$rs1['nom_client'];
                            $nomp=$rs1['prenom_client'];
                          }

                        }
                        $datefac=$row['date_fac'];
                        $montant=$row['montant'];
                        
                        $prix=number_format($montant,'0','0','.');
                        echo" <tr>        
                        <td>$datefac</td>
                        <td>V00$numfac</td>
                        <td>$nomd $nomp</td>
                        <td>$prix</td>
                        <td>
                        <form method='post' action='BilanVente.php'>
                        <button type='submit' class='btn btn-success' name='telecharger'><i class='bi bi-download'></i></button>
                        <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                        <input type='hidden' value='$numfac' name='id'> </form>
                        </td></tr>
                       
                       ";
                       $i++;
                       }
                       }else{
                       echo "<div class='alert alert-primary d-flex align-items-center' role='alert'>
                       <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg>
                       <div>
                       Aucun resultat trouve
                       </div>
                       </div>";
                       }
                       ?>
                       </tbody>
                       </table>
                       <nav aria-label="Page navigation example">
                       <ul class="pagination justify-content-center">
                       <li class="page-item <?php //if($currentPage==0){ echo 'active';} ?>">
                       <a href="?page=<?php echo $currentPage-1; ?>" class="page-link active">Precedent</a>
                       </li>
                       <?php
                       for($page=1 ; $page<= $pages; $page++): ?>
                       <li class="page-item <?php if($currentPage==$page){ echo 'active';}  ?>">
                       <a href="?page=<?php echo $page; ?>" class="page-link"><?php echo $page;?></a>
                       </li>
                       <?php endfor ?>
                       <li class="page-item <?php //if($currentPage==$pages){ echo 'active';} ?>">
                       <a href="?page=<?php if($currentPage<$pages){echo $currentPage+1;} ?>" class="page-link">Next</a>
                       </li>   
                       </ul>
                       </nav>
                       
             
          </div>
      </div>
  </div>
  <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Statistique des ventes sur un ans</h5>

              <!-- Line Chart -->
              <div id="lineChart"></div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    new ApexCharts(document.querySelector("#lineChart"), {
      series: [{
        name: "Desktops",
        data: [70, 41, 15, 51, 49, 90, 69, 91, 18]
      }],
      chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        },
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
      }
    }).render();
  });
</script>
<!-- End Line Chart -->

            </div>
          </div>
        </div>
  </main><!-- End #main -->

  <?php
    require('footer.php');
  ?>

</body>

</html>