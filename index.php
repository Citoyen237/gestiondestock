<?php
 session_start();
 $_SESSION['identifiant']="";
 $ids=$_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
   require('dashboard/connexionbd.php');
  $message="";
   if(isset($_POST['connexion'])){
     $login=htmlentities($_POST['login']);
     $password=htmlentities(MD5($_POST['password']));
     $sql="SELECT * FROM `utilisateurs` WHERE `email`='$login' AND `passeword`='$password' ";
     $query=$con->query($sql);
     if(mysqli_num_rows($query)!=0){
      while($row=mysqli_fetch_assoc($query)){
        $id_u=$row['id_user'];
        $_SESSION['identifiant']=$id_u;
        header('location:dashboard/dashord.php');
      }
     }else{
      $message='<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
       l\'e-mail ou le mot de passe est incorrect!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
     }
   }
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>authentification</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="dashboard/assets/img/logo.png" rel="icon">
  <link href="dashboard/assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="dashboard/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <img src="dashboard/assets/img/logo.PNG" alt="">
                  <span class="d-none d-lg-block">ELISH-TECH</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <?=$message?>
                  </div>
                  <form class="row g-3 needs-validation"  method="post" action="index.php" autocomplete="off">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email:</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-fill"></i></span>
                        <input type="mail" name="login" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">entrer votre email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Mot de passe:</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="password" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">entrer votre mot de passe.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="connexion">Connexion</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dashboard/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="dashboard/assets/vendor/echarts/echarts.min.js"></script>
  <script src="dashboard/assets/vendor/quill/quill.min.js"></script>
  <script src="dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="dashboard/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>