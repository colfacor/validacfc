<?php 
include('inc/header.php');
include('inc/panel.php');
$cantidad = $_GET['cantidad'];
$medicamento = urldecode($_GET['medicamento']);
$presentacion = urldecode($_GET['presentacion']);
$fecha_receta = $_GET['fecha_receta'];
$num_receta = $_GET['num_receta'];
$renglon = $_GET['renglon'];
$observaciones = $_GET['observaciones'];
$precio = $_GET['precio'];
$debito = $_GET['debito'];
$total = $_GET['total'];
$num_cierre = $_GET['num_cierre'];
$fecha_auditoria = date("Y-m-d");
$auditor = $_SESSION['dni'];
?>

<!-- Content area -->
<div class="content">

    <!-- /table header styling -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="header-elements">
                <div class="list-icons">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="cierres_detalle_receta_insert_.php">
            <fieldset class="mb-3">
            <legend class="text-uppercase font-size-sm font-weight-bold">Datos de la Farmacia</legend>
            <div class="form-group row">
               <div class="col-3">
                <strong>CANTIDAD </strong> <input type="text" class="form-control" name="cantidad" value="<?php echo $cantidad ?>">
            </div>
            <div class="col-3">
                <strong>MEDICAMENTO </strong> <input type="text" class="form-control" name="medicamento" value="<?php echo $medicamento ?>" readonly>
            </div>
            <div class="col-3">
                <strong>PRESENTACIÓN</strong> <input type="text" class="form-control" name="presentacion" value="<?php echo $presentacion;?>" readonly>
            </div>

            </div>  
            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-3">
                            <strong>N RECETA</strong> <input type="text" class="form-control" name="num_receta" value="<?php echo $num_receta;?>" readonly>
                        </div>
                        <div class="col-3">
                            <strong>N CIERRE</strong> <input type="text" class="form-control" name="num_cierre" value="<?php echo $num_cierre;?>" readonly>
                        </div>
                        <div class="col-2">
                            <strong>RENGLON</strong> <input type="text" class="form-control" name="renglon" value="<?php echo $renglon;?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="row">
                      <div class="col-3">
                        <strong>PRECIO</strong> <input type="text" class="form-control" name="precio" id="precio" value="<?php echo $total;?>" readonly>
                    </div>
                    <div class="col-3">
                        <strong>DEBITO</strong> <input type="text" class="form-control" name="debito" id="debito" value="<?php echo $debito;?>" >
                    </div>
                    <!--<div class="col-3">
                        <strong>INCREMENTO</strong> <input type="text" class="form-control" name="incremento" id="incremento" value="<?php echo $incremento;?>" >
                    </div>-->
                    <div class="col-3">
                        <strong>TOTAL AUDITADO</strong> <input class="form-control" type="text" name="total_auditado" id="total_auditado" value="" >
                    </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-3">
                        <strong>OBSERVACIONES</strong>  
                            <input class="form-control" type="text" name="observaciones" value="<?php echo $observaciones;?>" >
                        </div>
                        <div class="col-3">
                            <strong>AUDITOR</strong> <input class="form-control" type="text" name="auditor" value="<?php echo $auditor;?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
             <div class="form-group row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-3">
                        <strong>FECHA RECETA</strong>  
                            <input class="form-control" type="text" name="fecha_receta" value="<?php echo $fecha_receta;?>" readonly>
                        </div>
                        <div class="col-3">
                            <strong>FECHA AUDITADA</strong> <input class="form-control" type="text" name="fecha_auditoria" value="<?php echo $fecha_auditoria;?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>
            <div class="text-left">
                <button type="submit" class="btn btn-danger">Cargar<i class="icon-floppy-disk ml-2"></i></button>
                 <a href="auditoria_cierres_detalle.php?num_cierre=<?php echo base64_encode($num_cierre) ?>"><button type="button" id="volver" class="btn btn-secondary"> Volver</button></a>
            </div>
            </form>
        </div>          
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Obtén los elementos de precio, débito, incremento y total auditado
    var precioInput = $("#precio");
    var debitoInput = $("#debito");
    var incrementoInput = $("#incremento");
    var totalAuditadoInput = $("#total_auditado");

    // Función para calcular el total auditado
    function calcularTotalAuditado() {
        var precio = parseFloat(precioInput.val()) || 0;
        var debito = parseFloat(debitoInput.val()) || 0;
        var incremento = parseFloat(incrementoInput.val()) || 0;
        var totalAuditado = precio - debito + incremento;

        // Actualiza el valor del campo Total Auditado
        totalAuditadoInput.val(totalAuditado.toFixed(2));
    }

    // Calcula el total auditado cuando cambian los valores de precio, débito o incremento
    precioInput.on("change", calcularTotalAuditado);
    debitoInput.on("change", calcularTotalAuditado);
    incrementoInput.on("change", calcularTotalAuditado);

    // Calcula el total auditado inicialmente
    calcularTotalAuditado();
});
</script>
