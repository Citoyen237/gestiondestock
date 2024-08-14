<?php
session_start();
$ids = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
require("connexionbd.php");
//supprimer 
$delete = "";
if (isset($_POST['supprimer'])) {
  $idd = $_POST['id'];
  $sql2 = "DELETE FROM `depenses` WHERE `id_d`='$idd'";
  $query2 = $con->query($sql2);
  if ($query2 == true) {
    $delete = '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      depense supprimer avec success
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  } else {
    $delete = '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      depense non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
  }
}
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>depenses</title>
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
      <h1>Depenses</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Depenses</li>
          <li class="breadcrumb-item active">Liste</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Liste de depenses
                <button>
                  <?php
                  $quer = "SELECT * FROM `depenses` ";
                  $exe = $con->query($quer) or die($con->error);
                  $totalachat = 0;
                  while ($row = mysqli_fetch_assoc($exe)) {
                    $somme = $row['montant'];
                    $totalachat += $somme;
                  }
                  $totalachatf = number_format($totalachat, '0', '0', '.');
                  echo $totalachatf;
                  ?>FCFA
                </button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="bi bi-printer-fill"></i></button>
              </h5>
              <?php if (date('d') <=2 and date('d') >= 28) : ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                      vous devenez payer les factures mensuelle!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php endif ?>
              <h5><?= $delete ?></h5>
              <!-- Default Table -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Motif</th>
                    <th scope="col">Montant (CFA)</th>
                    <th scope="col">Date</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql2 = "SELECT * FROM `depenses` ORDER BY `date_d` DESC ";
                  $query2 = $con->query($sql2);
                  if (mysqli_num_rows($query2) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($query2)) {
                      $idp = $row['id_d'];
                      $motif = $row['motif'];
                      $montant = $row['montant'];
                      $date = $row['date_d'];
                      $montantf = number_format($montant, '0', '0', '.');
                      echo "
                        <tr>
                        <th scope='row'>$i</th>
                        <td>$motif</td>
                        <td>$montantf</td>
                        <td>$date</td>
                        <td class='text-center'>
                        <form method='post' action='depense.php'>
                        <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                        <input type='hidden' value='$idp' name='id'></form>
                        </td>
                      </tr>
                        ";
                      $i++;
                    }
                  } else {
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        aucune depense
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
              <h5 class="card-title">Nouvelle Depenses</h5>
              <form method="post" action="depenses.php">
                <label for="montant" class="form-label">Montant:</label>
                <input type="number" name="montant" id="montant" class="form-control" placeholder="Montant" required>
                <label for="mtf" class="form-label">Motif:</label>
                <textarea name="motif" id="mtf" cols="" rows="" class="form-control" required></textarea><br>
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
            <h5 class="card-title">Statistique de depense par Mois</h5>

            <!-- Bar Chart -->
            <div id="lineChart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#lineChart"), {
                  series: [{
                    name: "Desktops",
                    data: [10, 41, 35, 51, 149, 62, 20, 91, 148]
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
                  <label for="recipient-name" class="col-form-label">Depenses d'un trimestre:</label>
                  <select name="" id="" class="form-select">
                    <option value=""></option>
                    <option value="">Janvier/Fevrier/Mars</option>
                    <option value="">Avril/Mai/Juin</option>
                    <option value="">Juillet/Aour/Septembre</option>
                    <option value="">Octobre/Novembre/Decembre</option>
                  </select>
                </div>
                <div class="mb-3">
                  <a href="listed.php" class="btn btn-warning form-control">Imprimer</a>
                </div>
            </div>
            <div class="modal-footer">
              <a href="listed.php" class="btn btn-warning">Tous</a>
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