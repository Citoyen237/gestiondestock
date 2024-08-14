<?php
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
        $this->SetFont('Times','BU',20);
        $this->Cell(276,10,'Liste des depences',0,0,'J');
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
        $quer="SELECT * FROM `depenses` ";
        $exe=$con->query($quer) or die($con->error);
        $totalachat =0;
        while($row=mysqli_fetch_assoc($exe)){
        $somme=$row['montant'];
        $totalachat+=$somme;
        }
        $this->SetFont('Arial','B',14);
        $totalachatf=number_format($totalachat,'0','0','.');
        $this->Cell(276,10,'Montant Total: '.$totalachatf.'FCFA',0,0,'J');
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
        $this->Cell(80,10,'Motifs',1,0,'C');
        $this->Cell(50,10,'Montant(FCFA)',1,0,'C');
        $this->Cell(40,10,'Date',1,0,'C');
        
        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',14);
      $sql="SELECT * FROM `depenses` ORDER BY  `date_d` DESC ";
      $query=$con->query($sql) or die($con->error);
      $i=1;
      while($row=mysqli_fetch_assoc($query)){
       $montantf=number_format($row['montant'],'0','0','.');
        $this->Cell(20,10,$i,1,0,'C');
        $this->Cell(80,10,$row['motif'],1,0,'L');
        $this->Cell(50,10,$montantf,1,0,'R');
        $this->Cell(40,10,$row['date_d'],1,0,'R');
        $this->Ln();
         $i++;
      }
    }
  }
 
  $pdf=new myPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage('P','A4',0);
  $pdf->headerTable();
  $pdf->viewTable($con);
  $pdf->Output();
