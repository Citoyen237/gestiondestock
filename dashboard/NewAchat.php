<?php
 session_start();
 $ids=$_SESSION['identifiant'];
 $prixTT=000;
?>
<!DOCTYPE html>
<html lang="en">
<?php
   require("connexionbd.php");
   $message="";
  //supprimer 
  $delete="";
  if(isset($_POST['supprimer'])){
    $idd=$_POST['idcs'];
    $sql2="DELETE FROM `commandea` WHERE `id`='$idd'";
    $query2=$con->query($sql2);
    if($query2==true){
    }else{
      $delete='
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      categogiri non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
    }
    
  }
 $codefac=0;
  if(isset($_POST['valider'])){
    $valc="SELECT * FROM commandea";
    $valqc=$con->query($valc) or die($con->error);
    if(mysqli_num_rows($valqc)!=0){
      $pit=0;

      //numero de la facture
      $q="SELECT * FROM `factures` ORDER BY `id_fac` DESC LIMIT 1";
      $cof=$con->query($q) or die($con->error);
      while($cd=mysqli_fetch_assoc($cof)){
         $codefac=$cd['num_fac'];
         $codefac=$codefac+1;
      }

      //insertion dans la table achat
       while($v=mysqli_fetch_assoc($valqc)){
         $four=$v['fournisseurs'];
         $deg=$v['designation'];
         $prixu=$v['prixu'];
         $quan=$v['quandite'];
         $prixt=$quan*$prixu;
         $pit = $pit + $prixt;
      //modification de la quandite en sotck

        $updp="UPDATE `produits` SET `quandite`=quandite + '$quan' WHERE `id_pro`='$deg'";
        $uprq=$con->query($updp) or die($con->error);

      //insertion dans la table achat
         $inc="INSERT INTO `achats`(`id_f`, `id_fou`, `id_pr`, `quandite_a`, `prix_a`, `prix_t`, `codeFac` ) 
         VALUES (NULL,'$four','$deg','$quan','$prixu','$pit', '$codefac')";
         $inq=$con->query($inc) or die($con->error);
       }
       $datefac=date("Y-m-d");
       //insertion dans la table facture
       $inf="INSERT INTO `factures`(`id_fac`, `num_fac`, `date_fac`, `montant`,  `type`) 
       VALUES (NULL,'$codefac','$datefac','$pit','achat')";
       $infq=$con->query($inf) or die($con->error);

       //supprimer la commande
       $delc="DELETE FROM `commandea`";
       $deq=$con->query($delc) or die($con->error);
       header('location:BilanAchat.php');
    }else{

    }
  }
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Achat</title>
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
      <h1>Bon d'achat</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Achats</li>
          <li class="breadcrumb-item active">Nouveau</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="card">
        <h5 class="card-title p-4">
            Total achat = 
            <button>  <?php
                   $sqlsc="SELECT * FROM commandea";
                   $querysc=$con->query($sqlsc);
                   while($rowsc=mysqli_fetch_assoc($querysc))
                   {
                    $prixt=($rowsc['prixu'])*($rowsc['quandite']);
                    $prixTT=$prixTT+$prixt;
                    }
                    echo $prixTT;
                 ?></button>FCFA
        </h5>
    </div>
    <div class="card">
            <div class="card-body">
              <form class="row g-3 p-4" method="post" action="adcom.php">
                <div class="col-md-3 ">
                  <label for="inputCity" class="form-label">Fournisseur:</label>
                  <select id="inputState" class="form-select" name="fournisseur">
                    <option></option>
                    <?php
                      $sqlf="SELECT * FROM fournisseurs";
                      $queryf=$con->query($sqlf);
                      while($rowf=mysqli_fetch_assoc($queryf)){
                         $idf=$rowf['id_f'];
                         $nomf=$rowf['nom_f'];
                         echo "
                          <option value='$idf'>$nomf</option>
                         ";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="inputState" class="form-label">Desigantion:</label>
                  <select id="inputState" class="form-select" name="designation">
                    <option></option>
                    <?php
                      $sqlp="SELECT * FROM produits";
                      $queryp=$con->query($sqlp);
                      while($rowp=mysqli_fetch_assoc($queryp)){
                         $idp=$rowp['id_pro'];
                         $nomp=$rowp['nom'];
                         $descriptionp=$rowp['description'];
                         $categorip=$rowp['categorie_id'];
                         echo "
                          <option value='$idp'>$categorip/$nomp/$descriptionp</option>
                         ";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <label for="inputZip" class="form-label">Prix_U:</label>
                  <input type="number" class="form-control" id="inputZip" required name="prixU">
                </div>
                <div class="col-md-2">
                  <label for="inputZip" class="form-label">Quantite:</label>
                  <input type="number" class="form-control" id="inputZip" required name="quandite">
                </div>
                <div class="col-md-1 p-2"> 
                <br>
                <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button></div>
              </form><!-- End Multi Columns Form -->
    <hr>
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Elements de la commande</h5>
              <!-- Active Table -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fournisseur</th>
                    <th scope="col">Desigantion</th>
                    <th scope="col">Quandite</th>
                    <th scope="col">Prix_U</th>
                    <th scope="col">Prix Total</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                   $sqlsc="SELECT * FROM commandea";
                   $querysc=$con->query($sqlsc);
                   $i=1;
                   while($rowsc=mysqli_fetch_assoc($querysc)):
                 ?>
                  <tr>
                    <td scope="row"><?= $i++?></td>
                    <td><?php  
                    $for= $rowsc['fournisseurs'];
                    $sqls="SELECT * FROM `fournisseurs` WHERE `id_f`='$for'";
                    $query=$con->query($sqls);
                    while($r=mysqli_fetch_assoc($query)){
                      echo $r['nom_f'];
                    }
                    ?></td>
                    <td><?php
                      $s=$rowsc['designation'];
                      $sq="SELECT * FROM `produits` WHERE `id_pro`='$s' ";
                      $q=$con->query($sq) or die('error');
                      while($r=mysqli_fetch_assoc($q)){
                        $s0=$r['id_pro'];
                        $s1= $r['nom'];
                        $s2= $r['description'];
                        $s3= $r['categorie_id'];
                       
                        echo "$s3/$s1/$s2";
                      }
                     ?></td>
                    <td><?= $rowsc['prixu']?></td>
                    <td><?= $rowsc['quandite']?></td>
                    <td>
                        <?php $prixt=($rowsc['prixu'])*($rowsc['quandite']);
                        echo $prixt;
                        $prixTT=$prixTT+$prixt;

                    ?></td>
                    <td><form action="NewAchat.php" method="post">
                        <button type="submit" class="btn btn-danger" name="supprimer"><i class='bi bi-trash-fill'></i></button></td>
                    <td><input type="hidden" name="idcs" value="<?=$rowsc['id']?>">
                    </form></td>
                  </tr>
                  <?php endwhile?>
                </tbody>
              </table>
              <!-- End Tables without borders -->
              <form action="NewAchat.php" method="post">
              <div class="">
                <button type="submit" class="btn btn-primary" name="valider">Valider l'achat</button>
              </div>
              </form>
              

    </section>

  </main><!-- End #main -->
  

  <?php
    require('footer.php');
  ?>

</body>

</html>