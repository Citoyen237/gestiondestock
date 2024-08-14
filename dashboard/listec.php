<?php
  require_once("connexionbd.php");
  require_once("fpdf/fpdf.php");

  class myPDF extends FPDF{
    function header(){
        $this->Image('logo.png',10,4);
        $this->SetFont('Arial','B',30);
        $this->SetX(57);
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
        $this->Cell(276,10,'Liste des clients',0,0,'J');
        $this->Ln(15);
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(10,10,'ID',1,0,'C');
        $this->Cell(50,10,'Nom client',1,0,'C');
        $this->Cell(50,10,'Nom prenom',1,0,'C');
        $this->Cell(25,10,'Telephone',1,0,'C');
        $this->Cell(30,10,'Nb commandes',1,0,'C');
        $this->Cell(30,10,'Date',1,0,'C');
        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',11);
      $sql="SELECT * FROM `clients` ";
      $query=$con->query($sql) or die($con->error);
      $i=1;
      while($row=mysqli_fetch_assoc($query)){
        $this->Cell(10,10,$i,1,0,'C');
        $this->Cell(50,10,$row['nom_client'],1,0,'L');
        $this->Cell(50,10,$row['prenom_client'],1,0,'L');
        $this->Cell(25,10,$row['telephone'],1,0,'L');
        $this->Cell(30,10,'2',1,0,'L');
        $this->Cell(30,10,$row['date_ce'],1,0,'L');
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
?>