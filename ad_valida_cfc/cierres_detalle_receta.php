<?php
$num_receta_param = base64_decode($_GET['num_receta']);
include('inc/header.php');
include('inc/panel.php');
$ip_add = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_hoy = date("Y-m-d");
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$hora = date('H');
$minuto = date('i');
session_start();
$cuit = $_SESSION['cuit'];
$idsucursal = $_SESSION['idsucursal'];
$num_cierre = base64_decode($_GET['num_cierre']);
$num_receta = base64_decode($_GET['num_receta']);
?>

<style>
.auditado {
    color: red; 
    font-weight: bold; 
}

 .auditar {
    color: green;
    font-weight: bold; 
   
}

</style>

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Numero Receta: <?php echo $num_receta_param ?></h5><br>
        <h5 class="card-title">Numero Cierre: <?php echo $num_cierre ?></h5><br>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>       
    </div>
    <div class="card-body">
        <div class="form-group row">  
            <div class="col-md-2">            
            </div>
            <div class="col-md-2">            
            </div>
            <div class="col-md-2">            
            </div>
            <div class="col-md-2">            
            </div>
            <div class="col-md-2">        
            </div>
            <div class="col-md-2">
                <input type="text" name="caja_busqueda" id="buscador" class="form-control rounded-round" placeholder="Buscar....">
            </div>
        </div>    

        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable-highlight">
                <thead>
                    <tr class="bg-dark">
                        <th>Cantidad</th>
                        <th>Medicamento</th>
                        <th>Presentación</th>
                        <th>Total Declarado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
            <tbody id="tabla">
    <?php
    include ('inc/conexion.php');
    $registros = mysqli_query($conexion, "SELECT a.dni_afi, a.num_receta, a.fecha_receta, c.apellido, c.nombre, d.num_receta, d.cantidad, d.precio, d.renglon, e.medicamento, e.presentacion, g.debito, g.total_auditado, g.observaciones, g.num_receta, dr.renglon as renglon_detalle
                      FROM recetas a
                      LEFT JOIN pad_psicotropicos c ON a.dni_afi = c.dni
                      LEFT JOIN detalle_recetas d ON d.num_receta = a.num_receta
                      LEFT JOIN vade_psicotropicos e ON d.troquel = e.troquel
                      LEFT JOIN auditoria g ON a.num_receta = g.num_receta
                      LEFT JOIN detalle_recetas dr ON dr.renglon = a.num_receta
                      WHERE a.num_receta = '$num_receta_param' AND d.renglon = d.renglon");
    
    while ($reg=mysqli_fetch_array($registros)){  
        $total = $reg['cantidad'] * $reg['precio'];
        $fecha_receta = $reg['fecha_receta'];
        $num_receta_actual = $reg['num_receta']; // Utiliza una variable diferente para el número de receta actual
        
        // Verifica si existe un registro en la tabla auditoria con el mismo num_receta y renglon
        $consulta_auditoria = mysqli_query($conexion, "SELECT COUNT(*) as existencia FROM auditoria WHERE num_receta = '$num_receta_actual' AND renglon = '{$reg['renglon']}'");
        $resultado_auditoria = mysqli_fetch_assoc($consulta_auditoria);
        
        echo "<tr>"
        ."<td><span class='badge bg-success-400'>".$reg['cantidad']."</span></td>"
        ."<td><span class='badge bg-primary-400'>".$reg['medicamento']."</span></td>"
        ."<td><span class='badge bg-primary-400'>".$reg['presentacion']."</td>"
        ."<td>$ ".number_format($total, 2)."</span></td>";

        // Comprueba si existe un registro en auditoria
          if ($resultado_auditoria['existencia'] > 0) {
            echo "<td><a class='auditar' href='cierre_detalle_receta_insert.php?cantidad=".$reg['cantidad']."&medicamento=".urlencode($reg['medicamento'])."&presentacion=".urlencode($reg['presentacion'])."&total=".$total."&fecha_receta=".$fecha_receta."&num_cierre=".$num_cierre."&num_receta=".$num_receta_param."&precio=".$reg['precio']."&renglon=".$reg['renglon']."&observaciones=".$reg['observaciones']."'>AUDITAR</a>  -  <a class='auditado' href='auditado_total.php?num_cierre=".$num_cierre."&num_receta=".$reg['num_receta']."&renglon=".$reg['renglon']."'>AUDITADO</a>
                <a class='actualizar' href='actualizacion.php?num_cierre=" . $num_cierre . "&num_receta=" . $num_receta_param . "&renglon=" . $reg['renglon'] . "'>ACTUALIZAR</a></td>";
        } else {
            echo "<td><a class='auditar' href='cierre_detalle_receta_insert.php?cantidad=".$reg['cantidad']."&medicamento=".urlencode($reg['medicamento'])."&presentacion=".urlencode($reg['presentacion'])."&total=".$total."&fecha_receta=".$fecha_receta."&num_cierre=".$num_cierre."&num_receta=".$num_receta_param."&precio=".$reg['precio']."&renglon=".$reg['renglon']."&observaciones=".$reg['observaciones']."'>AUDITAR</a>
            <a class='actualizar' href='actualizacion.php?num_cierre=" . $num_cierre . "&num_receta=" . $num_receta_param . "&renglon=" . $reg['renglon'] . "'>ACTUALIZAR</a></td>";
        }

        echo "</tr>"; 
    }
    ?>
</tbody>
            </table>
        </div>                    
        <br>
        <div class="form-group">
            <a href="auditoria_cierres_detalle.php?num_cierre=<?php echo base64_encode($num_cierre) ?>"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
  $("#buscador").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabla tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>
