<?php
 session_start();
 $ids=$_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
   require('connexionbd.php');
  
  $message="";
  if(isset($_POST['ajouter'])){
    $nomc=htmlentities($_POST['client']);
    $nom=htmlentities($_POST['nom']);
    $serie=htmlentities($_POST['serie']);
    $detail=htmlentities($_POST['detail']);
    $serie=htmlentities($_POST['serie']);
    $prix=htmlentities($_POST['prix']);
    $date =date("Y-m-d");

           //numero de la facture
   $q="SELECT * FROM `factures` ORDER BY `id_fac` DESC LIMIT 1";
   $cof=$con->query($q) or die($con->error);
        while($cd=mysqli_fetch_assoc($cof)){
          $codefac=$cd['num_fac'];
          $codefac=$codefac+1;
       } 
    $sql1="INSERT INTO `mainteances`(`id_m`, `equipement`, `num_serie`, `taf_effectue`, `satut`, `prix`, `date`, `id_client`, `code`) 
    VALUES (NULL,'$nom','$serie','$detail','','$prix','$date','$nomc','$codefac')";
    $query1=$con->query($sql1) or die($con->error);
   
      if($query1==true){
    
       $sql="INSERT INTO `factures`(`id_fac`, `num_fac`, `date_fac`, `montant`, `type`) VALUES (NULL,'$codefac','$date','$prix','maintenance')";
       $query=$con->query($sql) or die($con->error);
        $message='<div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        appareil enregistrer avec success!<a href="maintenance.php" class="btn btn-link">Retour</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }else{
        $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        produit non enregistrer!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
   }
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>update</title>
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

  <main id="main" class="main">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifier un appariel pour Maintenance</h5>
              <?=$message?>
              <!-- Multi Columns Form -->
              <form class="row g-3" method="post" action="Newmaintance.php" autocomplete="off">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Nom du client:</label>
                  <select name="client" id="" class="form-select">
                    <option value=""></option>
                     <?php
                       $s22="SELECT * FROM `clients` ";
                       $q7=$con->query($s22);
                       while($row=mysqli_fetch_assoc($q7)){
                        $idp=$row['id_client'];
                        $nom=$row['nom_client'];
                        $prenom=$row['prenom_client'];
                        echo "<option value='$idp'>$nom $prenom</option>";
                       }
                     ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Nom l'appariel:</label>
                  <input type="text" class="form-control" id="inputEmail5" name="nom"  required>
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">Numero de serie:</label>
                  <input type="text" class="form-control" id="inputPassword5" name="serie">
                </div>
                <div class="col-12">
                  <label for="inputAddress5" class="form-label">Travaille effectuer:</label>
                  <textarea name="detail" id="" cols="" rows="" class="form-control"></textarea>
                </div>
                <div class="col-12">
                  <label for="inputAddress2" class="form-label">Prix:</label>
                  <input type="number" class="form-control" id="inputAddress2" placeholder="" name="prix"  required>
                </div>
               
                  </select>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
                  <a href="maintenance.php" class="btn btn-secondary">Annuler</a>
                </div>
                <br>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>

       
    </section>
 
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require('footer.php');?>
</body>

</html>