<?php
 session_start();
 $ids=$_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
   require('connexionbd.php');
   $id_p = $_SESSION['id_p'];
   $message="";
   if(isset($_POST['valider'])){
     $nom=htmlentities($_POST['nom']);
     $prixA=htmlentities($_POST['prixA']);
     $prixB=htmlentities($_POST['prixV']);
     $description=htmlentities($_POST['description']);
     $quandite=htmlentities($_POST['quandite']);
       $sql1="UPDATE `produits` SET `nom`='$nom',`prix_vente`='$prixA',
       `prix_achat`='$prixB',`description`='$description',`quandite`='$quandite' WHERE  `id_pro`='$id_p'";
       $query1=$con->query($sql1) or die('error');
       if($query1==true){
        header('location:produits.php');
       }else{
         $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
         <i class="bi bi-exclamation-triangle me-1"></i>
         produit non modifier!
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>';
       }
    }
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>modifier produit</title>
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
              <h5 class="card-title">Modifier le produit</h5>
              <?=$message?>
              <!-- Multi Columns Form -->
              <div class="col-md-12">
              <?php 
              $sql="SELECT * FROM `produits` WHERE `id_pro`='$id_p'";
              $re=$con->query($sql);
              while($row=mysqli_fetch_assoc($re)){
              $id=$row['id_pro'];
              $nom=$row['nom'];
              $prix_v=$row['prix_vente'];
              $prix_a=$row['prix_achat'];
              $description=$row['description'];
              $quandite=$row['quandite'];
              $categori=$row['categorie_id'];
             echo "<form class='row g-3' method='post' action='UpdateProduit.php' autocomplete='off'>
             <div class='col-md-12'>
               <label for='inputName5' class='form-label'>Nom:</label>
               <input type='text' class='form-control' id='inputName5' name='nom' required value='$nom'>
             </div>
             <div class='col-md-6'>
               <label for='inputEmail5' class='form-label'>Prix de d\'achat:</label>
               <input type='number' class='form-control' id='inputEmail5' name='prixA'  required value='$prix_v'>
             </div>
             <div class='col-md-6'>
               <label for='inputPassword5' class='form-label'>Prix de vente:</label>
               <input type='number' class='form-control' id='inputPassword5' name='prixV' value='$prix_a'>
             </div>
             <div class='col-12'>
               <label for='inputAddress5' class='form-label'>Description:</label>
               <textarea name='description' id='' cols='' rows='' class='form-control'>$description</textarea>
             </div>
             <div class='col-12'>
               <label for='inputAddress2' class='form-label'>Quandite:</label>
               <input type='number' class='form-control' id='inputAddress2' placeholder='' name='quandite'  required value='$quandite'>
             </div>";
              }
            ?>
                <div class='text-center'>
                  <button type='submit' class='btn btn-primary' name='valider'>Modifier</button>
                  <a href="produits.php" class='btn btn-secondary'>Annuler</a>
                </div>
              </form>
       

            </div>
          </div>

        </div>

       
    </section>
 
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require('footer.php');?>
</body>

</html>