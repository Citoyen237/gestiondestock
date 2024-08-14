<?php
  require('connexionbd.php');
  if(isset($_POST['ajouter'])){
    $quandite=htmlentities($_POST['quandite']);
    $designation = htmlentities($_POST['designation']);
    $prixU = htmlentities($_POST['prixU']);
    $fournisseur = htmlentities($_POST['fournisseur']);
   
    $q="SELECT * FROM `commandea` WHERE `designation`='$designation' ";
    $b=$con->query($q) or die($con->error);
    if(mysqli_num_rows($b)==0){
    $sqlic="INSERT INTO `commandea`(`fournisseurs`, `designation`, `prixu`, `quandite`) 
    VALUES ('$fournisseur','$designation','$prixU','$quandite')";
    $queryic=$con->query($sqlic) or die($con->error);
    if($queryic==false){
      $message='
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      le produit n\'a pas été ajouter a la commande!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    else{
      header('location:NewAchat.php');
    }
    
  }else{
    header('location:NewAchat.php');
  }
 
 }
 if(isset($_POST['ajouterv'])){
  $quandite=htmlentities($_POST['quandite']);
  $designation = htmlentities($_POST['designation']);
  $prixU = htmlentities($_POST['prixU']);
  $fournisseur = htmlentities($_POST['fournisseur']);
  //verification si la quandite est disponible
  $vrquan="SELECT `quandite` FROM `produits` WHERE `id_pro`='$designation'";
  $cquery=$con->query($vrquan) or die($con->error);
  while($vr=mysqli_fetch_assoc($cquery)){
    $quan=$vr['quandite'];
  }
  if($quan > $quandite){
  $sqlic="INSERT INTO `commandea`(`fournisseurs`, `designation`, `prixu`, `quandite`) 
  VALUES ('$fournisseur','$designation','$prixU','$quandite')";
  $queryic=$con->query($sqlic) or die($con->error);
  if($queryic==false){
    $message='
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
    le produit n\'a pas été ajouter a la commande!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  else{
    header('location:NewVente.php');
  }
}else{
  echo "Quandite en stock est insufisante";
}

}

if(isset($_POST['valider1'])){
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

    //insertion dans la table vente
     while($v=mysqli_fetch_assoc($valqc)){
       $four=$v['fournisseurs'];
       $deg=$v['designation'];
       $prixu=$v['prixu'];
       $quan=$v['quandite'];
       $prixt=$quan*$prixu;
       $pit = $pit + $prixt;
    //modification de la quandite en sotck

      $updp="UPDATE `produits` SET `quandite`=quandite - '$quan' WHERE `id_pro`='$deg'";
      $uprq=$con->query($updp) or die($con->error);

    //insertion dans la table ventes
       $inc="INSERT INTO `ventes`(`id_v`, `id_client`, `id_pr`, `quantite_a`, `prix_u`, `prix_t`, `Codefac` ) 
       VALUES (NULL,'$four','$deg','$quan','$prixu','$pit', '$codefac')";
       $inq=$con->query($inc) or die($con->error);
     }
     $datefac=date("Y-m-d");
     //insertion dans la table facture
     $inf="INSERT INTO `factures`(`id_fac`, `num_fac`, `date_fac`, `montant`, `type`) 
     VALUES (NULL,'$codefac','$datefac','$pit','vente')";
     $infq=$con->query($inf) or die($con->error);

     //supprimer la commande
     $delc="DELETE FROM `commandea`";
     $deq=$con->query($delc) or die($con->error);
     header('location:BilanVente.php');
  }else{

  }
}

 ?>