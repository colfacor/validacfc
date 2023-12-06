<?php 
require('fpdf_barcode.php');

$pdf = new PDF_BARCODE("P", "mm", array(150,130));
$pdf->AddPage();

//EAN13 test

$pdf->EAN13(10,30,'1234555441',5,0.35,9);

$pdf->Output();

