<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("inc/conexion.php");
require('../fpdf_barcode.php');

session_start();

$num_cierre = base64_decode($_GET['num_cierre']);
$farmacia = $_GET['farmacia'];
$cuit_farm = $_GET['cuit_farm'];
$suc = $_GET['suc'];

$vali = ("SELECT id_obrasocial
         FROM cierres_lotes 
         WHERE num_cierre = '$num_cierre'");
$r = mysqli_query($conexion, $vali);
$row = mysqli_fetch_array($r); 
$id_obrasocial = $row['id_obrasocial'];

$vali = ("SELECT obra_social
         FROM obras_sociales
         WHERE id = '$id_obrasocial'");
$r = mysqli_query($conexion, $vali);
$row = mysqli_fetch_array($r); 
$obra_social = $row['obra_social'];

// Obtener los datos restantes de la base de datos
$vali = ("SELECT * FROM cierres_lotes WHERE num_cierre = '$num_cierre'");
$r = mysqli_query($conexion, $vali);
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

$pdf = new PDF_Code128('P','mm',array(200,200),true,'UTF-8',false);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 10); // Tamaño de letra
$pdf->Ln(20);
$pdf->Cell(180, 8, "Valida CFC", 1, 1, "C");
$pdf->Cell(180, 15, ''.$obra_social, 1, 1, "L");
$pdf->Cell(180, -5, "Cierre de Presentacion ", 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 8); // Tamaño de letra
$pdf->Cell(180, 20,  'Farmacia : '. $farmacia . "       Sucursal:  " . $suc, 'LRT', 1, 'L', 0);
$pdf->Ln(-12);
$pdf->Cell(180, 20,  'Cuit : '. $cuit_farm, 'LRB', 1, 'L', 0);

$pdf->Ln(0);
$pdf->SetFont("Arial", "B", 8);

$pdf->Ln(0);
$pdf->SetFillColor(180, 180, 180);
$pdf->Cell(28, 10, 'Periodo', 1, 0, 'C');
$pdf->Cell(50, 10, 'N de Cierre', 1, 0, 'C', 0);
$pdf->Cell(33, 10, 'Fecha de Cierre', 1, 0, 'C');
$pdf->Cell(10, 10, 'Rec', 1, 0, 'C', 0);
$pdf->Cell(30, 10, 'Total Facturado', 1, 0, 'C');
$pdf->Cell(29.4, 10, 'Total AC', 1, 1, 'C', 0);
$pdf->SetFillColor(1, 1, 1);
$pdf->Cell(28, 10,  ''.$periodo, 1, 0, 'C');
$pdf->Cell(50, 10,  ''.$num_cierre, 1, 0, 'C');
$pdf->Cell(33, 10,  ''.$fecha_alta, 1, 0, 'C');
$pdf->Cell(10, 10,  ''.$cant_recetas, 1, 0, 'C');
$pdf->Cell(30, 10,  ''.number_format($tf, 2), 1, 0, 'C');
$pdf->Cell(29.4, 10,  ''.number_format($tos, 2), 1, 1, 'C');

$pdf->SetFont('Arial', '', 5);
$pdf->Code128(87, 10, $num_cierre, 39, 9);
$pdf->SetXY(100, 18);

$pdf->Ln(3);

$pdf->Output();
?>
