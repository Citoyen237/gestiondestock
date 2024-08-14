<?php
require('connexionbd.php');
if(isset($_POST['enregistrer'])){
   $d1=htmlentities($_POST['montant']);
   $d2=htmlentities($_POST['motif']);
   $dat=date('Y-m-d');
   //numero de la facture
   $q="SELECT * FROM `factures` ORDER BY `id_fac` DESC LIMIT 1";
   $cof=$con->query($q) or die($con->error);

   while($cd=mysqli_fetch_assoc($cof)){
      $codefac=$cd['num_fac'];
      $codefac=$codefac+1;
   }
   $sql="INSERT INTO `depenses`(`id_d`, `motif`, `montant`, `date_d`, `codeFac`) VALUES (NULL,'$d2','$d1','$dat','$codefac')";
   $query=$con->query($sql) or die($con->error);
   
   $sql="INSERT INTO `factures`(`id_fac`, `num_fac`, `date_fac`, `montant`, `type`) VALUES (NULL,'$codefac','$dat','$d1','depense')";
   $query=$con->query($sql) or die($con->error);
   if($query==true){
    header('location:depense.php');
   }
}
