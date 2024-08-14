<?php
session_start();
$ids = $_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php

require("connexionbd.php");

if (isset($_POST['modifier'])) {
  $id_p = $_POST['id'];
  $_SESSION['id_p'] = $id_p;
  header('location:Updateproduit.php');
}

if (isset($_POST['suivis'])) {
  $id_p = $_POST['id'];
  $_SESSION['id_p7'] = $id_p;
  header('location:listestock.php');
}

//supprimer 
$delete = "";
if (isset($_POST['supprimer'])) {
  $idd = $_POST['id'];
  $sql2 = "DELETE FROM `produits` WHERE `id_pro`='$idd'";
  $query2 = $con->query($sql2);
  if ($query2 == true) {
    $delete = '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      Produit supprimer avec success
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  } else {
    $delete = '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      produit non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
  }
}
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>produits</title>
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
      <h1>Stocks</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Stocks</li>
          <li class="breadcrumb-item active">Liste</li>
        </ol>
      </nav>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Produits en stocks
                <a href="createProduit.php" class="btn btn-primary">Ajouter</a>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="bi bi-printer-fill"></i></button>
              </h5>
              <?php
              $sqm = "SELECT * FROM `produits` WHERE `quandite` <5";
              $qs = $con->query($sqm) or die($con->error);
              $nm = mysqli_num_rows($qs);
              ?>
              <?php if ($nm > 0) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-exclamation-triangle me-1"></i>
                  <?= $nm ?> produit(s) en rupture de stock <a href="rupture.php">Consulter</a>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif ?>
              <h5>
                <?= $delete ?>
              </h5>
              <table class="table datatable scripe">
                <thead>
                  <th>#</th>
                  <th>Nom</th>
                  <th>Prix de vente</th>
                  <th>Prix d'achat</th>
                  <th>Quantite</th>
                  <th>Categorie</th>
                  <th>Description</th>
                  <th>Action</th>
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
                  $sqq = "SELECT * FROM `produits` ORDER BY `quandite` asc ";
                  $re = $con->query($sqq);
                  //on recupere le nombre de user
                  $nbArticles = mysqli_num_rows($re);
                  //determination du nombre d'utilisateur par page
                  $parPage = 10;
                  //on calcul le nombre de page tatal
                  $pages = ceil($nbArticles / $parPage);
                  //calcul de premier article de la page
                  $premier = ($currentPage * $parPage) - $parPage;
                  $sql = "SELECT * FROM `produits` ORDER BY `quandite` asc  limit $premier,$parPage";
                  $re = $con->query($sql);
                  if (mysqli_num_rows($re) != 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($re)) {
                      $id = $row['id_pro'];
                      $nom = $row['nom'];
                      $prix_v = $row['prix_vente'];
                      $prix_a = $row['prix_achat'];
                      $description = $row['description'];
                      $quandite = $row['quandite'];
                      if ($quandite < 7) {
                        $alert = "<button class='btn'>
                                         <div class='spinner-grow spinner-grow-md text-danger' role='status'>
                                          <span class='visually-hidden'>Loading...</span>
                                          </div>
                         </button>";
                      } 
                      else{
                       $alert ="";
                      }
                      $categori = $row['categorie_id'];
                      $date = $row['date_e'];
                      $quanditef = number_format($quandite, '0', '0', '.');
                      $prix_vf = number_format($prix_v, '0', '0', '.');
                      $prix_af = number_format($prix_a, '0', '0', '.');
                      echo " <tr>        
                        <td>$i $alert</td>
                        <td>$nom</td>
                        <td>$prix_vf</td>
                        <td>$prix_af</td>
                        <td>$quanditef</td>
                        <td>$categori</td>
                        <td>$description</td>
                        <td>
                        <form method='post' action='produits.php'>
                        <button type='submit' class='btn btn-info'  name='suivis' >suivis</button>
                        <button type='submit' name='modifier' class=' btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                        <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                        <input type='hidden' value='$id' name='id'> 
                        </form>
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
    </div>
  </main><!-- End #main -->

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
              <label for="inputState" class="form-label">Categorie:</label>
              <select id="inputState" class="form-select" name="designation">
                <option></option>
                <?php
                $sqlp = "SELECT * FROM categorie";
                $queryp = $con->query($sqlp);
                while ($rowp = mysqli_fetch_assoc($queryp)) {
                  $idp = $rowp['id_pro'];
                  $nomp = $rowp['nom'];
                  $descriptionp = $rowp['description'];
                  $categorip = $rowp['libelle'];
                  echo "
                          <option value='$idp'>$categorip</option>
                         ";
                }
                ?>
              </select>
              <label for="input" class="form-label">Quandite Min:</label>
              <input type="number" name="input" id="" class="form-control">
            </div>
            <div class="mb-3">
              <a href="liste.php" class="btn btn-warning form-control">Imprimer</a>
            </div>
        </div>
        <div class="modal-footer">
          <a href="liste.php" class="btn btn-warning">Tous</a>
        </div>
      </div>
    </div>
  </div>


  <?php
  require('footer.php');
  ?>

</body>

</html>