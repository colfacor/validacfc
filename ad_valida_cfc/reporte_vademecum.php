<?php
include('inc/conexion.php');
session_start();                       
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=reporte_vademecum.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
    <thead>
      	<tr>
	        <th>REG</th>
            <th>TROQUEL</th>
            <th>MEDICAMENTO</th>
            <th>MARCA</th>
            <th>PRESENTACION</th>
            <th>COMPRIMIDOS</th>
            <th>PRECIO</th>
            
            <th>COD LABORATORIO</th>
            <th>ESTADO</th>
            <th>TIPO</th>
        </tr>
    </thead>
  	<tbody>
    <?php
    $cam = mysqli_query($conexion,"SELECT  * FROM vade_psicotropicos WHERE estado =1");  
    while ($rs=mysqli_fetch_array($cam)){ 
    echo "<tr>" 
            ."<td>".$rs['reg']."</td>"
            ."<td>".$rs['troquel']."</td>"
            ."<td>".$rs['medicamento']."</td>"
            ."<td>".$rs['marca']."</td>" 
            ."<td>".$rs['presentacion']."</td>"
            ."<td>".$rs['comprimidos']."</td>"
            ."<td>".$rs['precio']."</td>" 
            
            ."<td>".$rs['cod_laboratorio']."</td>" 
            ."<td>".$rs['estado']."</td>"   
            ."<td>".$rs['tipo']."</td>"           
          ."</tr>"; 
        } 
    ?> 
        </tr>
    </tbody>
</table>