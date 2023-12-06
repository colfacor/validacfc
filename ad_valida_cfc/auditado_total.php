<?php
$num_receta = base64_decode($_GET['num_receta']);
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
$num_receta = $_GET['num_receta'];
$num_cierre = $_GET['num_cierre'];

?>

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Numero Receta: <?php echo $num_receta ?></h5><br>
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
                        <th>Cant</th>
                        <th>Medicamento</th>
                        <th>Presentación</th>
                        <th>Numero Receta</th>
                        <th>Renglon</th>
                        <th>Total Farmacia</th>
                        <th>Debito</th>
                        <th>Total Auditado</th>
                        <th>Fecha Receta</th>
                        <th>Fecha Auditado</th>
                        <th>Observaciones</th>
                        <th>Auditor</th>

                       
                    </tr>
                </thead>
                <tbody id="tabla">
                    <?php
                    include ('inc/conexion.php');
                $registros = mysqli_query($conexion, "SELECT * FROM auditoria
                                      ");
                    while ($reg=mysqli_fetch_array($registros)){  
                        echo "<tr>"
                        ."<td>".$reg['cantidad']."</span></td>"
                        ."<td>".$reg['medicamento']."</td>"
                        ."<td>".$reg['presentacion']."</td>"
                        ."<td><span class='badge bg-primary-400'>".$reg['num_receta']."</span></td>"
                        ."<td><span class='badge bg-primary-400'>".$reg['renglon']."</span></td>"
                        ."<td>".number_format($reg['precio'],2)."</td>"
                        ."<td><span class='badge bg-danger-400'>".$reg['debito']."</span></td>"
                        ."<td><span class='badge bg-success-400'>".$reg['total_auditado']."</span></td>"
                        ."<td>".$reg['fecha_receta']."</td>"
                        ."<td>".$reg['fecha_auditoria']."</span></td>"
                        ."<td>".$reg['observaciones']."</span></td>"
                        ."<td>".$reg['auditor']."</span></td>"
                     
                      

                     

                        ."</tr>"; 
                    }
                    ?>

                </tbody>
            </table>
        </div>                    
        <br>
        <div class="form-group">
            <a href="cierres_detalle_receta.php?num_receta=<?php echo base64_encode($num_receta) ?>&num_cierre=<?php echo base64_encode($num_cierre); ?>"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
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
