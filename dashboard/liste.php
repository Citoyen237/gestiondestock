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
        $this->SetFont('Times','B',30);
        $this->Cell(276,10,'Liste des produits en stock',0,0,'C');
        $this->Ln(15);
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        $this->SetFont('Times','B',14);
        $this->Cell(10,10,'ID',1,0,'C');
        $this->Cell(50,10,'Categorie',1,0,'C');
        $this->Cell(50,10,'Nom ',1,0,'C');
        $this->Cell(80,10,'Description',1,0,'C');
        $this->Cell(20,10,'Qdt',1,0,'C');
        $this->Cell(30,10,'Prix_u',1,0,'C');

        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',12);
      $sql="SELECT * FROM `produits`";
      $query=$con->query($sql) or die($con->error);
      $i=1;
      while($row=mysqli_fetch_assoc($query)){
        $this->Cell(10,10,$i,1,0,'C');
        $this->Cell(50,10,$row['categorie_id'],1,0,'L');
        $this->Cell(50,10,$row['nom'],1,0,'L');
        $this->Cell(80,10,$row['description'],1,0,'L');
        $this->Cell(20,10,$row['quandite'],1,0,'L');
        $this->Cell(30,10,$row['prix_achat'],1,0,'R');

        $this->Ln();
         $i++;
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