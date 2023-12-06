<?php
include("inc/conexion.php");
//require("fpdf/fpdf.php");
require('fpdf_barcode.php');
session_start();
$num_receta = $_SESSION['num_receta'];
$dni = $_SESSION['dni'];
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$convenio = $_SESSION['convenio'];
$num_cierre = base64_decode($_GET['num_cierre']);

$vali =("SELECT id_obrasocial
		FROM cierres_lotes 
		WHERE num_cierre = '$num_cierre'");
$r = mysqli_query($conexion,$vali);
$row = mysqli_fetch_array($r); 
$id_obrasocial = $row['id_obrasocial'];

$vali =("SELECT obra_social
		FROM obras_sociales
		WHERE id = '$id_obrasocial'");
$r = mysqli_query($conexion,$vali);
$row = mysqli_fetch_array($r); 
$obra_social = $row['obra_social'];


$pdf=new PDF_Code128('P','mm',array(200,200),true,'UTF-8',false);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 10); //tamaño de letra
$pdf->Ln(20);
$pdf->cell(180, 8, "Valida CFC", 1, 1, "C");
$pdf->cell(180,15,''.$obra_social,1,1, "L");
$pdf->cell(180,-5,"Cierre de Presentacion ",0,1, "L");
$pdf->Ln(5);

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


$pdf->SetFont("Arial", "B", 8); //tamaño de letra
$pdf->Cell(180, 20,  'Farmacia : '. $farmacia, 1, 1, 'L', 0);
$pdf->Cell(180, -4,  'MP | Sucursal : '.$idmatricula.' | '.$_SESSION['idsucursal'], 0, 1,  'L', 0);
$pdf->Cell(180, -2,  'Cuit : '.$_SESSION['cuit'], 0, 1,  'L', 0);
$pdf->Ln(7);
$pdf->SetFont("Arial", "B", 10);


//$pdf->SetFont("Arial", "B", 7.5); //tamaño de letra para encabezados
//encabezados

$pdf->SetFont("Arial", "", 8); //tamaño de letra de los resultados de la tabla
//traer los datos de la base


	$pdf->Ln(3);
	$pdf->SetFillColor(180, 180, 180);
	$pdf->cell (28,10, 'Periodo', 1,0,'C');
	$pdf->cell (50,10, 'N de Cierre', 1,0,'C', 0);
	$pdf->cell (33,10, 'Fecha de Cierre', 1, 0, 'C');
	$pdf->cell (10,10, 'Rec', 1, 0, 'C', 0);
	$pdf->cell (30,10, 'Total Facturado', 1, 0, 'C');
	$pdf->cell (29.4,10, 'Total AC', 1, 1, 'C', 0);
    $pdf->SetFillColor(1, 1, 1);
	$pdf->Cell(28, 10,  ''.$periodo, 1, 0, 'C');
	$pdf->Cell(50, 10,  ''.$num_cierre, 1, 0, 'C');
	$pdf->Cell(33, 10,  ''.$fecha_alta, 1, 0, 'C');
	$pdf->Cell(10, 10,  ''.$cant_recetas, 1, 0, 'C');
	$pdf->Cell(30, 10,  ''.number_format($tf, 2), 1, 0, 'C');
	$pdf->Cell(29.4, 10,  ''.number_format($tos, 2), 1, 1, 'C');


 /***CODIGO DE BARRAS***/

	$pdf->SetFont('Arial','',5);
	$pdf->Code128(87,10,$num_cierre,39,9);
	$pdf->SetXY(100,18);
	
	/***CODIGO DE BARRAS***/

$pdf->Ln(3);

$pdf->Output();
?>