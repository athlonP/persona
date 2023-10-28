<?php
include("conexion.php");
$conn=conectar();


$codigo=$_POST['codigo'];
$id=$_GET['id'];
$producto=$_POST['producto'];
$marca=$_POST['marca'];
$precio=$_POST['precio'];
$stock=$_POST['stock'];
$fecha_compra=$_POST['fecha_compra'];

$sql="INSERT INTO producto (`codigo`, `id`,`producto`,`marca`,`precio`,`stock`,`fecha_compra`)
VALUES('$codigo','$id','$producto','$marca','$precio','$stock','$fecha_compra')";
$query= mysqli_query($conn,$sql);

if($query){
    Header("Location: product.php");
    
}else {
}
?>