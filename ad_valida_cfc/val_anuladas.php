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
        <h5 class="card-title">Total de Resgistros Anulados por Farmacia</h5><br>
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
                        <th>N de Receta</th>
                        <th>N de Validacion</th>
                        <th>Cuit Farm</th>
                        <th>Sucursal</th>
                        <th>Fecha</th>
                       

                       
                    </tr>
                </thead>
                <tbody id="tabla">
                    <?php
                    include ('inc/conexion.php');
                $registros = mysqli_query($conexion, "SELECT * FROM validaciones_anuladas ORDER BY id DESC
                                      ");
                    while ($reg=mysqli_fetch_array($registros)){  
                        echo "<tr>"
                        ."<td>".$reg['num_receta']."</span></td>"
                        ."<td>".$reg['num_validacion']."</td>"
                        ."<td>".$reg['cuit_farm']."</td>"
                        ."<td>".$reg['suc_farm']."</td>"
                        ."<td>".$reg['fec']."</span></td>"  

                        ."</tr>"; 

                    }


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
    XLSX.writeFile(wb, 'validaciones_anuladas.xlsx');
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
