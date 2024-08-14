<?php
 session_start();
 $ids=$_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
   require('connexionbd.php');
  $message="";
   if(isset($_POST['valider'])){
    $nom=htmlentities($_POST['nom']);
    $email=htmlentities($_POST['mail']);
    $telephone=htmlentities($_POST['telephone']);
    $poste=htmlentities($_POST['poste']);
    $password=htmlentities(MD5($_POST['password']));
    $cpassword=htmlentities(MD5($_POST['cpassword']));
/// var_dump($nom,$email,$password,$cpassword,$telephone);
    if($password==$cpassword){
    $sql="SELECT * FROM `utilisateurs` WHERE `telephone`='$telephone'";
    $query=$con->query($sql);
    if(mysqli_num_rows($query)==0){
      $sql1="INSERT INTO `utilisateurs`(`id_user`, `nom`, `email`, `passeword`, `poste`, `telephone`, `date_cree`) 
      VALUES (NULL,'$nom','$email','$password','$poste','$telephone',current_timestamp())";
      $query1=$con->query($sql1) or die('error');
      if($query1==true){
        $message='<div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        Compte creer avec success!<a href="gererutilisateur.php" class="btn btn-link">Retour</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }else{
        $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        Utilisateur non enregistrer!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
    }else{
      $message ='
      <div class="alert alert-info alert-dismissible fade show" role="alert">
      <i class="bi bi-info-circle me-1"></i>
      le compte existe déja!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

      ';
    }
    }else{
      $message='<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      Les mots de passes ne sont pas identique!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
   }
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ajouter un client</title>
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
              <h5 class="card-title">Creer un nouveau Utilisateur</h5>
              <?=$message?>
              <!-- Multi Columns Form -->
              <form class="row g-3" method="post" action="createUser.php" autocomplete="off">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Nom:</label>
                  <input type="text" class="form-control" id="inputName5" name="nom" required>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Email:</label>
                  <input type="mail" class="form-control" id="inputEmail5" name="mail"  required>
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">Mot de passe:</label>
                  <input type="password" class="form-control" id="inputPassword5" name="password"  required>
                </div>
                <div class="col-12">
                  <label for="inputAddress5" class="form-label">Confirmer le mot de passe:</label>
                  <input type="password" class="form-control" id="inputAddres5s" placeholder="" name="cpassword"  required>
                </div>
                <div class="col-12">
                  <label for="inputAddress2" class="form-label">Telephone:</label>
                  <input type="text" class="form-control" id="inputAddress2" placeholder="+237 xxx xxx xxx" name="telephone"  required>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                  <a href="gererutilisateur.php" class="btn btn-secondary">Annuler</a>
                </div>
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