<?php
$host="127.0.0.1";
$user="root";
$pass="";
$bd_name="higthtech";
try{
 $con=new mysqli($host,$user,$pass,$bd_name);
}catch(Exception $e){
    die("erreur:".$e->getMessage());
}
?>



