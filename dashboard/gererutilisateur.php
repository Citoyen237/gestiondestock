<?php
 session_start();
 $ids=$_SESSION['identifiant'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
  require('connexionbd.php');
  
 $delete="";
  if(isset($_POST['modifier'])){
     $idd=$_POST['id'];
     $_SESSION['user_id1'] = $idd;
     header('loccation:editUser.php');
  }

  if(isset($_POST['supprimer'])){
    $idd=$_POST['id'];
    $sql2="DELETE FROM `utilisateurs` WHERE `id_user`='$idd'";
    $query2=$con->query($sql2);
    if(mysqli_num_rows($query2)!=0){
      $delete='
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      Utilisateur supprimer avec success
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
    }else{
      $delete='
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      Utilisateur non supprimer!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      ';
    }
    
  }

  if(isset($_POST['modifier'])){
    $_SESSION['user_editId'] = $_POST['id'];
     header('location:editUser.php');
  }
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Gerer utilisateurs</title>
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

<div class="pagetitle">
  <h1>Gestion des utilisateurs</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
      <li class="breadcrumb-item">Utilisateurs</li>
      <li class="breadcrumb-item active">Liste</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Utilisateurs
            <a href="createUser.php" class="btn btn-primary">Ajouter</a>
            <a href="listeu.php" class="btn btn-warning"><i class="bi bi-printer-fill"></i></a>
          </h5>
          <h5><?=$delete ?></h5>
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom, Prenom</th>
                <th scope="col">Email</th>
                <th scope="col">Telephone</th>
                <th scope="col">Poste</th>
                <th scope="col">Date</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php

//deternation de la page
if(isset($_GET['page']) and !empty($_GET['page'])){
$currentPage=(int) strip_tags($_GET['page']);
}else{
$currentPage=1;
}
//determination du nombre d'utilisateur total
$sqq="SELECT * FROM `utilisateurs`";
$re=$con->query($sqq);
//on recupere le nombre de user
$nbArticles =mysqli_num_rows($re);
//determination du nombre d'utilisateur par page
$parPage=10;
//on calcul le nombre de page tatal
$pages=ceil($nbArticles/$parPage);
//calcul de premier article de la page
$premier=($currentPage*$parPage)-$parPage;
  $sql="SELECT * FROM `utilisateurs`  limit $premier,$parPage"; 
$re=$con->query($sql);
if(mysqli_num_rows($re)!=0){
  $i=1;
while($row=mysqli_fetch_assoc($re)){
  $id=$row['id_user'];
                  $nom=$row['nom'];
                  $telephone=$row['telephone'];
                  $mail=$row['email'];
                  $poste=$row['poste'];
                  $date=$row['date_cree'];
                  echo"
                    <tr>
                    <th scope='row'>$i</th>
                    <td>$nom</td>
                    <td>$mail</td>
                    <td>$telephone</td>
                    <td>$poste</td>
                    <td>$date</td>
                    
                    
                    <td class='text-center'>
                    <form method='post' action='gererutilisateur.php'>
                    <button type='submit' name='modifier' class=' btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                    <button type='submit'  class=' btn btn-danger' name='supprimer'><i class='bi bi-trash-fill'></i></button>
                    <input type='hidden' value='$id' name='id'> </form></td>
                  </tr>
                    ";
                    $i++;
}
}else{
echo '  <div class="alert alert-info alert-dismissible fade show" role="alert">
<i class="bi bi-info-circle me-1"></i>
Aucun resultat!
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
</tbody>
</table>
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-center">
<li class="page-item <?php //if($currentPage==0){ echo 'active';} ?>">
<a href="?page=<?php echo $currentPage-1; ?>" class="page-link active">Precedent</a>
</li>
<?php
for($page=1 ; $page<= $pages; $page++): ?>
<li class="page-item <?php if($currentPage==$page){ echo 'active';}  ?>">
<a href="?page=<?php echo $page; ?>" class="page-link"><?php echo $page;?></a>
</li>
<?php endfor ?>
<li class="page-item <?php //if($currentPage==$pages){ echo 'active';} ?>">
<a href="?page=<?php if($currentPage<$pages){echo $currentPage+1;} ?>" class="page-link">Next</a>
</li>   
</ul>
</nav>
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>
</section>                  
</main>
 <?php require('footer.php')?>

</body>

</html>