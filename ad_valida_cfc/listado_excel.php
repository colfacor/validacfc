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
	          <th>RECETA</th>
            <th>TIPO</th>
            <th>CANTIDAD DE MEDICAMENTO</th>
            <th>NOMBRE DE LA DROGA</th>
            <th>COMERCIAL</th>
            <th>PROFESIONAL SUSCRIPTOR</th>
            <th>DIAGNOSTICO</th>
        </tr>
    </thead>
  	<tbody>
    <?php
    $cam = mysqli_query($conexion,"SELECT a.num_receta,b.tipo, b.mp_med, b.dni_afi, c.tipo, d.cantidad, d.troquel, e.troquel, e.medicamento, e.marca, f.mp, f.nombre, g.dni, g.diagnostico
                  FROM validaciones a
                  LEFT JOIN recetas b
                  ON a.num_receta = b.num_receta
                  LEFT JOIN tipos_medicamentos c 
                  ON b.tipo = c.id
                  LEFT JOIN detalle_recetas d
                  ON a.num_receta = d.num_receta
                  LEFT JOIN vade_psicotropicos e
                  ON d.troquel = e.troquel
                  LEFT JOIN pad_medicos f 
                  ON b.mp_med = f.mp
                  LEFT JOIN pad_psicotropicos g
                  ON b.dni_afi = g.dni");  
    while ($rs=mysqli_fetch_array($cam)){ 
    echo "<tr>" 
                    ."<td>".$reg['num_receta']."</td>"
                    ."<td>".$reg['tipo']."</td>"
                    ."<td>".$reg['cantidad']."</td>"
                    ."<td>".$reg['medicamento']."</td>"
                    ."<td>".$reg['marca']."</td>"
                    ."<td>".$reg['nombre']."</td>"
                    ."<td>".$reg['diagnostico']."</td>"
        ."</tr>"; 
        } 
    ?> 
        </tr>
    </tbody>
</table>