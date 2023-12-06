<?php
include('inc/header.php');
include('inc/panel.php');
include('inc/conexion.php');
session_start();
$dni = $_SESSION['dni'];
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<!-- Content area -->
<div class="content">
    <!-- Form validation -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Buscar Periodo</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        <button id="exportToExcel" class="btn btn-success">Exportar a Excel</button>
        </div>
         <div class="col-md-2">
        <h5 class="card-title"><h5 class="card-title"><a href="auditado_total_debitos.php"><button type="button" class="btn btn-danger"> Auditado - Debitos</button></a> </h5>
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

            <div class="click2edit">
                <div class="row">
                    <form name="form1" method="POST" action="auditoria_cierre.php" id="cdr">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-6">Buscar Periodo</label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <select class="form-control" id="periodo" name="busca">
                                        <option value="">Selecciona un Periodo</option>
                                        <?php
                                        $query = "SELECT DISTINCT periodo FROM cierres_lotes ORDER BY periodo DESC";
                                        $result = mysqli_query($conexion, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $periodo = $row['periodo'];
                                            echo "<option value='$periodo'>$periodo</option>";
                                        }
                                        mysqli_free_result($result);
                                        ?>
                                    </select>
                                    <span class="input-group-prepend">
                                        <button type="submit" class="btn btn-primary btn-icon"><i class="icon-search4"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-hover datatable-highlight">
                <thead>
                    <tr class="bg-dark">
                        <th>Periodo</th>
                        <th>Numero de Cierre</th>
                        <th>Cuit Farmacia</th>
                        <th>Farmacia</th>
                        <th>Recetas</th>
                        <th>Total Facturado</th>
                        <th>T/OS</th>
                        <th>Fecha de Cierre</th>
                        <th>Opciones</th>

                    </tr>
                </thead>
                <tbody id="tabla_resultados">
                    <?php
                    if (isset($_POST['busca'])) {
                        $busca = $_POST['busca'];

                        $query = "SELECT a.periodo, a.num_cierre, a.cuit_farm, a.cant_recetas, a.tf, a.tos, a.ano, a.mes, a.dia, a.hora, a.minuto, b.cuit, b.farmacia, b.idsucursal, b.id
                                  FROM cierres_lotes a
                                  LEFT JOIN users b ON a.cuit_farm = b.cuit AND a.suc_farm = b.idsucursal
                                  WHERE a.periodo LIKE '%" . $busca . "%'";

                        $busqueda = mysqli_query($conexion, $query);

                        $total_tf = 0; // Variable para almacenar la suma del importe 'tf'

                        while ($f = mysqli_fetch_array($busqueda)) {
                            $num_cierre_encoded = base64_encode($f['num_cierre']);
                            $farmacia = urlencode($f['farmacia']);
                            $cuit_farm = urlencode($f['cuit_farm']);
                            $suc = urlencode($f['idsucursal']);

                            echo "<tr>"
                                . "<td>" . $f['periodo'] . "</td>"
                                . "<td><span class='badge bg-danger-400'>" . $f['num_cierre'] . "</span></td>"
                                . "<td><span class='badge bg-primary-400'>" . $f['cuit_farm'] . "</span></td>"
                                . "<td><span class='badge bg-primary-400'>" . $f['farmacia'] . "-" . $f['idsucursal'] . "</span></td>"
                                . "<td><span class='badge bg-danger-400'>" . $f['cant_recetas'] . "</span></td>"
                                . "<td><span class='badge bg-danger-400'>" . $f['tf'] . "</span></td>"
                                . "<td><span class='badge bg-danger-400'>" . $f['tos'] . "</span></td>"
                                . "<td><span class='badge bg-danger-400'>" . $f['dia'] . "/" . $f['mes'] . "/" . $f['ano'] . "</span></td>"
                                . "<td>" . "<a target='_blank' href='comprobantecierrepdf.php?num_cierre=$num_cierre_encoded&farmacia=$farmacia&cuit_farm=$cuit_farm&suc=$suc'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-file-pdf'></i></button></a>
                                            <a href='auditoria_cierres_detalle.php?num_cierre=$num_cierre_encoded&cuit_farm=$cuit_farm'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-list2'></i></button></a>
                                            <a target='_blank' href='cierre_detalle.php?num_cierre=$num_cierre_encoded'><button type='button' class='btn bg-primary-400 btn-icon '><i class='icon-checkmark4'></i></button></a>
                                        </td>"
                                . "</tr>";

                            // Agrega el importe 'tf' a la suma total
                            $total_tf += $f['tf'];
                        }

                        // Agrega una fila al final de la tabla para mostrar el total del importe 'tf'
                        echo '<tr><td colspan="5"></td><td><strong>Total : ' . number_format($total_tf, 2) . '</strong></td><td colspan="2"></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
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
    XLSX.writeFile(wb, 'reporte_auditoria_cierre.xlsx');
});
</script>



<script>
$(document).ready(function(){
    $("#buscador").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla_resultados tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

<?php 
include('inc/conexion.php');
$num_receta = base64_decode($_GET['num_receta']);
$lista7 =("SELECT * FROM validaciones
WHERE validaciones LIKE '$validaciones' LIMIT 1");
$rs7 = mysqli_query($conexion,$lista7);
$row7 = mysqli_fetch_array($rs7); 
$validaciones = $row7['validaciones'];

$lista2 =("SELECT MAX(num_receta) as num_receta FROM validaciones");
$rs2 = mysqli_query($conexion,$lista2);
$row = mysqli_fetch_array($rs2); 
$num_receta = $row['num_receta'] + 1;
?>


