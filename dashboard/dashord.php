<?php
session_start();
$ids = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tableau de bord</title>
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

  <!-- ======= Header ======= -->
  <?php require('header.php') ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <?php
      require('connexionbd.php');
      $ids = $_SESSION['identifiant'];
      ?>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <?php
            $t3 = 0;
            $s2 = "SELECT * FROM `factures` WHERE `type`='vente'";
            $q3 = $con->query($s2) or die($con->error);
            $nb2 = mysqli_num_rows($q3);
            while ($r2 = mysqli_fetch_assoc($q3)) {
              $ro2 = $r2['montant'];
              $t3 = $t3 + $ro2;
            }
            $t4 = number_format($t3, '0', '0', '.');
            ?>
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-3">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Ventes <button><?= $nb2 ?></button></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="BilanVente.php"><i class="bi bi-cart"></i></a>
                    </div>
                    <div class="ps-1">
                      <h6><?= $t4 ?>F</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-3">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <?php
                  $t1 = 0;
                  $s1 = "SELECT * FROM `factures` WHERE `type`='achat'";
                  $q2 = $con->query($s1) or die($con->error);
                  $nb1 = mysqli_num_rows($q2);
                  while ($r1 = mysqli_fetch_assoc($q2)) {
                    $ro = $r1['montant'];
                    $t1 = $t1 + $ro;
                  }
                  $t2 = number_format($t1, '0', '0', '.');
                  ?>
                  <h5 class="card-title">Achats <button><?= $nb1 ?></button></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="BilanAchat.php"><i class="bi bi-currency-dollar"></i></a>
                    </div>
                    <div class="ps-1">
                      <h6><?= $t2 ?>F</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-3">
              <?php
              $t33 = 0;
              $m1 = "SELECT * FROM `factures` WHERE `type`='maintenance'";
              $m3 = $con->query($m1) or die($con->error);
              $m52 = mysqli_num_rows($m3);
              while ($m4 = mysqli_fetch_assoc($m3)) {
                $m4 = $m4['montant'];
                $t33 = $t33 + $m4;
              }
              $t44 = number_format($t33, '0', '0', '.');
              ?>
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Maintenance <button><?= $m52 ?></button></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="maintenance.php"><i class="bi bi-gear-wide-connected"></i></a>
                    </div>
                    <div class="ps-3">
                      <h6><?= $t44 ?>F</h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            <div class="col-xxl-4 col-md-3">
              <?php
              $d3 = 0;
              $s22 = "SELECT * FROM `factures` WHERE `type`='depense'";
              $q33 = $con->query($s22) or die($con->error);
              $nb22 = mysqli_num_rows($q33);
              while ($r21 = mysqli_fetch_assoc($q33)) {
                $ro22 = $r21['montant'];
                $d3 = $d3 + $ro22;
              }
              $d4 = number_format($d3, '0', '0', '.');
              ?>
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Depenses
                    <button><?= $nb22 ?></button>
                  </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info">
                      <a href="Depense.php"><i class="bi bi-clipboard-minus text-secondary"></i></a>
                    </div>
                    <div class="ps-3">
                      <h6><?= $d4 ?>F</h6>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Line Chart -->
        <div class="container">
          <div class="card">
            <div id="columnChart"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#columnChart"), {
                  series: [{
                    name: 'Achat',
                    data: [320, 0, 0, 0, 0, 0, 0, 0, 0,0, 0, 0]
                  }, {
                    name: 'Vente',
                    data: [700, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                  }, {
                    name: 'Maintenance',
                    data: [250, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                  }, {
                    name: 'Depense',
                    data: [180, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                  }],
                  chart: {
                    type: 'bar',
                    height: 350
                  },
                  plotOptions: {
                    bar: {
                      horizontal: false,
                      columnWidth: '55%',
                      endingShape: 'rounded'
                    },
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                  },
                  xaxis: {
                    categories: ['jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'],
                  },
                  yaxis: {
                    title: {
                      text: '(mille) FCFA'
                    }
                  },
                  fill: {
                    opacity: 1
                  },
                  tooltip: {
                    y: {
                      formatter: function(val) {
                        return " FCFA" + val + " mille"
                      }
                    }
                  }
                }).render();
              });
            </script>
          </div>
        </div>

        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Operations recentes</h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">N° fac</th>
                    <th scope="col">Date</th>
                    <th scope="col">Cient/Motif/Fourniseur</th>
                    <th scope="col">Montant (FCFA)</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //deternation de la page
                  if (isset($_GET['page']) and !empty($_GET['page'])) {
                    $currentPage = (int) strip_tags($_GET['page']);
                  } else {
                    $currentPage = 1;
                  }
                  //determination du nombre d'utilisateur total
                  $sqq = "SELECT * FROM `factures`  ORDER BY `date_fac` DESC ";
                  $re = $con->query($sqq);
                  //on recupere le nombre de user
                  $nbArticles = mysqli_num_rows($re);
                  //determination du nombre d'utilisateur par page
                  $parPage = 10;
                  //on calcul le nombre de page tatal
                  $pages = ceil($nbArticles / $parPage);
                  //calcul de premier article de la page
                  $premier = ($currentPage * $parPage) - $parPage;
                  $nomd = "";
                  $sql = "SELECT * FROM `factures` ORDER BY `date_fac` DESC limit $premier,$parPage";
                  $re = $con->query($sql);
                  if (mysqli_num_rows($re) != 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($re)) {
                      $id = $row['id_fac'];
                      $numfac = $row['num_fac'];
                      $sql5 = "SELECT * FROM `achats` WHERE `codeFac`='$numfac' ";
                      $quere = $con->query($sql5) or die($con->error);
                      while ($rs = mysqli_fetch_assoc($quere)) {
                        $cd = $rs['id_fou'];
                        $sql01 = "SELECT * FROM `fournisseurs` WHERE `id_f`='$cd'";
                        $quer7 = $con->query($sql01) or die($con->error);
                        while ($rs1 = mysqli_fetch_assoc($quer7)) {
                          $nomd = $rs1['nom_f'];
                        }
                      }
                      $datefac = $row['date_fac'];
                      $type = $row['type'];
                      switch ($type) {
                        case "vente":
                          $sql5 = "SELECT * FROM `ventes` WHERE `codeFac`='$numfac' ";
                          $quere = $con->query($sql5) or die($con->error);
                          while ($rs = mysqli_fetch_assoc($quere)) {
                            $cd = $rs['id_client'];
                            $sql01 = "SELECT * FROM `clients` WHERE `id_client`='$cd'";
                            $quer7 = $con->query($sql01) or die($con->error);
                            while ($rs1 = mysqli_fetch_assoc($quer7)) {
                              $nomy = $rs1['nom_client'];
                              $nomp = $rs1['prenom_client'];
                              $nomd = $nomy . " " . $nomp;
                            }
                          }
                          $code = "V00";
                          $style = "bg-success";
                          break;
                        case "achat":
                          $sql5 = "SELECT * FROM `achats` WHERE `codeFac`='$numfac' ";
                          $quere = $con->query($sql5) or die($con->error);
                          while ($rs = mysqli_fetch_assoc($quere)) {
                            $cd = $rs['id_fou'];
                            $sql01 = "SELECT * FROM `fournisseurs` WHERE `id_f`='$cd'";
                            $quer7 = $con->query($sql01) or die($con->error);
                            while ($rs1 = mysqli_fetch_assoc($quer7)) {
                              $nomd = $rs1['nom_f'];
                            }
                          }
                          $code = "A00";
                          $style = "bg-dark";
                          break;
                        case "maintenance":
                          $sql5 = "SELECT * FROM `mainteances` WHERE `code`='$numfac' ";
                          $quere = $con->query($sql5) or die($con->error);
                          while ($rs = mysqli_fetch_assoc($quere)) {
                            $cd = $rs['id_client'];
                            $sql01 = "SELECT * FROM `clients` WHERE `id_client`='$cd'";
                            $quer7 = $con->query($sql01) or die($con->error);
                            while ($rs1 = mysqli_fetch_assoc($quer7)) {
                              $nomy = $rs1['nom_client'];
                              $nomp = $rs1['prenom_client'];
                              $nomd = $nomy . " " . $nomp;
                            }
                          }
                          $code = "M00";
                          $style = "bg-primary";
                          break;
                        case "depense":
                          $nomd = "";
                          $sql5 = "SELECT * FROM `depenses` WHERE `codeFac`='$numfac' ";
                          $quere = $con->query($sql5) or die($con->error);
                          while ($rs = mysqli_fetch_assoc($quere)) {
                            $nomd = $rs['motif'];
                          }
                          $code = "D00";
                          $style = "bg-info";
                          break;
                        default:
                          $nomd = "";
                      }
                      $montant = $row['montant'];
                      $montantf = number_format($montant, '0', '0', '.');
                      echo " <tr>
                        <th scope='row'><a href='#'>$code$numfac</th>
                        <td>$datefac</td>
                        <td><a href='#' class='text-primary'>$nomd</a></td>
                        <td>$montantf</td>
                        <td><span class='badge $style'>$type</span></td>
                        </tr>
                        <input type='hidden' value='$id' name='id'> </form>
                        </td></tr>
                       
                       ";
                      $i++;
                    }
                  } else {
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
                  <li class="page-item <?php //if($currentPage==0){ echo 'active';} 
                                        ?>">
                    <a href="?page=<?php echo $currentPage - 1; ?>" class="page-link active">Precedent</a>
                  </li>
                  <?php
                  for ($page = 1; $page <= $pages; $page++) : ?>
                    <li class="page-item <?php if ($currentPage == $page) {
                                            echo 'active';
                                          }  ?>">
                      <a href="?page=<?php echo $page; ?>" class="page-link"><?php echo $page; ?></a>
                    </li>
                  <?php endfor ?>
                  <li class="page-item <?php //if($currentPage==$pages){ echo 'active';} 
                                        ?>">
                    <a href="?page=<?php if ($currentPage < $pages) {
                                      echo $currentPage + 1;
                                    } ?>" class="page-link">Next</a>
                  </li>
                </ul>
              </nav>


            </div>
          </div>


        </div>

      </div>
      </div><!-- End Recent Sales -->

      </div>
      </div><!-- End News & Updates -->

      </div><!-- End Right side columns -->

      </div>
    </section>
    </div>
  </main><!-- End #main -->

  <?php
  require('footer.php');
  ?>
</body>

</html>