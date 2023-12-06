<?php
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
                        
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=reporte_ab.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
    <thead>
      	<tr>
            <th>reg</th>
            <th>prc</th>
            <th>vig</th>
            <th>nom</th>
            <th>pres</th>
            <th>labo</th>
            <th>tro</th>
            <th>est</th>
            <th>imp</th>
            <th>hel</th>
            <th>iva</th>
            <th>bars</th>
            <th>tipov</th>
            <th>salud</th>
            <th>tam</th>
            <th>for</th>
            <th>via</th>
            <th>dro</th>
            <th>acc</th>
            <th>upot</th>
            <th>pot</th>
            <th>uuni</th>
            <th>uni</th>
            <th>grav</th>
            <th>cel</th>
        </tr>
    </thead>
  	<tbody>
    <?php
    $cam = mysqli_query($conexion," SELECT *
                                  FROM alfabeta_articulos ");  
    while ($rs=mysqli_fetch_array($cam)){ 
          echo "<tr>" 
                 ."<td>".$rs['reg']."</td>" 
                 ."<td>".$rs['prc']."</td>" 
                 ."<td>".$rs['vig']."</td>"
                 ."<td>".$rs['nom']."</td>"  
                 ."<td>".$rs['pres']."</td>"
                 ."<td>".$rs['labo']."</td>"
                 ."<td>".$rs['tro']."</td>"
                 ."<td>".$rs['est']."</td>"
                 ."<td>".$rs['imp']."</td>"   
                 ."<td>".$rs['hel']."</td>"
                 ."<td>".$rs['iva']."</td>"
                 ."<td>".$rs['bars']."</td>"
                 ."<td>".$rs['tipov']."</td>"
                 ."<td>".$rs['salud']."</td>"
                 ."<td>".$rs['tam']."</td>"
                 ."<td>".$rs['for']."</td>"
                 ."<td>".$rs['via']."</td>"
                 ."<td>".$rs['dro']."</td>"
                 ."<td>".$rs['acc']."</td>"
                 ."<td>".$rs['upot']."</td>"
                 ."<td>".$rs['pot']."</td>"
                 ."<td>".$rs['uuni']."</td>"
                 ."<td>".$rs['uni']."</td>"
                 ."<td>".$rs['grav']."</td>"
                 ."<td>".$rs['cel']."</td>"
                ."</tr>"; 
        } 
    ?> 
        </tr>
    </tbody>
</table>