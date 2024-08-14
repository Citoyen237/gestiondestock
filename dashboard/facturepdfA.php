<?php
  session_start();

  require_once("connexionbd.php");
  require_once("fpdf/fpdf.php");
  $idfac=$_SESSION['idfac'];

  class myPDF extends FPDF{
   // $idfac=10;
    function header(){
        $this->Image('logo.png',10,4);
        $this->SetX(57);
        $this->SetFont('Arial','B',20);
        $this->Cell(276,5,'ELISH-TECH',0,0,'J');
        $this->Ln(7);
        $this->SetX(57);
        $this->SetFont('Times','',14);
        $this->Cell(276,10,'Vente d\'accessoires informatique et maintenance',0,0,'J');
        $this->SetX(57);
        $this->Ln();
        $this->SetX(57);
        $this->SetFont('Times','B',16);
        $this->Cell(276,10,'Adresse: Douala/Missoke',0,0,'J');
        $this->ln();
        $this->SetX(57);
        $this->SetFont('Times','B',16);
        $this->Cell(276,10,'Telephone: 691207395',0,0,'J');
        $this->Ln(20);
        $host="127.0.0.1";
        $user="root";
        $pass="";
        $bd_name="higthtech";
        try{
        $con=new mysqli($host,$user,$pass,$bd_name);
        }catch(Exception $e){
        die("erreur:".$e->getMessage());
        }
        $idsa=$_SESSION['idfac'];
        //var_dump($idsa);
        $sql="SELECT * FROM `factures` WHERE `num_fac`='$idsa' ";
        $re=$con->query($sql) or die($con->error);
        if(mysqli_num_rows($re)!=0){
         $i=1;
        while($row=mysqli_fetch_assoc($re)){
         $id=$row['id_fac'];
         $numfac=$row['num_fac'];
         $date=$row['date_fac'];
         $sql5="SELECT * FROM `ventes` WHERE `codeFac`='$numfac' ";
         $quere=$con->query($sql5) or die($con->error);
         while($rs=mysqli_fetch_assoc($quere)){
           $cd=$rs['id_client'];
           $sql01="SELECT * FROM `clients` WHERE `id_client`='$cd'";
           $quer7=$con->query($sql01) or die($con->error);
           while($rs1=mysqli_fetch_assoc($quer7)){
             $nomd=$rs1['nom_client'];
             $nomp=$rs1['prenom_client'];
             $phone=$rs1['telephone'];
           }

         }
         $datefac=$row['date_fac'];}}
         
        $this->SetFont('Times','BI',17);
        $this->Cell(276,10,'Nom du client : '.$nomd.' '.$nomp,0,0,'L');
        $this->SetXY(130,57);
        $this->Cell(276,10,'Num Facture : V00'.$numfac,0,0,'');
        $this->Ln();
        $this->SetFont('Times','BI',17);
        $this->Cell(276,10,'Telephone : '.$phone,0,0,'L');
        $this->SetXY(130,67);
        $this->Cell(276,10,'Date : '.$date,0,0,'');
        $this->Ln(25);
        $host="127.0.0.1";
        $user="root";
        $pass="";
        $bd_name="higthtech";

    }

    function footer(){
        
      $this->SetY(-15);
      $this->SetFont('Arial','',10);
      $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}');
    }

    function headerTable(){
        $this->SetFont('Times','B',16);
        $this->Cell(10,13,'ID',1,0,'C');
        $this->Cell(80,13,'Designation',1,0,'C');
        $this->Cell(20,13,'Qdt',1,0,'C');
        $this->Cell(30,13,'Prix U',1,0,'C');
        $this->Cell(40,13,'PrixT',1,0,'C');

        $this->Ln();
    }

    function viewTable($con){
      $this->SetFont('Times','',12);
      $montant=0;
      $idsa=$_SESSION['idfac'];
      $sql="SELECT * FROM `factures`WHERE `num_fac`='$idsa' ";
                       $re=$con->query($sql);
                        $i=1;
                       while($row=mysqli_fetch_assoc($re)){
                        $id=$row['id_fac'];
                        $numfac=$row['num_fac'];
                        $sql5="SELECT * FROM `ventes` WHERE `codeFac`='$numfac' ";
                        $quere=$con->query($sql5) or die($con->error);
                        while($rs=mysqli_fetch_assoc($quere)){
                            $qua=$rs['quantite_a'];
                            $pru=$rs['prix_u'];
                            $prt=$rs['prix_t'];
                            $cd=$rs['id_pr'];
                          $sql01="SELECT * FROM `produits` WHERE `id_pro`='$cd'";
                          $quer7=$con->query($sql01) or die($con->error);
                          while($rs1=mysqli_fetch_assoc($quer7)){
                            $nomd=$rs1['categorie_id'];
                            $nomp=$rs1['description'];
                          }
                          
        $this->Cell(10,10,$i,1,0,'C');
        $this->Cell(80,10,$nomd.'/'.$nomp,1,0,'L');
        $this->Cell(20,10,$qua,1,0,'R');
        $this->Cell(30,10,$pru,1,0,'R');
        $this->Cell(40,10,$prt,1,0,'R');
        $this->Ln();
        $montant=$prt+$montant;
        }
        
        $prix=number_format($montant,'0','0','.');
         $i++;
         
      }
    $this->SetFont('Times','B',17);
   // $this->SetDrawColor(0 , 80, 180);
   // $this->SetTextColor(0 , 80, 180);
    $this->SetFillColor(0,0,255);
    $this->Cell(140,10,'NET A PAYER TTC : ',1,0,'C','TRUE');
    $this->Cell(40,10,$prix.' F',1,0,'C');
    $this->Ln(25);
    $this->SetFont('Times','I',14);
    $this->Cell(180,10,'Les marchandises ci-dessus sont vendues en bon etat: elles ne sont ni reprises ni echangees 30
    ',0,1,'J',);
    $this->Cell(180,10,'jours de garantie et pas de remboursement.',0,1,'J');
    $this->SetFont('Times','B',20);
    $this->SetTextColor(0,0,255);
    $this->Cell(180,10,'Signature vendeur                                          Signature client',0,1,'J');
    

  }


}
 
  $pdf=new myPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage('P','A4',0);
  $pdf->headerTable();
  $pdf->viewTable($con);
  $pdf->Output();
?>