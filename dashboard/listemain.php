<?php
  require_once("connexionbd.php");
  require_once("fpdf/fpdf.php");

  class myPDF extends FPDF{
    function header(){
        $this->Image('logo.png',10,4);
        $this->SetX(57);
        $this->SetFont('Arial','B',30);
        $this->Cell(276,5,'Higt Tech',0,0,'J');
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
        $this->SetFont('Times','B',30);
        $this->Cell(276,10,'Appareils travailler',0,0,'C');
        $this->Ln();
        $host="127.0.0.1";
        $user="root";
        $pass="";
        $bd_name="higthtech";
        try{
        $con=new mysqli($host,$user,$pass,$bd_name);
        }catch(Exception $e){
        die("erreur:".$e->getMessage());
        }
        $quer="SELECT * FROM `mainteances`";
        $exe=$con->query($quer) or die($con->error);
        $totalachat =0;
        while($row=mysqli_fetch_assoc($exe)){
             $somme=$row['prix'];
             $totalachat+=$somme;
        }
            $totalachatf=number_format($totalachat,'0','0','.');
        $this->SetFont('Arial','B',17);
        $this->Cell(276,10,'Montant Total: '.$totalachatf.'FCFA',0,0,'C');
        $this->Ln(15);
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        $this->SetFont('Times','B',14);
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(30,10,'Dates',1,0,'C');
        $this->Cell(50,10,'Noms du client',1,0,'C');
        $this->Cell(50,10,'Nom appareil',1,0,'C');
        $this->Cell(30,10,'Num serie',1,0,'C');
        $this->Cell(60,10,'Travaux',1,0,'C');
        $this->Cell(30,10,'Prix(FCFA)',1,0,'C');
        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',12);
      $sql="SELECT * FROM `mainteances` ORDER BY `date` "; 
      $re=$con->query($sql);
        $i=1;
      while($row=mysqli_fetch_assoc($re)){
         $id=$row['id_m'];
         $nom=$row['id_client'];
         $equipement=$row['equipement'];
         $taff=$row['taf_effectue'];
         $date=$row['date'];
         $prix=number_format($row['prix'],'0','0','.');
         $serie=$row['num_serie'];
         
         $q0="SELECT * FROM `clients` WHERE `id_client`='$nom'";
         $a=$con->query($q0);
         while($rr=mysqli_fetch_assoc($a)){
            $nom_c=$rr['nom_client'];
            $prenom=$rr['prenom_client'];
        $this->Cell(20,10,$i,1,0,'C');
        $this->Cell(30,10,$date,1,0,'L');
        $this->Cell(50,10,$nom_c.''.$prenom,1,0,'L');
        $this->Cell(50,10,$equipement,1,0,'L');
        $this->Cell(30,10,$serie,1,0,'L');
        $this->Cell(60,10,$taff,1,0,'L');
        $this->Cell(30,10,$prix,1,0,'R');
        $this->Ln();
         $i++;
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