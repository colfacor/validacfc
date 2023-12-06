<?php
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
                        
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=reporte_validaciones.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
    <thead>
      	<tr>
	        <th>RECETA</th>
	        <th>FECHA ALTA</th>
	        <th>FECHA RECETA</th>
	        <th>MP MEDICO</th>
	        <th>MEDICO</th>
	        <th>DNI AFILIADO</th>
	        <th>AFILIADO</th>
	        <th>DIAGNOSTICO</th>
          <th>FARMACIA</th>
          <th>MEDICAMENTO</th>
          <th>CANTIDAD</th>
          <th>PRECIO UNI.</th>
           <th>TOTAL</th>
        </tr>
    </thead>
  	<tbody>
    <?php
    $cam = mysqli_query($conexion,"SELECT a.num_receta, a.fecha_alta, b.fecha_receta, b.mp_med, b.dni_afi, c.cantidad, c.precio, d.medicamento, d.presentacion, e.nombre, e.apellido, f.nombre as nom, f.apellido as ape, g.farmacia, f.diagnostico
                                  FROM validaciones a 
                                  LEFT JOIN recetas b 
                                  ON a.num_receta = b.num_receta
                                  LEFT JOIN detalle_recetas c 
                                  ON b.num_receta = c.num_receta
                                  LEFT JOIN vade_psicotropicos d 
                                  ON c.troquel = d.troquel 
                                  LEFT JOIN pad_medicos e 
                                  ON b.mp_med = e.mp
                                  LEFT JOIN pad_psicotropicos f 
                                  ON b.dni_afi = f.dni
                                  LEFT JOIN users g 
                                  ON a.cuit_farm = g.cuit AND a.suc_farm = g.idsucursal
                                  WHERE a.fecha_alta BETWEEN '$desde' AND '$hasta'
                                  ORDER BY a.fecha_alta ASC");  
    while ($rs=mysqli_fetch_array($cam)){ 
    	$total = $rs['cantidad'] * $rs['precio'];
    echo "<tr>" 
           ."<td>".$rs['num_receta']."</td>" 
           ."<td>".$rs['fecha_alta']."</td>" 
            ."<td>".$rs['fecha_receta']."</td>" 
           ."<td>".$rs['mp_med']."</td>"  
           ."<td>".$rs['nombre']." ".$rs['apellido']."</td>"
           ."<td>".$rs['dni_afi']."</td>"
           ."<td>".$rs['nom']." ".$rs['ape']."</td>"
           ."<td>".$rs['diagnostico']."</td>"
           ."<td>".$rs['farmacia']."</td>"   
           ."<td>".$rs['medicamento']." ".$rs['presentacion']."</td>"
           ."<td>".$rs['cantidad']."</td>"
            ."<td>".number_format($rs['precio'], 2)."</td>"
             ."<td>".number_format($total, 2)."</td>"
           ."</tr>"; 
        } 
    ?> 
        </tr>
    </tbody>
</table>