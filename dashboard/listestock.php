<?php
 session_start();
  require_once("connexionbd.php");
  require_once("fpdf/fpdf.php");

  class myPDF extends FPDF{
    function header(){
        $this->Image('logo.png',10,4);
        $this->SetX(57);
        $this->SetFont('Arial','B',30);
        $this->Cell(276,5,'ELISH-TECH',0,0,'J');
        $this->Ln(7);
        $this->SetX(57);
        $this->SetFont('Times','',14);
        $this->Cell(276,10,'Vente d\'accessoires informatique et maintenance',0,0,'J');
        $this->Ln();
        $this->SetX(57);
        $this->SetFont('Times','B',16);
        $this->Cell(276,10,'Adresse: Douala/Missoke',0,0,'J');
        $this->ln();
        $this->SetX(57);
        $this->SetFont('Times','B',16);
        $this->Cell(276,10,'Telephone: 691207395',0,0,'J');
        $this->Ln(20);
        $this->SetFont('Times','BU',25);
        $this->Cell(276,10,'Fiche de stock',0,0,'C');
        $this->Ln(15);
        $this->SetFont('Times','',17);
        $host="127.0.0.1";
$user="root";
$pass="";
$bd_name="higthtech";
try{
 $con=new mysqli($host,$user,$pass,$bd_name);
}catch(Exception $e){
    die("erreur:".$e->getMessage());
}
$ce=$_SESSION['id_p7'];
$sql="SELECT * FROM `produits` WHERE `id_pro`='$ce'";
$query=$con->query($sql) or die($con->error);
while($row=mysqli_fetch_assoc($query)){
  $quandite=$row['quandite'];
  $nom=$row['nom'];
  $id=$row['id_pro'];
  $this->Cell(130,10,'Reference : 1r01x'.$id,0,'L');
  $this->Cell(130,10,'Quandite en stock: '.$quandite,0,1,'R');
  $this->Cell(130,10,'Designation : '.$nom,0,0,'L');
  $this->Cell(130,10,'Stock de securite : 7',0,0,'R');
  $this->Ln(15);
}
        
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        $this->SetFont('Times','B',14);
        $this->SetFillColor(200,100,0);
        $this->Cell(61,10,'',0,'','TRUE');
        $this->Cell(73,10,'ENTREES',1,0,'C','TRUE');
        $this->Cell(63,10,'SORTIES',1,0,'C','TRUE');
        $this->Cell(63,10,'STOCKS',1,1,'C','TRUE');
        $this->Cell(21,10,'Date',1,0,'C','TRUE');
        $this->Cell(20,10,'Libelle',1,0,'C','TRUE');
        $this->Cell(20,10,'Num bon',1,0,'C','TRUE');
        $this->Cell(15,10,'Qdt',1,0,'C','TRUE');
        $this->Cell(23,10,'P.U.',1,0,'C','TRUE');
        $this->Cell(35,10,'Montant',1,0,'C','TRUE');
        $this->Cell(15,10,'Qdt',1,0,'C','TRUE');
        $this->Cell(23,10,'P.U.',1,0,'C','TRUE');
        $this->Cell(25,10,'Montant',1,0,'C','TRUE');
        $this->Cell(15,10,'Qdt',1,0,'C','TRUE');
        $this->Cell(23,10,'P.U.',1,0,'C','TRUE');
        $this->Cell(25,10,'Montant',1,0,'C','TRUE');
        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',12);
      $ce=$_SESSION['id_p7'];
      $sql="SELECT * FROM `factures` ORDER BY `date_fac` ASC";
      $query=$con->query($sql) or die($con->error);
      $qdtstock=0;
      $prixts=0;
      while($row=mysqli_fetch_assoc($query)){
        $numf=$row['num_fac'];
        $date=$row['date_fac'];
        $type=$row['type'];
        if($type="achat"){
            $s="SELECT * FROM `achats` WHERE `codeFac`='$numf' and `id_pr`='$ce'";
            $q=$con->query($s) or die($con->error);
            if(mysqli_num_rows($q)!=0){
                while($rws=mysqli_fetch_assoc($q)){
                    $libelle="achat";
                    $quandite=$rws['quandite_a'];
                    $prixu=$rws['prix_a'];
                    $prixu=number_format($prixu,'0','0','.');
                    $prixt=$rws['prix_t'];
                    $prixt=number_format($prixt,'0','0','.');
                    $qdtstock=$qdtstock+$quandite;
                    $prixts=$qdtstock*$prixu;
                    $prixts=number_format($rws['prix_t'],'0','0','.');
                    $this->Cell(21,10,$date,1,0,'C');
                    $this->Cell(20,10,$libelle,1,0,'C');
                    $this->Cell(20,10,'A00'.$numf,1,0,'C');
                    $this->Cell(15,10,$quandite,1,0,'C');
                    $this->Cell(23,10,$prixu,1,0,'C');
                    $this->Cell(35,10,$prixt,1,0,'C');
                    $this->Cell(15,10,'',1,0,'C');
                    $this->Cell(23,10,'',1,0,'C');
                    $this->Cell(25,10,'',1,0,'C');
                    $this->Cell(15,10,$qdtstock,1,0,'C');
                    $this->Cell(23,10,$prixu,1,0,'C');
                    $this->Cell(25,10,$prixts,1,0,'C');
                    $this->Ln();
                }
            }

        }
        if($type="vente"){
            $s="SELECT * FROM `ventes` WHERE `CodeFac`='$numf' and `id_pr`='$ce'";
            $q=$con->query($s) or die($con->error);
            if(mysqli_num_rows($q)!=0){
                while($rws=mysqli_fetch_assoc($q)){
                    $libelle="vente";
                    $quandite=$rws['quantite_a'];
                    $prixu=$rws['prix_u'];
                    $prixu=number_format($prixu,'0','0','.');
                    $prixt=$rws['prix_t'];
                    $prixt=number_format($prixt,'0','0','.');
                    $qdtstock=$qdtstock-$quandite;
                    $prixts=$qdtstock*$prixu;
                    $prixts=number_format($rws['prix_t'],'0','0','.');
                    $this->Cell(21,10,$date,1,0,'C');
                    $this->Cell(20,10,$libelle,1,0,'C');
                    $this->Cell(20,10,'V00'.$numf,1,0,'C');
                    $this->Cell(15,10,'',1,0,'C');
                    $this->Cell(23,10,'',1,0,'C');
                    $this->Cell(35,10,'',1,0,'C');
                    $this->Cell(15,10,$quandite,1,0,'C');
                    $this->Cell(23,10,$prixu,1,0,'C');
                    $this->Cell(25,10,$prixt,1,0,'C');
                    $this->Cell(15,10,$qdtstock,1,0,'C');
                    $this->Cell(23,10,$prixu,1,0,'C');
                    $this->Cell(25,10,$prixts,1,0,'C');
                    $this->Ln();
                }
            }

        }
       
         
      }
    }
  }
 
  $pdf=new myPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage('L','A4',0);
  $pdf->headerTable();
  $pdf->viewTable($con);
  $pdf->Output();
?>