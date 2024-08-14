<?php
session_start();
$ids = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>nouveau</title>
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
    $ida = $_SESSION['idm7'];
    ?>

    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mettre a jour</h5>
                <?php
require('connexionbd.php');

$message = "";
if (isset($_POST['ajouter'])) {
    $nomc = htmlentities($_POST['client']);
    $nom = htmlentities($_POST['nom']);
    $serie = htmlentities($_POST['serie']);
    $detail = htmlentities($_POST['detail']);
    $serie = htmlentities($_POST['serie']);
    $prix = htmlentities($_POST['prix']);

    //numero de la facture
   
    $sql1 = "UPDATE `mainteances` SET `equipement`='$nom',`num_serie`='$serie',`taf_effectue`='$detail',`prix`='$prix', `id_client`='$nomc' WHERE `id_m`='$ida'";
    $query1 = $con->query($sql1) or die($con->error);

    if ($query1 === true) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        appareil mis a jour avec success!<a href="maintenance.php" class="btn btn-link">Retour</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
        $message = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        produit non enregistrer!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
?>
                <?= $message ?>
                <!-- Multi Columns Form -->
                <form class="row g-3" method="post" action="editMain.php" autocomplete="off">
                    <div class="col-md-12">
                        <label for="inputName5" class="form-label">Nom du client:</label>
                        <select name="client" id="" class="form-select">
                            <option value=""></option>
                            <?php
                            $s22 = "SELECT * FROM `clients` ORDER BY nom_client ASC ";
                            $q7 = $con->query($s22);
                            while ($row = mysqli_fetch_assoc($q7)) {
                                $idp = $row['id_client'];
                                $nom = $row['nom_client'];
                                $prenom = $row['prenom_client'];
                                echo "<option value='$idp'>$nom $prenom</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    $ida = $_SESSION['idm7'];
                    $sqq9 = "SELECT * FROM `mainteances` where `id_m`='$ida' ";
                    $re9 = $con->query($sqq9);
                    while($row9 = mysqli_fetch_assoc($re9)):
                    ?>
                    <div class="col-md-6">
                        <label for="inputEmail5" class="form-label">Nom l'appariel:</label>
                        <input type="text" class="form-control" id="inputEmail5" name="nom" required value="<?=$row9['equipement']?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Numero de serie:</label>
                        <input type="text" class="form-control" id="inputPassword5" name="serie" required value="<?=$row9['num_serie']?>">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress5" class="form-label">Travail effectuer:</label>
                        <textarea name="detail" id="" cols="" rows="" class="form-control"><?=$row9['taf_effectue']?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Prix:</label>
                        <input type="number" class="form-control" id="inputAddress2" placeholder="" name="prix" required value="<?=$row9['prix']?>">
                    </div>

                    <?php endwhile ?>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="ajouter">Mettre a jour</button>
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
    <?php require('footer.php'); ?>
</body>

</html>