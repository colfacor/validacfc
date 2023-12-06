<?php 
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
$cuit_farm = $_GET['cuit_farm'];
$total_tf = 0; // Variable para mantener el total de tf

?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Detalle Cierre:  <?php echo $num_cierre ?></h5><br>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>      
    </div>

         <div class="col-md-2">
        <button id="exportToExcel" class="btn btn-danger">Exportar a Excel</button>
      </div><hr>
       <div class="col-md-2">
        <button class="btn btn-danger" onclick="redireccionar()">+ Incluir Receta</button>
      </div>

    <div class="card-body">
         <div class="form-group row">   
            <div class="col-md-2">          
            </div>
            <div class ="col-md-2">
            </div>
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">          
            </div>
            <div class="col-md-2">      
            </div>
            <div class="col-md-2">
                <input type="text" name="caja_busqueda" id="buscador" class="form-control rounded-round" placeholder="Buscar...."></input>
            </div>
      </div>    
    
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable-highlight">
            <thead>
                <tr class="bg-dark">
                    <th>Receta</th>
                    <th>Total</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
                <tbody id="tabla">
                <?php
                include ('inc/conexion.php');
                $registros = mysqli_query($conexion," SELECT a.num_cierre, a.num_receta, a.tf, b.dni_afi, b.fecha_receta, c.apellido, c.nombre, f.num_validacion
                                                        FROM detalle_cierres a
                                                        LEFT JOIN recetas b 
                                                        ON a.num_receta = b.num_receta
                                                        LEFT JOIN pad_psicotropicos c 
                                                        ON b.dni_afi = c.dni
                                                        LEFT JOIN detalle_recetas d 
                                                        ON d.num_receta = b.num_receta
                                                        LEFT JOIN vade_psicotropicos e 
                                                        ON d.troquel = e.troquel
                                                        LEFT JOIN validaciones f 
                                                        ON a.num_receta = f.num_receta
                                                        WHERE a.num_cierre = '$num_cierre'
                                                        GROUP BY a.num_receta, a.tf, b.dni_afi, b.fecha_receta, c.apellido, c.nombre, f.num_validacion
                                                        ORDER BY a.num_receta ASC");
                while ($reg=mysqli_fetch_array($registros)){  
                    $tf = $reg['tf'];
                    $total_tf += $tf; // Suma el valor de tf al total

                    echo "<tr>"
                    ."<td><span class='badge bg-success-400'>".$reg['num_receta']."</span></td>"
                    ."<td><span class='badge bg-danger-400'>$ ".number_format($tf, 2)."</span></td>"
                    ."<td>"."<a href='cierres_detalle_receta.php?num_receta=".base64_encode($reg['num_receta'])."&num_cierre=".base64_encode($reg['num_cierre'])."'><span class 'badge bg-info-400'>VER DETALLE</span></a>
                    <a target='_blank' href='../comprobantepdf.php?num_validacion=".base64_encode($reg['num_validacion'])."'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
                    <a href='excluir_receta.php?num_receta=" . $reg['num_receta'] . "&num_cierre=" . $num_cierre . "&tf=" . $tf . "&cuit_farm=" . $cuit_farm . "'><button type='button' class='btn bg-danger-400 btn-icon'>Excluir<i class='icon-delete-pdf'></i></button></a>
                    </td>"
                    ."</tr>";  
                }
                ?>
                </tbody>
            </table>
        </div>                    
        <br>
        <div class="form-group">
            <a href="auditoria_cierre.php"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
        </div>
    </div>
</div>

<?php
echo "<tr>";
echo "<td>Total</td>";
echo "<td> $ ".number_format($total_tf, 2)."</td>";
echo "<td></td>";
echo "</tr>";
?>

<script>
document.getElementById('exportToExcel').addEventListener('click', function () {
    // Recopila los datos de la tabla que deseas exportar
    const table = document.querySelector('.table');
    const ws = XLSX.utils.table_to_sheet(table);

    // Crea un libro y agrega la hoja de cálculo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Hoja1');

    // Guarda el archivo Excel
    XLSX.writeFile(wb, 'reporte_auditoria_cierredetalle.xlsx');
});
</script>
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

<script>
function redireccionar() {
    var num_cierre = '<?php echo $num_cierre; ?>';
    var cuit_farm = '<?php echo $cuit_farm; ?>';
    window.location.href = 'validacion_incluir.php?num_cierre=' + num_cierre + '&cuit_farm=' + cuit_farm;
}
</script>

