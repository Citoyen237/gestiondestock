<?php
session_start();
$ids = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
require("connexionbd.php");
$message = "";
if (isset($_POST['enregistrer'])) {
  $categori = htmlentities($_POST['categorie']);
  $sql = "SELECT * FROM `categorie` WHERE `libelle`='$categori'";
  $query = $con->query($sql);
  if (mysqli_num_rows($query) == 0) {

    $sql1 = "INSERT INTO `categorie`(`id`, `libelle`) VALUES (NULL,'$categori')";
    $query = $con->query($sql1);
    if ($query == true) {
      $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            la categorie ajoute avec succes
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
      $message = '
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-1"></i>
          categorie non enregistrer!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
          ';
    }
  } else {
    $message = '
        <div class="alert alert-info alert-dismissible fade show" role="alert">
         <i class="bi bi-info-circle me-1"></i>
         cette categori existe déja
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        ';
  }
}

//supprimer 
$delete = "";
if (isset($_POST['supprimer'])) {
  $idd = $_POST['id'];
  $sql2 = "DELETE FROM `categorie` WHERE `id`='$idd'";
  $query2 = $con->query($sql2);
  if ($query2 == true) {
    $delete = '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      categorie supprimer avec success
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  } else {
    $delete = '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      categogiri non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
  }
}
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>categories</title>
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
      <h1>Categories</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Stocks</li>
          <li class="breadcrumb-item active">Categories</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Liste de categorie
                <a href="listeca.php" class="btn btn-warning"><i class="bi bi-printer-fill"></i></a>
              </h5>
              <h5><?= $delete ?></h5>
              <!-- Default Table -->
              <table class="datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Noms</th>
                    <th scope="col">Quantites</th>
                    <th scope="col">Valeur (FCFA)</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $valeur = 0;
                  $sql2 = "SELECT * FROM `categorie`";
                  $query2 = $con->query($sql2);
                  if (mysqli_num_rows($query2) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($query2)) {
                      $idc = $row['id'];
                      $libelle = $row['libelle'];
                      $sql3 = "SELECT `quandite`,`prix_vente` FROM `produits` WHERE `categorie_id`='$libelle'";
                      $query3 = $con->query($sql3);
                      $qdttotal = 0;
                      while ($rowz = mysqli_fetch_assoc($query3)) {
                        $qdttotal = $qdttotal + $rowz['quandite'];
                        $valeur = $valeur + $rowz['prix_vente'];
                      }
                      $valeur = $valeur * $qdttotal;
                      $valeur = number_format($valeur, '0', '0', '.');

                      echo "
                        <tr>
                        <th scope='row'>$i</th>
                        <td>$libelle</td>
                        <td>$qdttotal</td>
                        <td>$valeur</td>
                        <td class='text-center'>
                        <form method='post' action='categorie.php'>
                        <button type='submit' name='modifier' class=' btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                        <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                        <input type='hidden' value='$idc' name='id'></form>
                        </td>
                      </tr>
                        ";
                      $valeur = 0;
                      $i++;
                    }
                  } else {
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        aucune categorie
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
                  } ?>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter une categorie</h5>
              <p><?= $message ?></p>
              <form method="post" action="categorie.php">
                <input type="text" name="categorie" id="" class="form-control" placeholder="Nom de la categorie" required><br>
                <button type="submit" class="btn btn-primary form-control" name="enregistrer">Enregistrer</button>
              </form>
            </div>
          </div>
        </div>

      </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Vue d'ensembe</h5>

            <!-- Pie Chart -->
            <div id="pieChart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#pieChart"), {
                  series: [
                    <?php
                    $sql = "SELECT * FROM `categorie`";
                    $d = $con->query($sql) or die($con->error);
                    while ($rg = mysqli_fetch_assoc($d)) {
                      $libelle=$rg['libelle'];
                    $sql3 = "SELECT `quandite` FROM `produits` WHERE `categorie_id`='$libelle'";
                    $query3 = $con->query($sql3) ;
                    while ($rg = mysqli_fetch_assoc($query3)) {
                      $n = $rg['quandite'];
                    ?>
                      <?= $n ?>,
                    <?php } }?>
                  ],
                  chart: {
                    height: 350,
                    type: 'pie',
                    toolbar: {
                      show: true
                    }
                  },
                  labels: [
                    //  
                    // 'Cat 2', 
                    // 'Cat 3', 
                    // 'Cat 4', 
                    // 'Cat 5'
                    <?php
                    $sql = "SELECT * FROM `categorie`";
                    $d = $con->query($sql) or die($con->error);
                    while ($rg = mysqli_fetch_assoc($d)) {
                      $n = $rg['libelle'];
                    ?> '<?= $n ?>',
                    <?php } ?>

                  ]
                }).render();
              });
            </script>
            <!-- End Pie Chart -->
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