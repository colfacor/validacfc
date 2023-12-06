<?php
require 'conexion2.php';
require('fpdf_barcode.php');

	$query = "SELECT notas_credito_pami.*
                        FROM notas_credito_pami 
                        LEFT JOIN ma_padronsas ON ma_padronsas.pami = notas_credito_pami.pami
                         WHERE  idmatricula=4888 AND idsucursal=1 AND anoliquidacion = 2018 AND mesliquidacion = 4 AND periodoliquidacion = 1 AND versionliquidacion = 9 ";
	$resultado = $mysqli->query($query);




	$pdf = new PDF_BARCODE('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();

$pdf->EAN13(10,10,$row['importecomprobante'],5,0.5,9);




while($row = $resultado->fetch_assoc())
	{

	$importe = $row['importecomprobante'] / 1000;

	/*ENCABEZADO*/
	$pdf->SetFont('Arial','B',30);
	$pdf->Cell(60,5,'',0);
	$pdf->Cell(60,5,'NRFD',0,'',L);
	$pdf->Cell(60,5,'');

	$pdf->Ln(8);

	$pdf->SetFont('Arial','',6);
	$pdf->Cell(60,5,'Nota de Recuperacion de Descuento de Medicamentos Ambulatorios',0);
	$pdf->Cell(60,5,'',0,'',L);
	$pdf->Cell(60,5,'');
	$pdf->Line(10,25,200,25);

	$pdf->Ln(10);
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(60,5,'',0);
	$pdf->Cell(60,5,$row['nombreentidad'],0,'',C);
	
	$pdf->Ln(4);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(60,5,'Numero de Nota de Recuperacion   - ',0,'',L);
	$pdf->Cell(60,5,$row['numerocomprobante'],0,'',L);
	$pdf->Cell(60,5,'Fecha: '.date('d / m / y').'',0,'',R);
	$pdf->Line(10,40,200,40);

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'POR LA PRESENTE EL LABORATORIO',0,'',L);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,$row['codigodrogueria']." - ".$row['nombredrogueria'],0,'',L,'',C);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'RECONOCE A LA FARMACIA',0,'',L);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,$row['farmacia']." - ".$row['pami'],0,'',L,'',C);
	
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'PERTENECIENTE AL AGRUPAMIENTO',0,'',L);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,'COLEGIO DE CORDOBA',0,'',L,'',C);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'CONFORME AL VOLUMEN DE VENTAS DE',0,'',L);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'MEDICAMENTOS AMBULATORIOS PERTENECIENTES',0,'',L);
	
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'A PACIENTES AMBULATORIOS DE',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,$row['nombreentidad'],0,'',L);
	




	$pdf->Ln(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'DISCRIMINADOS POR LA DROGUERIA EN ANEXO APARTE.',0);

	$pdf->Ln(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'QUE CONFORMAN UN TOTAL',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,'$'.$importe,0,'',C);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'POR EL PERIODO',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,$row['anoliquidacion']."/".$row['mesliquidacion']."/".$row['periodoliquidacion'],0,'',C);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'DICHO IMPORTE SE ENCUANDRA EN EL CONVENIO ENTRE',0);
	
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'LAS AGRUPACIONES DE FARMACIAS, LABORATORIOS Y DROGUERIAS',0);
	$pdf->Line(10,85,200,85);
	$pdf->Ln(8);
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(60,5,'Estimado Farmaceutico:',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'Como le informara la agrupacion por la cual presenta las recetas de PAMI, recuerde que las farmacias deben validar las recetas a traves del sistema on-line y cerrar presentaciones quincenales',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'por medio del mismo.',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'Como usted sabe, la validacion on-line con cierre de presentacion, actualmente trae los siguientes beneficios a las farmacias:',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'- Un adelanto en las entregas de las autorizaciones de pago',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'- La seguridad de no recibir debitos si se cumplen con los aspectos "formales" de entrega de recetas (firmas,troqueles, etc.)',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'- Facilita el procesamiento, permitiendo el adelantamiento de la auditoria y liquidacion de recetas, aspecto este que, finalmente, redunda en un beneficio para las farmacias.',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'Con el fin de agilizar la acreditacion de estos comprobantes, este formulario sera remitido al titular del credito aqui expresado exclusivamente por via electronica, y no en soporte papel.',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'Ante cualquier duda consulte con la Entidad Farmaceutica que lo agrupa.',0);

	$pdf->Ln(3);

	$pdf->Cell(60,5,'Recuerde tener presente su codigo de farmacia PAMI, para agilizar su tramite ante cualquier consulta que tenga que realizar.',0);








}
	$pdf->Output();
?>