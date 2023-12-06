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
$cuit_farm = $_GET['cuit_farm'];
$num_cierre = $_GET['num_cierre'];
$total_tf = 0; // Variable para mantener el total de tf
$periodo = '20231002'; // Período predeterminado, puedes cambiarlo según tus necesidades

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Incluir Recetas / Farmacia:  <?php echo $cuit_farm ?></h5><br>
        <div class = "header-elements">
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
                    include('inc/conexion.php');
                    $registros = mysqli_query($conexion, "SELECT v.num_receta, SUM(d.cantidad * d.precio) AS total_receta
                        FROM validaciones v
                        JOIN detalle_recetas d ON v.num_receta = d.num_receta
                        WHERE v.cuit_farm = '$cuit_farm' AND v.cierre = 0
                        GROUP BY v.num_receta
                        ORDER BY v.num_receta ASC");
                    while ($reg = mysqli_fetch_array($registros)) {
                        $tf = $reg['total_receta']; // Total de la receta

                        echo "<tr>"
                            . "<td><span class='badge bg-success-400'>" . $reg['num_receta'] . "</span></td>"
                            . "<td><span class='badge bg-danger-400'>$ " . number_format($tf, 2) . "</span></td>"
                            . "<td>
                                <form method='GET' action='agregar_receta.php'>
                                    <input type='hidden' name='periodo' value='$periodo'>
                                    <input type='hidden' name='num_cierre' value='$num_cierre'>
                                    <input type='hidden' name='cuit_farm' value='$cuit_farm'>
                                    <input type='hidden' name='num_receta' value='" . $reg['num_receta'] . "'>
                                    <input type='hidden' name='total' value='$tf'>
                                    <button type='submit' class='btn btn-danger' name='incluir_receta'>+ Incluir</button>
                                </form>
                            </td>"
                            . "</tr>";
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
echo "<td> $ " . number_format($total_tf, 2) . "</td>";
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
    XLSX.writeFile(wb, 'validaciones_farmacia.xlsx');
});
</script>
<script>
$(document).ready(function () {
    $("#buscador").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#tabla tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
</html>
