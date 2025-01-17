<?php
  session_start();
  require('connexionbd.php');
  $ids=$_SESSION['identifiant'];
  $message ="";
  if(isset($_POST['changePasse'])){
    $ancien = htmlentities(MD5($_POST['ancien']));
    $nouveau = htmlentities(MD5($_POST['nouveau']));
    $cnouveau = htmlentities(MD5($_POST['cnouveau']));

    $sql="SELECT * FROM `utilisateurs` WHERE `id_user`='$ids' AND `passeword`='$ancien'";
    $query=$con->query($sql);

    if(mysqli_num_rows($query)>0){

    if($nouveau==$cnouveau){
          $sql="UPDATE `utilisateurs` SET `passeword`=[value-4] WHERE `id_user`='$ids'";
          $query=$con->query($sql);
        if($query==true){
          $message ='
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          mots de passe modifeir avec succes!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
          ';
        }else{
          $message =' 
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-1"></i>
            le mots de passe n\'a pas été modifier!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    }else{
          $message ='
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-1"></i>
            les nouveaux mots de passes ne sont pas identique!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
          ';
      }

    }else{
         $message ='
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <i class="bi bi-exclamation-triangle me-1"></i>
         l\'ancien mot de passe est incorrect!
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         ';

   }
  }
  if(isset($_POST['save'])){
    $nom = htmlentities($_POST['nom']);
    $email = htmlentities($_POST['email']);
    $telephone = htmlentities(($_POST['telephone']));
    $poste = htmlentities($_POST['poste']);
    $sql ="UPDATE `utilisateurs` SET `nom`='$nom',`email`='$email',`poste`='$poste',`telephone`='$telephone' WHERE `id_user`='$ids'";
    $query=$con->query($sql);
    if($query==true){
     $message ='<div class="alert alert-success alert-dismissible fade show" role="alert">
     <i class="bi bi-check-circle me-1"></i>
     Profile modifier avec success!
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
    }else{
     $message ='<div class="alert alert-warning alert-dismissible fade show" role="alert">
     <i class="bi bi-exclamation-triangle me-1"></i>
     profile non modifier!
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil utilisateur</title>
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

  <?php require('header.php') ;?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Utilisateurs</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <?php
              $sql="SELECT * FROM `utilisateurs` WHERE `id_user`='$ids'";
              $query=$con->query($sql); 
              while($row=mysqli_fetch_assoc($query)):?>
              <h2><?=$row['nom']?></h2>
              <h3><?=$row['poste'];?></h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Informations</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le mots de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">
                <br> 
              <h5><?=$message?></h5>
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">A propos</h5>
                  <p class="small fst-italic">aucune obervation pour ce utilisateur.</p>

                  <h5 class="card-title">Details </h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom:</div>
                    <div class="col-lg-9 col-md-8"><?= $row['nom'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Adresse e-Mail:</div>
                    <div class="col-lg-9 col-md-8"><?= $row['email'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Telephone:</div>
                    <div class="col-lg-9 col-md-8"><?= $row['telephone'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Poste:</div>
                    <div class="col-lg-9 col-md-8"><?= $row['poste']?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date de creation:</div>
                    <div class="col-lg-9 col-md-8"><?= $row['date_cree'] ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="post" action="profile.php">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Image de profile</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/profile-img.jpg" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom & Prenom:</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nom" type="text" class="form-control" id="fullName" value="<?= $row['nom']?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Telephone:</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="telephone" type="text" class="form-control" id="company" value="<?= $row['telephone']?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Adresse E-mail:</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="text" class="form-control" id="Job" value="<?= $row['email']?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Poste:</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="poste" type="text" class="form-control" id="Job" value="<?= $row['poste']?>">
                      </div>
                    </div>
                    <?php endwhile ?>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="save">Enregistrer les modification</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="">Enregistrer les modifications</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="profile.php" method="post">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-5 col-form-label">Ancien mots de passe:</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="password" type="password" class="form-control" id="currentPassword" name="ancien">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-5 col-form-label">Nouveau mots passe:</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" name="nouveau">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-5 col-form-label">Confirmer le mots de passe:</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" name="cnouveau">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="changePasse">Changer</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>