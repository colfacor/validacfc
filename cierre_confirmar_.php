<?php
include('inc/conexion.php');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
if (!isset($_SESSION['cuit'])) {
    header("location: index.php?msj=" . base64_encode('cs'));
    exit();
}

$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set("America/Argentina/Buenos_Aires");
$fecha = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');

if (isset($_POST['num_receta'], $_POST['tf'], $_GET['periodo'], $_GET['id_obrasocial'])) {
    $num_receta = $_POST['num_receta'];
    $tf = $_POST['tf'];
    $periodo = $_GET['periodo'];
    $id_obrasocial = $_GET['id_obrasocial'];
    $num_cierre = $periodo . $cuit . $idsucursal . $dia . $mes . $hora;
    $cant_recetas = count($num_receta);

    $lista3 = "SELECT * FROM cierres_lotes WHERE cuit_farm = '$cuit' AND suc_farm = '$idsucursal' AND periodo = '$periodo'";
    $rs3 = mysqli_query($conexion, $lista3);
    $row1 = mysqli_fetch_array($rs3);
    $num_cierre_ = $row1['num_cierre'];

    if (!empty($num_cierre_)) {
        header("location: cierres.php?msj=" . base64_encode('rep'));
        exit();
    }

    foreach ($num_receta as $num_rec) {
        mysqli_query($conexion, "UPDATE validaciones SET cierre = '1' WHERE num_receta = '$num_rec'");

        $lista3 = "SELECT SUM(precio*cantidad) as total FROM detalle_recetas WHERE num_receta = '$num_rec'";
        $rs3 = mysqli_query($conexion, $lista3);
        $row1 = mysqli_fetch_array($rs3);
        $tf = $row1['total'];

        mysqli_query($conexion, "INSERT INTO detalle_cierres (periodo, num_cierre, num_receta, tf) VALUES ('$periodo','$num_cierre','$num_rec','$tf')");
    }

    $tf_query = "SELECT SUM(tf) as total FROM detalle_cierres WHERE num_cierre = '$num_cierre'";
    $rs = mysqli_query($conexion, $tf_query);
    $row2 = mysqli_fetch_array($rs);
    $tf_total = $row2['total'];

    $insert_query = "INSERT INTO cierres_lotes (id_obrasocial, periodo, num_cierre, cuit_farm, suc_farm, cant_recetas, tf, tos, dia, mes, ano, hora, minuto, fecha_alta, ip) 
    VALUES ('$id_obrasocial', '$periodo', '$num_cierre', '$cuit', '$idsucursal', '$cant_recetas', '$tf_total', '$tf_total', '$dia', '$mes', '$ano', '$hora', '$minuto', '$fecha', '$ip_add')";

    if (mysqli_query($conexion, $insert_query)) {
        $logFile = fopen("../log/log_cierres.txt", 'a');
        if ($logFile) {
            fwrite($logFile, "\n" . date("d/m/Y H:i:s") . " Cierre Exitoso: " . $cuit . ' / ' . $idsucursal . ' - ' . $ip_add . ' - ' . $num_cierre);
            fclose($logFile);
        }

        echo "<script>window.open('comprobantecierrepdf.php?num_cierre=" . base64_encode($num_cierre) . "', '_blank');</script>";
        echo "<script>window.location='cierres.php?msj=" . base64_encode('ex') . "';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>