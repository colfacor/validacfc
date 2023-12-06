<?php
include("inc/conexion.php");
require('fpdf_barcode.php');
session_start();
$num_validacion = base64_decode($_GET['num_validacion']);
$id_obrasocial = base64_decode($_GET['id_obrasocial']);

//$pdf = new FPDF("P", "mm", array(150,130)); //p  , L 
$pdf=new PDF_Code128('P','mm',array(150,130),true,'UTF-8',false);

for ($i = 1; $i <= 2; $i++) {
$pdf->AddPage();
$pdf->Ln(13);
$pdf->SetFont("Arial", "B", 6); //tamaño de letra
$pdf->cell(50, 4, "Validador CFC |  PLAN MEJORAR | RECETA VALIDADA!", 0, 1, "L"); //titulo

	if($i == 2){
	$pdf->SetFont("Arial", '',6);
	$pdf->cell(50, 5, "Duplicado", 0, 1, "L"); //titulo
	}

$pdf->SetFont("Arial", "B", 6); //tamaño de letra
if($id_obrasocial == 1){
$pdf->cell(50,7,"Programa Municipalidad Mejorar",0,1, "L");
}


$vali =("SELECT a.num_receta, a.num_validacion, a.cuit_farm, a.suc_farm, a.estado, a.dia, a.mes, a.ano, a.hora, a.minuto , a.fecha_alta, c.farmacia, d.tipo
		FROM validaciones a
		LEFT JOIN estados_validacion b 
		ON a.estado = b.id
		LEFT JOIN users c 
		ON c.cuit = a.cuit_farm AND c.idsucursal = a.suc_farm
		LEFT JOIN recetas d 
		ON a.num_receta = d.num_receta
		WHERE a.num_validacion = '$num_validacion'");
$r = mysqli_query($conexion,$vali);
$row = mysqli_fetch_array($r); 

$cuit_farm = $row['cuit_farm'];
$suc_farm = $row['suc_farm'];
$num_receta = $row['num_receta'];
$fecha_alta = $row['fecha_alta'];
$dia = $row['dia'];
$mes = $row['mes'];
$ano = $row['ano'];
$hora = $row['hora'];
$minuto = $row['minuto'];
$estado = $row['estado'];
$farmacia = $row['farmacia'];
$tipo = $row['tipo'];


$pdf->SetFont("Arial", "", 6); //tamaño de letra
$pdf->Cell(35, 4,  $row['farmacia'].'               Cuit : '.$row['cuit_farm'], 0, 0, 'L', 0);
$pdf->Cell(35, 4,  '                                                                           Suc Farmacia : '.$row['suc_farm'], 0, 0,  'L', 0);
$pdf->Ln(3);
$pdf->SetTextColor(0,100,0);
$pdf->SetFont("Arial", "B", 7);
//$pdf->cell(60,10,'VALIDADO!  ',0,1,'L',0);
$pdf->SetTextColor(0,0,0);

//$pdf->SetFont("Arial", "B", 7.5); //tamaño de letra para encabezados
//encabezados

$pdf->SetFont("Arial", "", 6); //tamaño de letra de los resultados de la tabla

//traer los datos de la base

$pdf->Cell(35, 4,  'N de Validacion :  '. base64_decode($_GET['num_validacion']). '  |  Fecha: '. $row['fecha_alta'].' '.$row['hora'].':'.$row['minuto'], 0, 0, 'L',0);

	

$recet =("SELECT a.num_receta, a.fecha_receta, a.dni_afi, a.mp_med, b.dni, b.nombre as nom_afi, b.apellido as ape_afi, c.mp, c.nombre
	             FROM recetas a
	             LEFT JOIN pad_psicotropicos b
	             ON a.dni_afi = b.dni
                 LEFT JOIN pad_medicos c
                 ON a.mp_med = c.mp
	             WHERE a.num_receta = '$num_receta'");
$r = mysqli_query($conexion,$recet);
$row1 = mysqli_fetch_array($r); 


$fecha_receta = $row1['fecha_receta'];
$mp_med = $row1['mp_med'];
$med_nombre = $row1['nombre'];
$nom_afi = $row1['nom_afi'];
$ape_afi = $row1['ape_afi'];
$estado = $row1['estado'];
$dni = $row1['dni_afi'];
$num_receta = $row1['num_receta'];

$pdf->Ln(5);
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(50, 4,  'Medico : '.$mp_med.' | N de Receta : '.$num_receta, 0, 1);
$pdf->Cell(50, 4,  'Nombre Medico : '.$med_nombre.' | Fecha Receta : '.$fecha_receta, 0, 1);
$pdf->Cell(50, 4,  'Nombre Afiliado : '.$nom_afi. ' Apellido Afiliado : '.$ape_afi.'  DNI : '.$dni, 0, 1);


if($tipo ==1){
$pdf->Ln(3);
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(50, 4,  'Receta Prescripta por Medico', 0, 1);
$pdf->SetFont("Arial", 'B', 6);
$pdf->Cell(10,7,'Cant',0,0,'C',0);    
$pdf->Cell(55,7,'          Descripcion',0,0,'C',0);
$pdf->Cell(30,7,'                   Precio',0,0,'C',0);
$pdf->Ln(3);
$rece =("SELECT a.cantidad, a.troquel, a.precio, b.troquel, b.medicamento, b.presentacion
	             FROM detalle_recetas_prescriptas a
	             LEFT JOIN vade_psicotropicos b 
	             ON a.troquel = b.troquel	     
	             WHERE a.num_receta = '$num_receta'");
$r = mysqli_query($conexion,$rece);
 
while($row2 = $r->fetch_assoc()) {

$pdf->Ln(4);
$pdf->SetFont("Arial", '', 6);
$pdf->Cell(10, 3,  ''.$row2['cantidad'], 0, 0, 'C',0);
$pdf->Cell(50, 3,  ''.$row2['medicamento'], 0, 0, 'C',0);
$pdf->Cell(40, 3,  ''.$row2['presentacion'], 0, 0, 'C',0);
}
}
$pdf->Ln(5);
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(50, 4,  'Receta Dispensada', 0, 1);
$pdf->SetFont("Arial", 'B', 6);

$rece =("SELECT a.cantidad, a.troquel, a.precio, b.troquel, b.medicamento, b.presentacion
	             FROM detalle_recetas a
	             LEFT JOIN vade_psicotropicos b 
	             ON a.troquel = b.troquel	     
	             WHERE a.num_receta = '$num_receta'");
$r = mysqli_query($conexion,$rece);
 
while($row2 = $r->fetch_assoc()) {

$pdf->Ln(4);
$pdf->SetFont("Arial", '', 6);
$pdf->Cell(10, 3,  ''.$row2['cantidad'], 0, 0, 'C',0);
$pdf->Cell(50, 3,  ''.$row2['medicamento'], 0, 0, 'C',0);
$pdf->Cell(40, 3,  ''.$row2['presentacion'], 0, 0, 'C',0);
$pdf->Cell(30, 3,              '$ '.$row2['precio'], 0, 0, 'L',0);
}
$pdf->Ln(7);
include("inc/conexion.php");
$vali =("SELECT SUM(cantidad*precio) as total
	             FROM detalle_recetas 	     
	             WHERE num_receta = '$num_receta'");
$r = mysqli_query($conexion,$vali);
$row3 = mysqli_fetch_array($r); 

$pdf->Cell(10, 3,  '', 0, 0, 'C',0);
$pdf->Cell(50, 3,  '', 0, 0, 'C',0);
$pdf->Cell(1, 3,  'Total:', 0, 0, 'C',0);
$pdf->Cell(52, 3,                '$ '.number_format($row3['total'], 2), 0, 0, 'C',0);



 /***CODIGO DE BARRAS***/

	$pdf->SetFont('Arial','',5);
	$pdf->Code128(11,10,$num_validacion,25,6);
	$pdf->SetXY(100,18);
	$pdf->Write(1,'',10);
	/***CODIGO DE BARRAS***/
}
$pdf->Output();
?>