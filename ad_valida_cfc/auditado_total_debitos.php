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

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>


<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Total de Resgistros Auditados</h5><br>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>       
    </div>
    <div class="col-md-2">
        <button id="exportToExcel" class="btn btn-success">Exportar a Excel</button>
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
                        ."<td>".$reg['precio']."</td>"
                        ."<td><span class='badge bg-danger-400'>".$reg['debito']."</span></td>"
                        ."<td><span class='badge bg-success-400'>".$reg['total_auditado']."</span></td>"
                        ."<td>".$reg['fecha_receta']."</td>"
                        ."<td>".$reg['fecha_auditoria']."</span></td>"
                        ."<td>".$reg['observaciones']."</span></td>"
                        ."<td>".$reg['auditor']."</span></td>"
                     
                      

                     

                        ."</tr>"; 

                        $total_precio += $reg['precio'];
                        $total_debito += $reg['debito'];
                        $total_auditado += $reg['total_auditado'];
                    }

                    echo '<tr><td colspan="5"></td><td><strong>Total Farmacia : ' . number_format($total_precio, 2) . '</strong></td><td colspan="2"></td></tr>';
                    echo '<tr><td colspan="5"></td><td><strong>Total Debito : ' . number_format($total_debito, 2) . '</strong></td><td colspan="2"></td></tr>';
                    echo '<tr><td colspan="5"></td><td><strong>Total Auditado : ' . number_format($total_auditado, 2) . '</strong></td><td colspan="2"></td></tr>';

                    ?>

                </tbody>
            </table>
        </div>                    
        <br>
        <div class="form-group">
         <a href="auditoria_cierre.php">  <button class="btn btn-success">  Volver</button></a>
        </div>
    </div>
</div>

<script>
document.getElementById('exportToExcel').addEventListener('click', function () {
    // Recopila los datos de la tabla que deseas exportar
    const table = document.querySelector('.table');
    const ws = XLSX.utils.table_to_sheet(table);

    // Crea un libro y agrega la hoja de cálculo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Hoja1');

    // Guarda el archivo Excel
    XLSX.writeFile(wb, 'reporte_auditado_total_debitos.xlsx');
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
</body>
</html>
