<?php
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
                        
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=reporte_padron.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table>
    <thead>
      	<tr>
	        <th>APELLIDO</th>
	        <th>NOMBRE</th>
          <th>GENERO</th>
	        <th>DNI</th>
          <th>TELEFONO</th>
          <th>CALLE</th>
          <th>NUMERO</th>
          <th>BARRIO</th>
          <th>DIAGNOSTICO</th>
          <th>FECHA NACIMIENTO</th>
          <th>PRESCRIPCION</th>
          <th>MEDICO</th>
          <th>EFECTOR</th>
          <th>FECHA INSCRIPCION</th>
          <th>ESTADO</th>
        </tr>
    </thead>
  	<tbody>
    <?php
    $cam = mysqli_query($conexion,"SELECT a.apellido, a.nombre, a.genero, a.dni, a.diagnostico, a.fec_nac, a.prescriptor, a.telefono, a.calle, a.numero, a.barrio, b.nombre as nom, c.nombre as efector, a.estado
                                  FROM pad_psicotropicos a 
                                  LEFT JOIN pad_medicos b 
                                  ON a.prescriptor = b.mp
                                  LEFT JOIN efectores c 
                                  ON c.id = a.efector
                                  ORDER BY a.apellido ASC");  
    while ($rs=mysqli_fetch_array($cam)){ 
    echo "<tr>" 
          ."<td>".$rs['apellido']."</td>" 
          ."<td>".$rs['nombre']."</td>" 
          ."<td>".$rs['genero']."</td>" 
          ."<td>".$rs['dni']."</td>"
          ."<td>".$rs['telefono']."</td>"
          ."<td>".$rs['calle']."</td>"
          ."<td>".$rs['numero']."</td>"
          ."<td>".$rs['barrio']."</td>"
          ."<td>".$rs['dni']."</td>"
          ."<td>".$rs['diagnostico']."</td>"
          ."<td>".$rs['fec_nac']."</td>"
          ."<td>".$rs['prescriptor']."</td>"
          ."<td>".$rs['nom']." ".$rs['ape']."</td>"
          ."<td>".$rs['efector']."</td>"
          ."<td>".$rs['fecha_inscripcion']."</td>" 
          ."<td>".$rs['estado']."</td>" 
        ."</tr>"; 
        } 
    ?> 
        </tr>
    </tbody>
</table>