<?php
include("inc/conexion.php");
//require("fpdf/fpdf.php");
require('fpdf_barcode.php');
session_start();
$num_receta = $_SESSION['num_receta'];
$dni = $_SESSION['dni'];
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];

$pdf = new FPDF("P", "mm", array(150,130)); //p  , L 
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 10); //tamaño de letra
$pdf->cell(110, 4, "Validador CFC", 0, 1, "C"); //titulo
$pdf->cell(10,7,"Cierre ",0,1, "L");
$pdf->Cell(35, 4,  'Cuit : '.$_SESSION['cuit'].' | '.$_SESSION['idsucursal'], 0, 0, 'L', 0);
$pdf->Ln(4);
$vali =("SELECT * FROM users WHERE cuit = '$cuit' AND idsucursal = '$idsucursal'");
$r = mysqli_query($conexion,$vali);
$row1 = mysqli_fetch_array($r); 
$idmatricula = $row1['idmatricula'];
$farmacia = $row1['farmacia'];

$vali =("SELECT * FROM cierres_lotes WHERE num_cierre = '$num_cierre'");
$r = mysqli_query($conexion,$vali);
$row = mysqli_fetch_array($r); 

$periodo = $row['periodo'];
$cant_recetas = $row['cant_recetas'];
$fecha_alta = $row['fecha_alta'];
$num_cierre = $row['num_cierre'];
$tf = $row['tf'];
$tos = $row['tos'];
$dia = $row['dia'];
$mes = $row['mes'];
$ano = $row['ano'];


$pdf->SetFont("Arial", "", 7); //tamaño de letra
$pdf->Cell(35, 4,  'Farmacia : '.$farmacia.' | '.$_SESSION['cuit'], 0, 0, 'L', 0);
$pdf->Cell(35, 4,  'Suc Farmacia : '.$_SESSION['idsucursal'], 0, 0,  'L', 0);
$pdf->Ln(7);
$pdf->SetFont("Arial", "B", 10);


//$pdf->SetFont("Arial", "B", 7.5); //tamaño de letra para encabezados
//encabezados

$pdf->SetFont("Arial", "", 8); //tamaño de letra de los resultados de la tabla

//traer los datos de la base

$pdf->Cell(50, 4,  'Periodo : '.$periodo, 0, 1);
$pdf->Cell(50, 4,  'N de Cierre : '.$num_cierre, 0, 1);
$pdf->Cell(50, 4,  'Fecha Validacion : '.$fecha_alta, 0, 1);
$pdf->Cell(50, 4,  'Cant de Receteas : '.$cant_recetas, 0, 1);
$pdf->Cell(50, 4,  'Total Facturado : '.$tf, 0, 1);
$pdf->Cell(50, 4,  'Total AC : '.$tos, 0, 1);
	
$pdf->Output();
?>