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
        $this->Cell(276,10,'Categories de produits',0,0,'J');
       
        $this->Ln(15);
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        //$this->SetX(50);
        $this->SetFont('Times','B',14);
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(80,10,'Noms',1,0,'C');
        $this->Cell(50,10,'Quandites',1,0,'C');
        $this->Cell(40,10,'Valeurs(FCFA)',1,0,'C');
        
        $this->Ln();
    }

    function viewTable($con){
      //$this->SetX(50 );
      $this->SetFont('Times','',14);
      $valeur=0;
      $sql2="SELECT * FROM `categorie`";
      $query2=$con->query($sql2);
      if(mysqli_num_rows($query2)>0){
       $i=1;
        while($row=mysqli_fetch_assoc($query2)){
           $idc=$row['id'];
           $libelle=$row['libelle'];
           $sql3="SELECT `quandite`,`prix_vente` FROM `produits` WHERE `categorie_id`='$libelle'";
           $query3=$con->query($sql3);
           $qdttotal=0;
          while( $rowz=mysqli_fetch_assoc($query3)){
               $qdttotal=$qdttotal + $rowz['quandite'];
               $valeur=$valeur+$rowz['prix_vente'];
             }
            // $this->SetX(50);
             $this->SetFont('Times','',14);
             $valeur=$valeur*$qdttotal;
             $valeur=number_format($valeur,'0','0','.');
             
             $this->Cell(20,10,$i,1,0,'C');
             $this->Cell(80,10,$row['libelle'],1,0,'L');
             $this->Cell(50,10,$qdttotal,1,0,'R');
             $this->Cell(40,10,$valeur,1,0,'R');
             $this->Ln();
           $valeur=0;
           $i++;
        }
     
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